<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##
session_start();

$direktlink = $_GET['link'];

/* Veranstalter aus Event auslesen und in variable $veranstalteremail speichern */
	$sql = $db->query("SELECT 
						user.user_email,
						event.event_link,
						event.event_status
					FROM 
						event 
					JOIN
						user
					ON
						(event.fk_user_id = user.user_id)
					WHERE event_link = '$direktlink'");		
	while($row = $sql->fetch_object())
			{	
				$veranstalteremail = $row->user_email;
				$event_status = $row->event_status;
			}
				/*echo "<br>veranstaltungsmail: " . $veranstalteremail;
				echo "<br>loginuser: " . $loginuser;*/
				
/* ENDE - Veranstalter aus Event auslesen und in variable $veranstalteremail speichern */

if(!isset($_SESSION["loginname"])) 
{
?>
	<article>
		<section id="meldungError">
			<p id="meldungTitel">Error</p>
			<p>Du hast keine Berechtigungen oder bist nicht eingelogt</p>
			<p>Du musst dich zuerst einloggen: <a href="index.php?section=startseite">Weiter zum Login</a></p>
		</section>
	</article>
<?php	
}	
else
{
	if(!isset($_GET["page"])) 
	{
		if($veranstalteremail != $loginuser)
		{
		?>
			</article>
				<section id="meldungError">
					<p id="meldungTitel">Error</p>
					<p>Du hast keine Berechtigungen um diesen Event zu bearbeiten.</p>
				</section>
			</article>
		<?php
		}
		else
		{
			$_SESSION['veranstalteremail'] = $veranstalteremail;
		
			$sql = $db->query("SELECT 
								event.event_link,
								event.event_titel,
								event.event_beschreibung,
								event.event_ortdetail,
								event.event_ortstrasse,
								event.event_ortplz,
								event.event_ort,
								event.event_deadline,
								event.event_id,
								user.user_email,
								user.user_id,
								user.user_vorname,
								user.user_name
							FROM 
								event 
							JOIN
								user
							ON
								(event.fk_user_id = user.user_id)
							WHERE event_link = '$direktlink'");		
			while($row = $sql->fetch_object())
			{	
			?>
			<table>
				<tr>
					<td>
						<section id="inhalttitel">Eventverwaltung von: <?php echo $row->event_titel;?></section>
						<p>Hallo <?php echo $row->user_vorname . " " . $row->user_name; ?>. Hier kannst du dein Event editieren oder löschen.</p>
					</td>
					<td id="edit">
					</td>
				</tr>
			</table>

					<article>
						<form method="post" action="index.php?section=event_edit&page=2">
							<?php
							if ($event_status != "0")
							{
								if ($event_status == "2")
								{
								?>
									<section id="meldungError">
										<p id="meldungTitel">Event gelöscht</p>
										<p>Dieser Event wurde von Dir gelöscht.</p>
									</section>	
								<?php
								break;
								}
								else
								{
								?>
									<section id="meldungError">
										<p>Dieser Event ist deaktiviert. Somit für Teilnehmer nicht freigegeben.</p>
									</section>
									<table>
										<tr>
											<ul class="formstyle">
												<li>
													<label>Event-Status</label>
												</li>
											</ul>
										</tr>
										<tr>
											<td align="right">
												<input type="radio" name="event_status" id="aktivieren" value="0"><label for="aktivieren">Event aktivieren</label>
											</td>
											<td>
												<input type="radio" name="event_status" id="deaktivieren" value="1" checked ><label for="deaktivieren">Event deaktivieren</label>
											</td>
										</tr>
									</table>
								<?php
								}
							}
							else
							{
							?>
								<section id="meldungOK">
									<p>Dieser Event ist aktiv. Somit für Teilnehmer freigegeben.</p>
								</section>
								<table>
									<tr>
										<ul class="formstyle">
											<li>
												<label>Event-Status</label>
											</li>
										</ul>
									</tr>
									<tr>
										<td align="right">
											<input type="radio" name="event_status" id="aktivieren" value="0" checked><label for="aktivieren">Event aktivieren</label>
										</td>
										<td>
											<input type="radio" name="event_status" id="deaktivieren" value="1"><label for="deaktivieren">Event deaktivieren</label>
										</td>
									</tr>
								</table>		
							<?php
							}
							?>
						
					</article>
					<article>
							<ul class="formstyle">
								<li>
									<label>Direktlink</label>
									<input type="text" readonly name="direktlink" class="feld-direktlink" value="http://localhost/terminbot/index.php?section=event&link=<?php echo $direktlink;?>"/>
									<input type="text" hidden readonly name="event_link" class="feld-lang" value="<?php echo $direktlink;?>"/>
								</li>
								<li>
									<label>Titel</label>
									<input required autofocus type="text" name="event_titel" value="<?php echo $row->event_titel; ?>" class="feld-lang" />
								</li>
								<li>
									<label>Beschreibung</label>
									<textarea required type="text" id="editor1" name="event_beschreibung" class="feld-lang feld-textarea"/><?php echo $row->event_beschreibung; ?></textarea>
										<script>
											// Replace the <textarea id="editor1"> with a CKEditor
											// instance, using default configuration.
											CKEDITOR.replace( 'editor1' );
										</script>
								</li>				
								<li>
									<label>Standort</label>	
									<li><input type="text" required name="event_ortdetail" value="<?php echo $row->event_ortdetail; ?>" class="feld-halbiert" placeholder="Name / Stockwerk / Raum"/>&nbsp;<input type="text" align-right name="event_ortstrasse" value="<?php echo $row->event_ortstrasse; ?>" class="feld-halbiertRechts" placeholder="Strasse" /></li>
									<li><input type="text" required name="event_ortplz" value="<?php echo $row->event_ortplz; ?>" class="feld-halbiert" placeholder="PLZ"/>&nbsp;<input type="text" align-right required name="event_ort" class="feld-halbiertRechts" value="<?php echo $row->event_ort; ?>" placeholder="Ort" /></li>
								</li>
								<li>
										<?php  
											################################## GOOGLEMAPS ##########################################
											// Adresse in var $adresse zusammenfÃ¼gen     
											$adresse = $row->event_ortstrasse .', '. $row->event_ortplz .' '. $row->event_ort; ?> 

											<div class="gmapsstyle">
												<head> 
												<!-- Google Maps Script einbinden --> 
												<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script> 
													<script type="text/javascript"> 
														var geocoder; 
														  var map; 
														$(document).ready(function() { 
															 initialize(); 
															});  

														  function initialize() { 
																geocoder = new google.maps.Geocoder(); 
																var latlng = new google.maps.LatLng(-34.397, 150.644); 
																var myOptions = { 
																	  zoom: 12, 
																	  center: latlng, 

																	  // Hier Snazzy Maps style einfÃ¼gen
																	  styles: [{"stylers":[{"visibility":"on"},{"saturation":-100},{"gamma":0.54}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#0099ff"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"gamma":0.48}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"gamma":7.18}]}]
																} 
																map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 

																codeAddress(); 
															  } 

														function codeAddress() { 
																var address = "<?php echo $adresse; ?>"; 
																geocoder.geocode( { 'address': address}, function(results, status) { 
																  if (status == google.maps.GeocoderStatus.OK) { 
																	map.setCenter(results[0].geometry.location); 
																	var marker = new google.maps.Marker({ 
																			map: map, 
																			position: results[0].geometry.location 
																	}); 
																  } else { 
																	alert("Geocode was not successful for the following reason: " + status); 
																  } 
															}); 
														  }   
													</script> 
												</head> 
												<body onLoad="initialize()">  
													<div id="map_canvas" style="width: 100%; height: 300px;"></div>  
												</body>
											</div>	
								</li>
								<li>
									<label>Anmelde-Deadline</label>
									<input  type="date" name="event_deadline" value="<?php echo $row->event_deadline; ?>" class="feld-lang" />
								</li>
								<li>
									<input type="submit" value="Änderungen speichern" />
								</li>
							</ul>
						</form>
					</article>
					<article>
						<section id="inhalttitel">Event löschen</section>
							<p>Dein Event kann hier gelöscht werden.</p>
						<details>
							<summary>Event löschen</summary><br class="clear"/>
							<form action="index.php?section=event_edit&page=3" method="post">
								<ul class="formstyle">
									<li>
										<input type="text" hidden readonly name="event_status" class="feld-lang" value="2"/>
										<input type="text" hidden readonly name="event_link" class="feld-lang" value="<?php echo $direktlink;?>"/>
									</li>
									<li>
										<input style="width:100%;" type="submit" value="Löschen bestätigen" />
									</li>
								</ul>
							</form>	
						</details>
					</article>
			<?php	
			} /* ENCE - sql select abfrage */
		} /* ENCE - else check veranstalter mit loginuser */
	} /* ENCE - page 1 */
	if(isset($_GET["page"]))
	{
		if($_GET["page"] == "2") 
		{
			$event_status = mysqli_real_escape_string($db, $_POST["event_status"]);
			$event_link = mysqli_real_escape_string($db, $_POST["event_link"]);
			$event_titel = mysqli_real_escape_string($db, $_POST["event_titel"]);
			$event_beschreibung = mysqli_real_escape_string($db, $_POST["event_beschreibung"]);
			$event_ortdetail = mysqli_real_escape_string($db, $_POST["event_ortdetail"]);
			$event_ortstrasse = mysqli_real_escape_string($db, $_POST["event_ortstrasse"]);
			$event_ortplz = mysqli_real_escape_string($db, $_POST["event_ortplz"]);
			$event_ort = mysqli_real_escape_string($db, $_POST["event_ort"]);
			$event_deadline = mysqli_real_escape_string($db, $_POST["event_deadline"]);

			/*echo "<br>hallo page 2 - event_link: " . $event_link . "<br>";
			echo "titel: " . $event_titel . "<br>";
			echo "event_beschreibung: " . $event_beschreibung . "<br>";
			echo "event_ortdetail: " . $event_ortdetail . "<br>";
			echo "event_ortstrasse: " . $event_ortstrasse . "<br>";
			echo "event_ortplz: " . $event_ortplz . "<br>";
			echo "event_ort: " . $event_ort . "<br>";
			echo "event_deadline: " . $event_deadline . "<br>";*/
			
			/* Veranstalter aus Event auslesen und in variable $veranstalteremail speichern */
				$sql = $db->query("SELECT 
									user.user_email,
									event.event_link,
									event.event_status
								FROM 
									event 
								JOIN
									user
								ON
									(event.fk_user_id = user.user_id)
								WHERE event_link = '$event_link'");		
				while($row = $sql->fetch_object())
						{	
							$veranstalteremail = $row->user_email;
						}
							/*echo "<br><br>veranstaltungsmail: " . $veranstalteremail;
							echo "<br>loginuser: " . $loginuser;*/
							
			/* ENDE - Veranstalter aus Event auslesen und in variable $veranstalteremail speichern */
			
			if($veranstalteremail != $loginuser)
			{
			?>
				</article>
					<section id="meldungError">
						<p id="meldungTitel">Error</p>
						<p>Du hast keine Berechtigungen um diesen Event zu bearbeiten.</p>
					</section>
				</article>
			<?php
			}
			else
			{			
				$sql = $db->prepare("UPDATE event SET 
								event_status = ?,
								event_titel = ?, 
								event_beschreibung = ?, 
								event_ortdetail = ?,  
								event_ortstrasse = ?,  
								event_ortplz = ?,  
								event_ort = ?,  
								event_deadline = ?
							   WHERE event_link = ?");
								$sql->bind_param('issssssss', 
												$event_status,
												$event_titel,
												$event_beschreibung,
												$event_ortdetail, 
												$event_ortstrasse,
												$event_ortplz,
												$event_ort,
												$event_deadline,
												$event_link);
								$sql->execute(); 
								$sql->close();
								
				if($sql == true) 
				{
				?>
					<section id="meldungOK">
						<p id="meldungTitel">Hinweis</p>
						<p>Event wurde erfolgreich erstellt.</p>
					</section>
					<meta http-equiv="refresh" content="1; URL=index.php?<?php echo "section=event&link=" . $event_link; ?>" />
				<?php
				}
				else
				{
				?>
					<section id="meldungError">
						<p id="meldungTitel">Error</p>
						<p>Fehler im System. Bitte versuche es später noch einmal.</p>
					</section>
				<?php
				}
			} /* ENCE - else check veranstalter mit loginuser */
		} /* ENCE - page 2 */
	} /* ENCE - Page set */	
	
	if(isset($_GET["page"]))
	{
		if($_GET["page"] == "3") 
{
			$event_status = mysqli_real_escape_string($db, $_POST["event_status"]);
			$event_link = mysqli_real_escape_string($db, $_POST["event_link"]);
			
			/* Veranstalter aus Event auslesen und in variable $veranstalteremail speichern */
				$sql = $db->query("SELECT 
									user.user_email,
									event.event_link,
									event.event_status
								FROM 
									event 
								JOIN
									user
								ON
									(event.fk_user_id = user.user_id)
								WHERE event_link = '$event_link'");		
				while($row = $sql->fetch_object())
						{	
							$veranstalteremail = $row->user_email;
						}
							/*echo "<br><br>veranstaltungsmail: " . $veranstalteremail;
							echo "<br>loginuser: " . $loginuser;*/
							
			/* ENDE - Veranstalter aus Event auslesen und in variable $veranstalteremail speichern */
			
			if($veranstalteremail != $loginuser)
			{
			?>
				</article>
					<section id="meldungError">
						<p id="meldungTitel">Error</p>
						<p>Du hast keine Berechtigungen um diesen Event zu löschen.</p>
					</section>
				</article>
			<?php
			}
			else
			{			
				$sql = $db->prepare("UPDATE event SET 
								event_status = ?
							   WHERE event_link = ?");
								$sql->bind_param('is', 
												$event_status,
												$event_link);
								$sql->execute(); 
								$sql->close();
								
				if($sql == true) 
				{
				?>
					<section id="meldungOK">
						<p id="meldungTitel">Hinweis</p>
						<p>Event wurde erfolgreich gelöscht.</p>
					</section>
					<meta http-equiv="refresh" content="2; URL=index.php?section=startseite" />
				<?php
				}
				else
				{
				?>
					<section id="meldungError">
						<p id="meldungTitel">Error</p>
						<p>Fehler im System. Bitte versuche es später noch einmal.</p>
					</section>
				<?php
				}
			} /* ENCE - else check veranstalter mit loginuser */
		} /* ENCE - page 3 */
	} /* ENCE - Page set */	
} /* ENCE - else Logincheck */
