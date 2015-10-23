<script>
function AnzahlAuswahlDatum (anzahl) 
		{
			var $current=1;
			for (var i = 0; i < anzahl; i++)
			{
			document.getElementById("FeldAuswahldatum").innerHTML+="<li><label>"+$current+". Auswahl Datum & Zeit</label><input required autofocus type=\'datetime-local\' name=\"auswahldatum"+$current+"\" class=\'feld-lang\' /></li>";			
			$current=$current+1;
			}
			<!-- Eingabe-Formular für Datum nach eingabe entfernen -->
			var elem = document.getElementById("AuswahlFeld");
			elem.parentElement.removeChild(elem);
		}

function AnzahlOptionen (anzahl) 
		{
			var $current=1;
			for (var i = 0; i < anzahl; i++)
			{
			document.getElementById("FeldAuswahlOptionen").innerHTML+="<li><label>"+$current+". Auswahl-Option</label><input required autofocus type=\'text\' name=\"auswahloptionen"+$current+"\" class=\'feld-lang\' /></li>";			
			$current=$current+1;
			}
			<!-- Eingabe-Formular für Datum nach eingabe entfernen -->
			var elem = document.getElementById("AuswahlOptionenFeld");
			elem.parentElement.removeChild(elem);
		}
</script>
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

