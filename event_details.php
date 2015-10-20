<section id="inhalttitel">Event-Teilnahme</section>
		<article>
		<?php
		## Username aus DB auslesen ##
				$sql = $db->query("SELECT * FROM user WHERE user_email = '$loginuser'");		
				while($row = $sql->fetch_object())
						{	
		?>
		<p><b>Hallo <?php echo $row->user_vorname . " " . $row->user_name ; }?></b></p>
		
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
			?>	<!-- WELCOME TEXT -->
				<p>Willkommen beim TerminBot. Du wurdest zu diesem Event eingeladen. 
				Bitte bestätige deine Termine und Optionen. Falls du Fragen oder sonstige Anliegen haben solltest,
				kannst du diese weiter unten bei den Kommentaren loswerden.</p>
				<!-- ENDE WELCOME TEXT -->
				
				<?php	/* Datum und Zeit setzen */	
					$anmeldeschluss = strftime("%A, %d. %B %Y",(strtotime($row->event_deadline))); // umwandlung für korrekte ausgabe
					$deadline = date("Y-m-d",(strtotime($row->event_deadline))); // umwandlung fürs umrechnen
					
					/* heutiges datum setzten und fürs rechnen formatieren */
					$timestamp = time();			
					$heute = date("Y-m-d",$timestamp);		
					
					/* Anzahl verbleibene Tage berechnen */
					$datetime1 = date_create($heute);
					$datetime2 = date_create($deadline);
					$datumdiff = date_diff($datetime1, $datetime2);
				?>
					<p>Veranstalter: <b><?php echo $row->user_vorname . " " . $row->user_name; ?></b></p>
					<p>Anmeldeschluss ist am <b><?php echo $anmeldeschluss;?></b>
				
				<?php
				if ($deadline > $heute)
				{
					echo "<br>Noch <b>" . $datumdiff->format('%r%a Tage') . "</b> bis Anmeldeschluss.";
				}
				else
				{
					if ($deadline == $heute)
					{
						echo "<br><b>Heute ist Anmeldeschluss.</b>";
					}
					else
					{
						echo "<br>Anmeldeschluss war bereits vor <b>" . $datumdiff->format('%a Tagen.') . "</b>";
					}
				}?>
				
				
				<form>
					<ul class="formstyle">
						<li>
							<label>Direktlink</label>
							<input type="text" autofocus readonly name="event_link" class="feld-direktlink" value="http://localhost/terminbot/index.php?section=event&link=<?php echo $getlink;?>"/>
						</li>
					</ul>
				</form>
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
						<div id="map_canvas"></div>  
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
			</table>
			
			<br>
			<article>
				<section id="inhalttitel">Beschreibung:</section>
				<p><?php echo $row->event_beschreibung; ?></p>
			</article>


			<?php	
			}
			?>

			<article>
				<section id="inhalttitel">Termine & Optionen</section>
			<?php
			if ($deadline >= $heute)
			{
				if(!isset($_GET["page"])) /****************************************************************** Termine **********************************************************/
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
				<section id="spezialbereich">		
					<table>
						<tr>
							<th align="left">Auswahltermine</th>
							<th width="10%">Zeit</th>
							<th width="15%">OK</th>
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
						?>
						<tr onMouseover="this.bgColor='#aaaaaa'" onMouseout="this.bgColor='transparent'">
							<td>
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
							<td  colspan="3">
								<input class="buttonstyle" type="submit" value="Daten speichern" />	
							</td>
						</tr>
					</table>
										
					</form>
				</section>		
				<?php
				}
				if(isset($_GET["page"])) 
				{
					if($_GET["page"] == "2") 
					{				
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
						// Pruefen ob der Eintrag erfolgreich war
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
					</article></section>	
				
						<?php
						
						}	
					}
				}

			?>				
				<?php /****************************************************************** OPTIONEN **********************************************************/
				if(!isset($_GET["optionen"])) 
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
				<section id="spezialbereich">
					<table>
							<tr>
								<th align="left">Zusatz-Optionen</th>
								<th width="10%"></th>
								<th width="15%">OK</th>
							</tr>
						<form method="post" action="index.php?<?php echo "section=event&link=" . $getlink . "&optionen"; ?>=2">
						
						<?php # Auslesen der Auswahl-Daten
						$sql = $db->query('SELECT
											optionen.optionen_id,
											optionen.optionen_option,
											event.event_id,
											event.event_link
										FROM 
											optionen
										JOIN 
											event 
										ON 
											(optionen.fk_event_id = event.event_id)
										WHERE 
											event_link = "' . $getlink . '"');
											
						while($row = $sql->fetch_object())
						{
							?>
							<tr onMouseover="this.bgColor='#aaaaaa'" onMouseout="this.bgColor='transparent'">
								<td>
									<?php echo $row->optionen_option; ?>
								</td>
								<td></td>
								<td width="10%" align="center">
									<input type="checkbox" class="checkbox" name="<?php /* datum id auslesen */ echo $row->optionen_id;?>"/>
									<input readonly hidden type="number" name="optionen_id" value="<?php /* datum id auslesen */ echo $row->optionen_id;?>" class="feld-halbiert" />
								</td>
							</tr>
						<?php
						}
						?>
							<tr>
								<td  colspan="3">
									<input class="buttonstyle" type="submit" value="Daten speichern" />	
								</td>
							</tr>
						</table>
					</form>
				</section>
				</article>
				
				<?php
				}
				if(isset($_GET["optionen"])) 
				{
					if($_GET["optionen"] == "2") 
					{
					?>
					<article>
						<section id="inhalttitel">Optionen</section>
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
					foreach ($_POST as $key_optionen => $value_optionen) 
					{
					if ($key_optionen!="optionen_id")
						{	
						$sql = 'INSERT INTO optionen_has_user (`fk_optionen_id`, `fk_user_id`) VALUES (?, ?)';
						$eintrag = $db->prepare($sql);
						$eintrag->bind_param( 'ii', $key_optionen, $fk_user_id);
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
								<p>Zusatz-Optionen wurden gespeichert.</p>
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
								<p>Optionen bereits eingetragen oder Fehler im System.<br> Bitte versuche es später noch einmal.</p>
							</section>
							<!--<meta http-equiv="refresh" content="3; URL=index.php?<?php// echo "section=event&link=" . $getlink . "&page"; ?>=3" />-->
					</article>
						<?php
						
						}	
					}
				}
			}
			else
			{
				echo "<p>Anmeldeschluss war bereits vor <b>" . $datumdiff->format('%a Tagen.') . "</b>";
			}		
			?>
			<article>
				<table>
					<tr>
						<td class="verticaltop-links">
							<section id="inhalttitel">Teilnehmer</section>
							<?php
							/* Ausgabe Teilnehmer Datum */
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
							{  		/* Ausgabe Anzahl Teilnehmer pro Datum */
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
														

										/* Ausgabe Teilnehmer Namen */
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
											echo "<li>" . $rownamen->user_vorname . " " . $rownamen->user_name . "</li>";
										}
									echo "</ul><br>";
							}
							?>				
						</td>
						<td class="verticaltop-rechts">
							<section id="inhalttitel">Optionen</section>
							<?php
							/* Ausgabe Optionen */
							$sql = $db->query('SELECT distinct
													optionen.optionen_id,
													optionen.optionen_option
												FROM 
													optionen
												JOIN 
													event 
												ON 
													(optionen.fk_event_id = event.event_id)
												JOIN 
													optionen_has_user 
												ON 
													(optionen_has_user.fk_optionen_id = optionen.optionen_id)
												JOIN 
													user
												ON 
													(user.user_id = optionen_has_user.fk_user_id)
												WHERE 
													event_link = "' . $getlink . '"');
							while($row = $sql->fetch_object())
							{		/* Ausgabe Anzahl Teilnehmer pro Option */
									$sqlcount = $db->query('SELECT count(user.user_vorname)
																FROM 
																	optionen
																JOIN 
																	event 
																ON 	
																	(optionen.fk_event_id = event.event_id)
																JOIN 
																	optionen_has_user 
																ON
																	(optionen_has_user.fk_optionen_id = optionen.optionen_id)
																JOIN
																	user
																ON 
																	(user.user_id = optionen_has_user.fk_user_id)
																WHERE 	
																	event_link = "' . $getlink . '" AND optionen_option = "' . $row->optionen_option . '" ');

									$rowcount = $sqlcount->fetch_row();

									echo "<b>" . $row->optionen_option . " </b>(" . $rowcount[0] . ")<br><ul>";
														

										/* Ausgabe Optionen Namen */
										$sqlnamen = $db->query('SELECT
																	user.user_vorname,
																	user.user_name
																FROM 
																	optionen
																JOIN 
																	event 
																ON 
																	(optionen.fk_event_id = event.event_id)
																JOIN 
																	optionen_has_user 
																ON 
																	(optionen_has_user.fk_optionen_id = optionen.optionen_id)
																JOIN 
																	user
																ON 
																	(user.user_id = optionen_has_user.fk_user_id)
																WHERE 
																	event_link = "' . $getlink . '" AND optionen_option = "' . $row->optionen_option . '" ');
										while($rownamen = $sqlnamen->fetch_object())
										{
											echo "<li>" . $rownamen->user_vorname . " " . $rownamen->user_name . "</li>";
										}
									echo "</ul><br>";
							}
							?>
						</td>
					</tr>
				</table>
			</article>
			<article>
				<?php
				/* user_id des kommentators auslesen */
				$sql = $db->query("SELECT user_id, user_email FROM user WHERE user_email = '$loginuser'");		
				while($row = $sql->fetch_object())
						{	$user_id = $row->user_id; }
						
				/* event_id des events auslesen */		
				$sql = $db->query("SELECT event_id, fk_user_id FROM event WHERE event_link = '$getlink'");		
				while($row = $sql->fetch_object())
						{	$event_id = $row->event_id;	} /* event_id des events auslesen */
				
				/* Datum und Zeit setzen */		
				$date = date_create(); 
					
				/* anzahl kommentare auslesen */
				$sqlanzahlkommentare = $db->query("SELECT COUNT(fk_event_id) FROM kommentare WHERE fk_event_id = '$event_id'");		
				$anzahlkommentare = $sqlanzahlkommentare->fetch_row();

				echo "<section id='inhalttitel'>Fragen & Kommentare (" . $anzahlkommentare[0] . ")</section>";
				
				$kommentarNummerierung = 1;
				
				$sql = $db->query('SELECT 					
										kommentare.kommentare_datumzeit,
										kommentare.kommentare_kommentar,
										kommentare.fk_user_id AS kommentarID,
										user.user_id,
										user.user_vorname,
										user.user_name,
										user.user_email,
										event.event_link,
										event.fk_user_id  AS eventID
									FROM
										kommentare
									JOIN
										user
									ON
										(kommentare.fk_user_id = user.user_id)
									JOIN
										event
									ON
										(kommentare.fk_event_id = event.event_id)
									WHERE
										event_link = "' . $getlink . '"
									ORDER BY kommentare_datumzeit ASC');
				
				while($row = $sql->fetch_object())
							{
							$KommentarDatumZeit = date("d.m.Y - H:i",(strtotime($row->kommentare_datumzeit))); /* DatumZeit umwandeln */ 
								if ($row->eventID == $row->kommentarID)
								{
								?>	
									<section id="kommentarbereichVeranstalter">
										<article>
											<table>
												<tr>
													<th align="left"><?php echo $kommentarNummerierung . ".";?></th>
													<td align="left"><?php echo "<b>" . $row->user_vorname . " " . $row->user_name . "</b> - Veranstalter";?></td>
													<th align="right"><?php echo $KommentarDatumZeit . " Uhr";?></th>
												</tr>
												<tr>
													<td colspan="3"><?php echo $row->kommentare_kommentar;?></td>
												</tr>
											</table>
										</article>
									</section>					
								<?php
								}
								else
								{
								?>	
									<section id="kommentarbereich">
										<article>
											<table>
												<tr>
													<th align="left"><?php echo $kommentarNummerierung . ".";?></th>
													<th align="left"><?php echo $row->user_vorname . " " . $row->user_name;?></th>
													<th align="right"><?php echo $KommentarDatumZeit . " Uhr";?></th>
												</tr>
												<tr>
													<td colspan="3"><?php echo $row->kommentare_kommentar;?></td>
												</tr>
											</table>
										</article>
									</section>					
								<?php
								}
							//$date = $row->kommentare_datumzeit;
							
							?>	
					
							<?php
							$kommentarNummerierung++;
							}
				
				 
				if(!isset($_GET["kommentar"])) 
				{


				?>
					<form method="post" action="index.php?<?php echo "section=event&link=" . $getlink . "&kommentar"; ?>=2">
						<ul class="formstyle">
							<li>
								<input hidden readonly type="text" name="user_id" value="<?php /* user_id auslesen */ echo $user_id;?>" class="feld-lang" />
							</li>
							<li>
								<input hidden readonly type="text" name="event_id" value="<?php /* event_id auslesen */ echo $event_id;?>" class="feld-lang" />
							</li>
							<li>
								<input hidden readonly type="datetime" name="kommentare_datumzeit" value="<?php /* event_id auslesen */ echo date_format($date, 'Y-m-d H:i:s');?>" class="feld-lang" />
							</li>
							<li>
								<label>Kommentar</label>
								<textarea required type="text" name="kommentare_kommentar" class="feld-lang feld-textarea"/></textarea>
							</li>
							<li>
								<input type="submit" value="Kommentar senden" />
							</li>
						</ul>
					</form>
				<?php
				}
				if(isset($_GET["kommentar"])) 
				{
					if($_GET["kommentar"] == "2") 
					{
						$user_id = mysqli_real_escape_string($db, $_POST["user_id"]);
						$event_id = mysqli_real_escape_string($db, $_POST["event_id"]);
						$kommentare_datumzeit = mysqli_real_escape_string($db, $_POST["kommentare_datumzeit"]);
						$kommentare_kommentar = mysqli_real_escape_string($db, $_POST["kommentare_kommentar"]);
						
						$sql = 'INSERT INTO kommentare (`kommentare_datumzeit`, `kommentare_kommentar`, `fk_event_id`, `fk_user_id`) VALUES (?, ?, ?, ?)';
						$eintrag = $db->prepare($sql);
						$eintrag->bind_param( 'ssii', $kommentare_datumzeit, $kommentare_kommentar, $event_id, $user_id);
						$eintrag->execute();
						
							// Pruefen ob der Eintrag efolgreich war
							if ($eintrag->affected_rows == 1)
								{
								?>
									<meta http-equiv="refresh" content="0; URL=index.php?<?php echo "section=event&link=" . $getlink; ?>" />
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
					}
				}		
				?>
			</article>