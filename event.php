<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##

/* ######### PHP Datum europäisch ausgeben aus selfphp.com ######### */
function datumEU($date) {
    $d    =    explode("-",$date);
	return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
}
/* ######### PHP Datum europäisch ausgeben ENDE ######### */

/* ######### PHP Datum auf Deutsch ######### */
setlocale(LC_ALL, "de_DE", "de_DE@euro", "deu", "deu_deu", "german") ;
/* ######### PHP Datum auf Deutsch ENDE ######### */ 
session_start();
$getlink = $_GET['link'];

if ($_SESSION['loginname'] == '')
{
?>
	<p>Willkommen beim TerminBot. Dies ist eine erweiterte Eventanmeldeplattform.</p>
	</article>
		<section id="meldungLogin">
			<p id="meldungTitel">Hinweis</p>
			<p>Du hast im Moment keine Berechtigungen ohne Account.</p>
		</section>
	</article>
	
	<?php
	if($_GET["page"] == "log") 
	{
		$direktlink = mysqli_real_escape_string($db, $_POST["direktlink"]);
		$email = strtolower($_POST["email"]);
		$password = sha1($_POST["password"]);

				$control = 0;		
				$sql = $db->query("SELECT * FROM user WHERE user_email = '$email' AND user_password = '$password'");		
				while($row = $sql->fetch_object())
							{
								$control++;
							}
			
	if($control != 0) 
		{
		$_SESSION["loginname"] = $email;
		$verhalten = 1;
		} 	
		else 
		{
			$verhalten = 2;
		}
	}
	?>
</article>
	<section id="inhalttitel">Login</section>

	<?php
	if($verhalten == 0) 
	{
	?>	
		<form method="post" action="index.php?section=event&page=log">
			<ul class="formstyle">
				<li>
					<input hidden readonly type="text" name="direktlink" value="<?php echo $getlink;?>" class="feld-lang" />
				</li>
				<li>
					<label>E-Mail Adresse</label>
					<input required autofocus type="email" name="email" class="feld-lang" />
				</li>
				<li>
					<label>Password</label>
					<input required autocomplete type="password" name="password" class="feld-lang" />
				</li>
				<li>
					<input type="submit" value="Login" />
				</li>
			</ul>
		</form>
	<?php
	}
	if($verhalten == 1) 
	{
	?>
	<section id="meldungOK">
	<p id="meldungTitel">Hinweis</p>
		<p>Login OK.</p>
		<p>Event wird geladen...</p>
	</section>
	<?php
	}

	if($verhalten == 1) 
	{
	?>
		<meta http-equiv="refresh" content="2;<?php echo "URL=index.php?section=event&link=" . $direktlink; ?>">
		<!-- nach login - event aus direktlink anzeigen -->
	<?php
	}

	if($verhalten == 2) 
	{
	?>
	<section id="meldungError">
		<p id="meldungTitel">Error</p>
		<p>Du hast dich nicht richtig eingeloggt! <a href="#" onclick="history.back(); return false">Zurück zum Login</a></p>
	</section>

	<?php
	}	
	?>
</article>
<article>
	<section id="inhalttitel">Registrierung</section>
	<p>Noch kein Account? Bitte hier <a href="index.php?section=registrierung">registrieren</a>.</p>
</article>
<?php
}
else	
{

?>
	<section id="inhalttitel">Event-Teilnahme</section>
	<article>
	<?php
	## Username aus DB auslesen ##
			$sql = $db->query("SELECT * FROM user WHERE user_email = '$loginuser'");		
			while($row = $sql->fetch_object())
					{	
	?>
	<p>Hallo <?php echo $row->user_vorname . " " . $row->user_name ; }?> </p>
	
		<?php # Auslesen der Event-Daten
	$sql = $db->query('SELECT 
						event.event_id,
						event.event_link,
						event.event_titel,
						event.event_beschreibung,
						event.event_ortdetail,
						event.event_ortstrasse,
						event.event_ortplz,
						event.event_ort,
						event.event_deadline,
						user.user_id,
						user.user_vorname,
						user.user_name,
						user.user_email
					FROM 
						event
					JOIN 
						user 
					ON 
						(event.fk_user_id = user.user_id)
					WHERE 
						event_link = "' . $getlink . '"');
						
		while($row = $sql->fetch_object())
		{
		?>
			<p>Willkommen beim TerminBot. Hiermit wurdest Du zu diesen Event eingeladen. 
			Bitte bestätige deine Termine. Falls du Fragen haben solltest,
			kannst du diese weiter unten in den Kommentaren verfassen.</p>
			<p>Veranstalter: <b><?php echo $row->user_vorname . " " . $row->user_name; ?></b></p>
			<p class="titel"><?php echo $row->event_titel; ?></p>
			
			
			
			<?php  
			################################## GOOGLEMAPS ##########################################
			// Adresse in var $adresse zusammenfügen     
			$adresse = $row->event_ortstrasse . ', ' . $row->event_ortplz . ' ' . $row->event_ort; ?> 
			
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

									  // Hier Snazzy Maps style einfügen
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
					<div id="map_canvas" style="width: 100%; height: 250px;"></div>  
				</body>
			</div>
			<table>
				<tr>
					<td id="event_ortdetail" class="spalteklein">Wo:</td><td></td>
					<td><?php echo $row->event_ortdetail; ?></td>
				<tr>
			<tr>
				<td id="event_ortstrasse" class="spalteklein">Strasse:</td><td></td>
				<td><?php echo $row->event_ortstrasse; ?></td>
			<tr>
			<tr>
				<td id="event_ort" class="spalteklein">Ort:</td><td></td>
				<td><?php echo $row->event_ortplz . " " . $row->event_ort; ?></td>
			<tr>
			</tr>
				<td class="spalteklein">Deadline:</td><td></td>
				<td><?php echo datumEU($row->event_deadline); ?></td>
			<tr>
		</table>
		
		<br>
		<article>
			<section id="inhalttitel">Beschreibung:</section>
			<p><?php echo $row->event_beschreibung; ?></p>
		</article>

		
		<?php	
		}
		
		if(!isset($_GET["page"])) 
		{
			/*if - User bereits datum usgewählt -> keine auswahl mehr
			{ 
			?>
			
			<?php
			}
			else - auswahldaten anzeigen
			{
			?>
			
			<?php
			}*/
		?>
		
		<article>
			<section id="inhalttitel">Auswahldatum & Zeit</section>
				<table>
					<tr>
						<th align="left">Datum</th><th>Zeit</th><th>Termin OK</th>
					</tr>
			<form method="post" action="index.php?<?php echo "section=event&link=" . $getlink . "&page"; ?>=2">
			
			<?php # Auslesen der Auswahl-Daten
			$sql = $db->query('SELECT
								terminfindung.terminfindung_id,
								terminfindung.terminfindung_datumzeit,
								event.event_id,
								event.event_link
							FROM 
								terminfindung
							JOIN 
								event 
							ON 
								(terminfindung.FK_event_id = event.event_id)
							WHERE 
								event_link = "' . $getlink . '"
							ORDER BY terminfindung_datumzeit ASC');
								
				while($row = $sql->fetch_object())
				{
					?>
					
					<?php
						$datumumwandlung = strftime("%A, %d. %B %Y",(strtotime($row->terminfindung_datumzeit)));
						$zeitumwandlung = date("H:i",(strtotime($row->terminfindung_datumzeit)));
						//echo $datumumwandlung . " - " . $zeitumwandlung . " Uhr ";?>
					<tr onMouseover="this.bgColor='#aaaaaa'" onMouseout="this.bgColor='transparent'">
						<td width="50%">
							<?php echo $datumumwandlung; ?>
						</td>
						<td align="center">
							<?php echo $zeitumwandlung; ?>
						</td>
						<td align="center">
							<input type="checkbox" class="checkbox" name="<?php /* datum id auslesen */ echo $row->terminfindung_id;?>"/>
							<input readonly hidden type="number" name="terminfindung_id" value="<?php /* datum id auslesen */ echo $row->terminfindung_id;?>" class="feld-halbiert" />
						</td>
					</tr>
				<?php
				}
				?>
					<tr>
						<td></td><td></td>
						<td align="center">
							<ul class="formstyle">
								<li>
									<input type="submit" value="Daten speichern" />
								</li>
							</ul>
						</td>
					</tr>
				</table>
			</form>
		</article>
		<?php
		}
		if(isset($_GET["page"])) 
		{
			if($_GET["page"] == "2") 
			{
			?>
			<article>
				<section id="inhalttitel">Auswahldatum & Zeit</section>
			<?php
			
			/* aktuelle user_id in variable $fk_user_id speichern */
			$sql = $db->query("SELECT user_id, user_email FROM user WHERE user_email = '$loginuser'");
			while($row = $sql->fetch_object())
			{
				$fk_user_id = $row->user_id;
			}
			/* user_id in die session für übergabe speichern */
			$_SESSION['fk_user_id'] = $fk_user_id;
			
			/* auslesen der terminauswahl und in die zwischentabelle schreiben */
			foreach ($_POST as $key => $value) 
			{
			if ($key!="terminfindung_id")
				{	
				$sql = 'INSERT INTO terminfindung_has_user (`fk_terminfindung_id`, `fk_user_id`) VALUES (?, ?)';
				$eintrag = $db->prepare($sql);
				$eintrag->bind_param( 'ii', $key, $fk_user_id);
				$eintrag->execute();
				}			
				//echo "<article>Ausgabe:<br><i>" . $key . "</i> <b>" . ($value ? 1 : 0 ) . "</b>  <u>" . $fk_user_id . "</u></b><br></article>";
			}
			
				// Pruefen ob der Eintrag efolgreich war
			if ($eintrag->affected_rows == 1)
				{
				?>
					<section id="meldungOK">
						<p id="meldungTitel">Hinweis</p>
						<p>Mögliche Termine wurden gespeichert.</p>
					</section>
					<!--<meta http-equiv="refresh" content="1; URL=index.php?<?php //echo "section=event&link=" . $getlink . "&page"; ?>=3" />-->
			</article>
				<?php
				}
			else
				{
				?>
					<section id="meldungError">
						<p id="meldungTitel">Error</p>
						<p>Termine bereits eingetragen oder Fehler im System.<br> Bitte versuche es später noch einmal.</p>
					</section>
					<!--<meta http-equiv="refresh" content="3; URL=index.php?<?php// echo "section=event&link=" . $getlink . "&page"; ?>=3" />-->
			</article>
				<?php
				
				}	
			}
		}
		
		if(isset($_GET["page"])) 
		{
			if($_GET["page"] == "3") 
			{
			//$user_id = mysqli_real_escape_string($db, $_SESSION['fk_user_id']);
			?>
			seite 3 
			<?php
			}
		}
		?>
	<article>
		<table>
			<tr>
				<th>
					<section id="inhalttitel">Teilnehmer</section>
				</th>
				<th>
					<section id="inhalttitel">Optionen</section>
				</th>
			</tr>
			<tr>
				<td>
					<?php
					$sql = $db->query('SELECT distinct
											terminfindung.terminfindung_id,
											terminfindung.terminfindung_datumzeit
										FROM 
											terminfindung
										JOIN 
											event 
										ON 
											(terminfindung.FK_event_id = event.event_id)
										JOIN 
											terminfindung_has_user 
										ON 
											(terminfindung_has_user.fk_terminfindung_id = terminfindung.terminfindung_id)
										JOIN 
											user
										ON 
											(user.user_id = terminfindung_has_user.fk_user_id)
										WHERE 
											event_link = "' . $getlink . '"
										ORDER BY terminfindung_datumzeit ASC');
					while($row = $sql->fetch_object())
					{
							$sqlcount = $db->query('SELECT count(user.user_vorname)
														FROM 
															terminfindung
														JOIN 
															event 
														ON 	
															(terminfindung.FK_event_id = event.event_id)
														JOIN 
															terminfindung_has_user 
														ON
															(terminfindung_has_user.fk_terminfindung_id = terminfindung.terminfindung_id)
														JOIN
															user
														ON 
															(user.user_id = terminfindung_has_user.fk_user_id)
														WHERE 	
															event_link = "' . $getlink . '" AND terminfindung_datumzeit = "' . $row->terminfindung_datumzeit . '" ');

							$rowcount = $sqlcount->fetch_row();
							
							$Teilnehmerdatumumwandlung = date("d.m.Y",(strtotime($row->terminfindung_datumzeit)));
							$Teilnehmerzeitumwandlung = date("H:i",(strtotime($row->terminfindung_datumzeit)));
							echo "<b>" . $Teilnehmerdatumumwandlung . " - " . $Teilnehmerzeitumwandlung . " Uhr </b>(" . $rowcount[0] . ")<br><ul>";
												


								$sqlnamen = $db->query('SELECT
															user.user_vorname,
															user.user_name
														FROM 
															terminfindung
														JOIN 
															event 
														ON 
															(terminfindung.FK_event_id = event.event_id)
														JOIN 
															terminfindung_has_user 
														ON 
															(terminfindung_has_user.fk_terminfindung_id = terminfindung.terminfindung_id)
														JOIN 
															user
														ON 
															(user.user_id = terminfindung_has_user.fk_user_id)
														WHERE 
															event_link = "' . $getlink . '" AND terminfindung_datumzeit = "' . $row->terminfindung_datumzeit . '" ');
								while($rownamen = $sqlnamen->fetch_object())
								{
									echo "<li>" . $rownamen->user_vorname . " " . $rownamen->user_name . "</li><br>";
								}
							echo "</ul><br>";
					}
					?>	
				</td>
				<td>
					...zusatz optionen
				</td>
			<tr>
		</table>
	</article>
	<article>
		<section id="inhalttitel">Fragen & Kommentare</section>
	</article>
<?php
}
?>
	</article>