if ($_SESSION['loginname'] == '')
{
?>
	</article>
		<section id="meldungError">
			<p id="meldungTitel">Error</p>
			<p>Du hast keine Berechtigungen.</p>
			<p>Du musst dich zuerst einloggen: <a href="index.php?section=startseite">Weiter zum Login</a></p>
		</section>
	</article>
<?php	
}
else	
{
	if(!isset($_GET["page"])) 
	{
	?>
	<section id="inhalttitel">Event erstellen</section>
	<article><p class="center">Schritte: <b>Eventdetails</b> - Terminfindung - Optionen - Überprüfung - Abschicken</p></article>
	<article>
			
			<?php # Auslesen von user_id fürs eintragen der events auf den user!
			$sql = $db->query("SELECT user_id, user_email FROM user WHERE user_email = '$loginuser'");
			
					while($row = $sql->fetch_object())
					{?>
					
		<form method="post" action="index.php?section=event_erstellen&page=2">
			<ul class="formstyle">
				<li>
					<input hidden readonly type="text" name="user_id" value="<?php /* user_id auslesen */ echo $row->user_id; }?>" class="feld-lang" />
				</li>
				<li>
					<label>Titel</label>
					<input required autofocus type="text" name="event_titel" class="feld-lang" />
				</li>
				
				<li>
					<label>Beschreibung</label>
					<textarea required type="text" id="editor1" name="event_beschreibung" class="feld-lang feld-textarea"/></textarea>
						<script>
							// Replace the <textarea id="editor1"> with a CKEditor
							// instance, using default configuration.
							CKEDITOR.replace( 'editor1' );
						</script>
				</li>
				<li>
					<li><label>Standort</label>
						<li><input type="text" required name="event_ortdetail" class="feld-halbiert" placeholder="Name / Stockwerk / Raum"/>&nbsp;<input type="text" align-right name="event_ortstrasse" class="feld-halbiertRechts" placeholder="Strasse" /></li>
						<li><input type="text" required name="event_ortplz" class="feld-halbiert" placeholder="PLZ"/>&nbsp;<input type="text" align-right required name="event_ort" class="feld-halbiertRechts" placeholder="Ort" /></li>
					</li>
				<li>
					<label>Anmelde-Deadline</label>
					<input  type="date" name="event_deadline" class="feld-lang" />
				</li>
				<li>
					<input type="submit" value="Weiter" />
				</li>
			</ul>
		</form>
	</article>
	<?php
	}
}

if(isset($_GET["page"])) 
{
	if($_GET["page"] == "2") 
	{
	/* Uebergabe Daten in Variable speichern */
	$user_id = mysqli_real_escape_string($db, $_POST["user_id"]);
	$event_titel = mysqli_real_escape_string($db, $_POST["event_titel"]);
	/*$event_beschreibung = mysqli_real_escape_string($db, $_POST["event_beschreibung"]);*/
		$event_beschreibung = $_POST["event_beschreibung"];
	$event_ortdetail = mysqli_real_escape_string($db, $_POST["event_ortdetail"]);
	$event_ortstrasse = mysqli_real_escape_string($db, $_POST["event_ortstrasse"]);
	$event_ortplz = mysqli_real_escape_string($db, $_POST["event_ortplz"]);
	$event_ort = mysqli_real_escape_string($db, $_POST["event_ort"]);
	$event_deadline = mysqli_real_escape_string($db, $_POST["event_deadline"]);
	
	/* Variablen in session für übergabe an nächste Seiten speichern */
	$_SESSION['user_id'] = $user_id;
	$_SESSION['event_titel'] = $event_titel;
	$_SESSION['event_beschreibung'] = $event_beschreibung;
	$_SESSION['event_ortdetail'] = $event_ortdetail;
	$_SESSION['event_ortstrasse'] = $event_ortstrasse;
	$_SESSION['event_ortplz'] = $event_ortplz;
	$_SESSION['event_ort'] = $event_ort;
	$_SESSION['event_deadline'] = $event_deadline;
	?>
	<section id="inhalttitel">Event erstellen</section>
	<article><p class="center">Schritte: Eventdetails - <b>Terminfindung</b> - Optionen - Überprüfung - Abschicken</p></article>
	
	<article>
		<form method="post" action="index.php?section=event_erstellen&page=3">
			<ul class="formstyle">
				<!--<li>
					<label>1. Auswahl Datum & Zeit</label>
					<input required autofocus type="datetime-local" name="auswahldatum1" class="feld-lang" />
				</li>-->
				<li id="FeldAuswahldatum">
					<!-- Hier werden die Zusätzlichen Felder eingefügt -->
				</li>
				<li id="AuswahlFeld">
					<label>Anzahl Auswahldatum wählen</label>
					<input NAME="anzahl" type=number value="3" min="1" max="15">
					<input NAME="submit" type=button VALUE="Auswahl Daten & Zeit erzeugen" onClick="AnzahlAuswahlDatum(form.anzahl.value)">
				</li>
				<li>
					<input type="submit" value="Weiter" />
				</li>
			</ul>
		</form>
	</article>
	
	<?php
	}
}

if(isset($_GET["page"])) 
{
	if($_GET["page"] == "3") 
	{
		$values=array();
		foreach ($_POST as $key => $value) 
		{
			array_push($values, $value);
			/*echo $value ."<br>";
		 echo "Auswahl Daten&Zeit";
				echo "<tr>";
				echo "<td> ";
				echo $key;
				echo "</td>";
				echo "<td> ";
				echo $value;
				echo "</td>";
				echo "</tr>";
				echo "<br>";*/
		}
		
		//Array in die Session speichern
		$_SESSION['termine'] = $values;
	?>
	<section id="inhalttitel">Event erstellen</section>
	<article><p class="center">Schritte: Eventdetails - Terminfindung - <b>Optionen</b> - Überprüfung - Abschicken</p></article>
	
	<article>
		<form method="post" action="index.php?section=event_erstellen&page=4">
			<ul class="formstyle">
				<!--<li>
					<label>1. Auswahl Datum & Zeit</label>
					<input required autofocus type="datetime-local" name="auswahldatum1" class="feld-lang" />
				</li>-->
				<li id="FeldAuswahlOptionen">
					<!-- Hier werden die Zusätzlichen Felder eingefügt -->
				</li>
				<li id="AuswahlOptionenFeld">
					<p>Hier dürfen zusätzliche Optionen für den Event erfasst werden. Die Teilnehmer können via Checkbox der Option zustimmen. Beachte also die Fragestellung.</p>
					<label>Anzahl JA/NEIN-Optionen wählen</label>
					<input NAME="anzahl" type=number value="3" min="0" max="15">
					<input NAME="submit" type=button VALUE="Auswahl Optionen erzeugen" onClick="AnzahlOptionen(form.anzahl.value)">
				</li>
				<li>
					<input type="submit" value="Weiter" />
				</li>
			</ul>
		</form>
	</article>
	<?php
	}
}

if(isset($_GET["page"])) 
{
	if($_GET["page"] == "4") 
	{
		$values_optionen = array();
		foreach ($_POST as $key_optionen => $value_optionen) 
		{
			array_push($values_optionen, $value_optionen);
			/*echo $value ."<br>";
		 echo "Auswahl Daten&Zeit";
				echo "<tr>";
				echo "<td> ";
				echo $key;
				echo "</td>";
				echo "<td> ";
				echo $value;
				echo "</td>";
				echo "</tr>";
				echo "<br>";*/
		}

		//Array in die Session speichern
		$_SESSION['optionen'] = $values_optionen;

		$event_titel = mysqli_real_escape_string($db, $_SESSION['event_titel']);
		/*$event_beschreibung = mysqli_real_escape_string($db, $_SESSION['event_beschreibung']);  ckeditor versuch*/
		$event_beschreibung = $_SESSION['event_beschreibung'];
		$event_ortdetail = mysqli_real_escape_string($db, $_SESSION['event_ortdetail']);
		$event_ortstrasse = mysqli_real_escape_string($db, $_SESSION['event_ortstrasse']);
		$event_ortplz = mysqli_real_escape_string($db, $_SESSION['event_ortplz']);
		$event_ort = mysqli_real_escape_string($db, $_SESSION['event_ort']);
		$event_deadline = mysqli_real_escape_string($db, $_SESSION['event_deadline']);
		
		$values = $_SESSION['termine'];
		
	 # Auslesen der letzten event_id fürs eintragen der Termine
		$sql = $db->query("SELECT event_id FROM event ORDER BY event_id DESC LIMIT 1");
			while($row = $sql->fetch_object())
			{
				$fkw_event_id = $row->event_id+1;
			}
		$_SESSION['event_id'] = $fkw_event_id;
	?>
	<section id="inhalttitel">Event erstellen</section>
	<article><p class="center">Schritte: Eventdetails - Terminfindung - Optionen - <b>Überprüfung</b> - Abschicken</p></article>
		<article>
		<table>
			<tr>
				<td class="spalteklein">Titel:</td>
				<td><?php echo $event_titel; ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Beschreibung:</td>
				<td><?php echo $event_beschreibung; ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Wo:</td>
				<td><?php echo $event_ortdetail; ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Strasse:</td>
				<td><?php echo $event_ortstrasse; ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Ort:</td>
				<td><?php echo $event_ortplz . " " . $event_ort; ?></td>
			</tr>
			<tr>
				<td class="spalteklein"></td>
				<td><?php  
					################################## GOOGLEMAPS ##########################################
					// Adresse in var $adresse zusammenfÃ¼gen     
					$adresse = $event_ortstrasse .', '.$event_ortplz .' '.$event_ort; ?> 

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
							<div id="map_canvas"></div>  
						</body>
					</div>
				</td>
			</tr>
			<tr>
				<td class="spalteklein">Deadline:</td>
				<td><?php echo datumEU($event_deadline); ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Auswahltermine:</td>
				<td><?php 
				foreach ($values as $key => $value) 
				{ 
					$datumumwandlung = date("d.m.Y",(strtotime($value)));
					$zeitumwandlung = date("H:i",(strtotime($value)));
					echo $datumumwandlung . " - " . $zeitumwandlung . " Uhr<br>";
				} ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Optionen:</td>
				<td><?php 
				foreach ($values_optionen as $key_optionen => $value_optionen) 
				{ 
					echo $value_optionen . "<br>";
				} ?></td>
			</tr>
		</table>
			
			<form method="post" action="index.php?section=event_erstellen&page=5">
				<ul class="formstyle">
					<li>
						<input type="submit" value="Eintragen" />
					</li>
				</ul>
			</form>
		</article>
	
	<?php
		
	}
}
	
if(isset($_GET["page"])) 
{
	if($_GET["page"] == "5") 
	{?>
	
	<section id="inhalttitel">Event erstellen</section>
	<article><p class="center">Schritte: Eventdetails - Terminfindung - Optionen - <b>Überprüfung</b> - Abschicken</p></article>
	
	<?php
	/* Event - Variablen aus Sessionübergabe */
	$fk_user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
	$event_titel = mysqli_real_escape_string($db, $_SESSION['event_titel']);
		/*$event_beschreibung = mysqli_real_escape_string($db, $_SESSION['event_beschreibung']);  ckeditor versuch*/
		$event_beschreibung = $_SESSION['event_beschreibung'];
	$event_ortdetail = mysqli_real_escape_string($db, $_SESSION['event_ortdetail']);
	$event_ortstrasse = mysqli_real_escape_string($db, $_SESSION['event_ortstrasse']);
	$event_ortplz = mysqli_real_escape_string($db, $_SESSION['event_ortplz']);
	$event_ort = mysqli_real_escape_string($db, $_SESSION['event_ort']);
	$event_deadline = mysqli_real_escape_string($db, $_SESSION['event_deadline']);
	/* AuswahlDatum Array und Variable aus Sessionübergabe */
	$values = $_SESSION['termine'];
	$values_optionen = $_SESSION['optionen']; 	
	$FK_event_id = $_SESSION['event_id'];
	
	/* Hash Link für Events erzeugen: */
	$event_link = hash('crc32', ("Termin" . $FK_event_id ."Bot"));
	/*echo $event_link;*/
	$_SESSION['event_link'] = $event_link;
	
	
		/* Event in DB schreiben */
		$sql = 'INSERT INTO event (`event_link`, `event_titel`, `event_beschreibung`, `event_ortdetail`, `event_ortstrasse`, `event_ortplz`, `event_ort`, `event_deadline`, `fk_user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$eintrag = $db->prepare($sql);
		$eintrag->bind_param( 'ssssssssi', $event_link, $event_titel, $event_beschreibung, $event_ortdetail, $event_ortstrasse, $event_ortplz, $event_ort, $event_deadline, $fk_user_id);
		$eintrag->execute();
		
		// Pruefen ob der Eintrag efolgreich war
		if ($eintrag->affected_rows == 1)
			{
			?>
				<section id="meldungOK">
					<p id="meldungTitel">Hinweis</p>
					<p>Event wurde erfolgreich erstellt.</p>
				</section>
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
	
		/* Terminauswahl in DB schreiben */
		foreach ($values as $key => $value) 
			{
				$sql = 'INSERT INTO terminfindung (`terminfindung_datumzeit`, `FK_event_id`) VALUES (?, ?)';
				$eintrag = $db->prepare($sql);
				$eintrag->bind_param( 'si', $value, $FK_event_id);
				$eintrag->execute();
			}

		// Pruefen ob der Eintrag efolgreich war
		if ($eintrag->affected_rows == 1)
			{
			?>
				<section id="meldungOK">
					<p id="meldungTitel">Hinweis</p>
					<p>Terminauswahl wurde erfolgreich erstellt.</p>
				</section>
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
			
		/* Optionenauswahl in DB schreiben */
		foreach ($values_optionen as $key_optionen => $value_optionen) 
			{
				$sql = 'INSERT INTO optionen (`optionen_option`, `fk_event_id`) VALUES (?, ?)';
				$eintrag = $db->prepare($sql);
				$eintrag->bind_param( 'si', $value_optionen, $FK_event_id);
				$eintrag->execute();
			}

		// Pruefen ob der Eintrag efolgreich war
		if ($eintrag->affected_rows == 1)
			{
			?>
				<section id="meldungOK">
					<p id="meldungTitel">Hinweis</p>
					<p>Optionen wurde erfolgreich erstellt.</p>
				</section>
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
		?>
			<!--<form method="post" action="index.php?section=event_erstellen&page=6">
				<ul class="formstyle">
					<li>
						
						<input type="submit" value="Einladungen verschicken" />
					</li>
				</ul>
			</form>-->
			<meta http-equiv="refresh" content="1; URL=index.php?section=event_erstellen&page=6" />
	<?php
	}

}

if(isset($_GET["page"])) 
{
	if($_GET["page"] == "6") 
	{
		if(!isset($_GET["direktlink"])) 
		{
			$event_link = $_SESSION['event_link'];
			?>
			<section id="inhalttitel">Event erstellen</section>
			<article><p class="center">Schritte: Eventdetails - Terminfindung - Optionen - Überprüfung - <b>Abschicken</b></p></article>
				
			<p>Dein Event ist nun erstellt und kann mit diesem Direktlink versendet werden. <br>Bitte kopiere den Link und versende ihn an deine Gäste.<p>
					<form>
						<ul class="formstyle">
							<li>
								<label>Direktlink</label>
								<input type="text" readonly name="event_link" class="feld-direktlink" value="http://localhost/terminbot/index.php?section=event&link=<?php echo $event_link;?>"/>
							</li>
						</ul>
					</form>

			<article>
			<p>Du kannst deinen Gästen auch direkt eine Einladung per E-Mail senden.<br>Bitte gibt die E-Mail Adresse des Empfängers ein.<br>Nach dem senden kannst Du den nächsten Empfänger eingeben.<p>
				<form method="post" action="index.php?section=event_erstellen&page=6&direktlink=2">
					<ul class="formstyle">
						<li>
							<input hidden readonly type="text" name="direktlink" class="feld-direktlink" value="http://localhost/terminbot/index.php?section=event&link=<?php echo $event_link;?>"/>
						</li>
							<label>E-Mail Empfänger</label>
							<input autofocus type="email" name="email" class="feld-lang" />
						<li>
							<input type="submit" value="senden" />
						</li>
					</ul>
				</form>
		<?php
		}
		if(isset($_GET["direktlink"])) 
		{
			if($_GET["direktlink"] == "2") 
			{
				$direktlink = $_POST['direktlink'];
				$mail 		= $_POST['email'];

				$absender = 'From: terminbot@umgekehrt.ch' . "\r\n" .
							'Reply-To: terminbot@umgekehrt.ch' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();
			
$betreff = "TerminBot - Eventeinladung";
$inhalt = "Hallo, Du wurdest eingeladen an folgendem Event teilzunehmen:\n" . $direktlink . "\n
Bitte folge dem Link und log dich auf der Terminbot-Plattform um die Einladung zu bestaetigen.\n\n
Besten Dank\n
TerminBot - eine erweiterte Eventanmeldungsplattform.\n";
					
				
				mail($mail, $betreff, $inhalt, $absender);
				/*echo "<br>direktlink: " . $direktlink;
				echo "<br><br>mail: " . $mail;
				echo "<br><br>absender: " . $absender;
				echo "<br><br>betreff: " . $betreff;
				echo "<br><br>inhalt: " . $inhalt;*/
				?>
				<section id="meldungOK">
					<p id="meldungTitel">Hinweis</p>
					<p>Deine Einladung wurde an den Empfänger gesendet.</p>
				</section>
				<meta http-equiv="refresh" content="2; URL=index.php?section=event_erstellen&page=6" />
				<?php
			}
		}
		?>
		</article>    
		<?php
	}
}	
?>
<br class="clear"/>