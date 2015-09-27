<script>
var $current=2;
function AddEvent(){
document.getElementById("FeldAuswahldatum").innerHTML+="<li><label>"+$current+". Auswahl Datum & Zeit</label><input required autofocus type=\'datetime-local\' name=\"auswahldatum"+$current+"\" class=\'feld-lang\' /></li>";			
$current=$current+1;
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
	<article><p class="center">Schritte: <b>Eventdetails</b> - Terminfindung - Überprüfung - Abschicken</p></article>
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
					<textarea required type="text" name="event_beschreibung" class="feld-lang feld-textarea"/></textarea>
				</li>
				<li>
					<li><label>Standort</label>
					<input type="text" required name="event_ortdetail" class="feld-halbiert" placeholder="Name / Stockwerk / Raum"/>&nbsp;<input type="text" required align-right name="event_ortstrasse" class="feld-halbiertRechts" placeholder="Strasse" /></li>
					<input type="text" required name="event_ortplz" class="feld-halbiert" placeholder="PLZ"/>&nbsp;<input type="text" align-right required name="event_ort" class="feld-halbiertRechts" placeholder="Ort" /></li>
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
	$event_beschreibung = mysqli_real_escape_string($db, $_POST["event_beschreibung"]);
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
	<article><p class="center">Schritte: Eventdetails - <b>Terminfindung</b> - Überprüfung - Abschicken</p></article>
	
	<article>
		<form method="post" action="index.php?section=event_erstellen&page=3">
			<ul class="formstyle">
				<li>
					<label>1. Auswahl Datum & Zeit</label>
					<input required autofocus type="datetime-local" name="auswahldatum1" class="feld-lang" />
				</li>
				<li id="FeldAuswahldatum">
					<!-- Hier werden die Zusätzlichen Felder eingefügt -->
				</li>
				<li>
					<input type="button" onclick="AddEvent()" value="Auswahl Datum hinzufügen"> <input type="submit" value="Weiter" />
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

		$_SESSION['termine'] = $values;

		$event_titel = mysqli_real_escape_string($db, $_SESSION['event_titel']);
		$event_beschreibung = mysqli_real_escape_string($db, $_SESSION['event_beschreibung']);
		$event_ortdetail = mysqli_real_escape_string($db, $_SESSION['event_ortdetail']);
		$event_ortstrasse = mysqli_real_escape_string($db, $_SESSION['event_ortstrasse']);
		$event_ortplz = mysqli_real_escape_string($db, $_SESSION['event_ortplz']);
		$event_ort = mysqli_real_escape_string($db, $_SESSION['event_ort']);
		$event_deadline = mysqli_real_escape_string($db, $_SESSION['event_deadline']);
		
	 # Auslesen der letzten event_id fürs eintragen der Termine
		$sql = $db->query("SELECT event_id FROM event ORDER BY event_id DESC LIMIT 1");
			while($row = $sql->fetch_object())
			{
				$fkw_event_id = $row->event_id+1;
			}
		$_SESSION['event_id'] = $fkw_event_id;
	?>
	<section id="inhalttitel">Event erstellen</section>
	<article><p class="center">Schritte: Eventdetails - Terminfindung - <b>Überprüfung</b> - Abschicken</p></article>
		<article>
		<?php
		?>
		<table>
			<tr>
				<td class="spalteklein">Titel:</td>
				<td><?php echo $event_titel; ?></td>
			</tr>
			<tr>
				<td class="spalteklein">Beschreibung:</td>
				<td><?php echo $event_beschreibung; ?></td>
			<tr>
			<tr>
				<td class="spalteklein">Wo:</td>
				<td><?php echo $event_ortdetail; ?></td>
			<tr>
			<tr>
				<td class="spalteklein">Strasse:</td>
				<td><?php echo $event_ortstrasse; ?></td>
			<tr>
			<tr>
				<td class="spalteklein">Ort:</td>
				<td><?php echo $event_ortplz . " " . $event_ort; ?></td>
			<tr>
			</tr>
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
							<div id="map_canvas" style="width: 100%; height: 300px;"></div>  
						</body>
					</div>
				</td>
			<tr>
			</tr>
				<td class="spalteklein">Deadline:</td>
				<td><?php echo datumEU($event_deadline); ?></td>
			<tr>
			</tr>
				<td class="spalteklein">Auswahltermine:</td>
				<td><?php 
				foreach ($values as $key => $value) 
				{ 
					$datumumwandlung = date("d.m.Y",(strtotime($value)));
					$zeitumwandlung = date("H:i",(strtotime($value)));
					echo $datumumwandlung . " - " . $zeitumwandlung . " Uhr<br>";
				} ?></td>
			</tr>
		</table>
			
			<form method="post" action="index.php?section=event_erstellen&page=4">
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
	if($_GET["page"] == "4") 
	{
	$fk_user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
	$event_titel = mysqli_real_escape_string($db, $_SESSION['event_titel']);
	$event_beschreibung = mysqli_real_escape_string($db, $_SESSION['event_beschreibung']);
	$event_ortdetail = mysqli_real_escape_string($db, $_SESSION['event_ortdetail']);
	$event_ortstrasse = mysqli_real_escape_string($db, $_SESSION['event_ortstrasse']);
	$event_ortplz = mysqli_real_escape_string($db, $_SESSION['event_ortplz']);
	$event_ort = mysqli_real_escape_string($db, $_SESSION['event_ort']);
	$event_deadline = mysqli_real_escape_string($db, $_SESSION['event_deadline']);
	
	/* Event in DB schreiben */
	$sql = 'INSERT INTO event (`event_titel`, `event_beschreibung`, `event_ortdetail`, `event_ortstrasse`, `event_ortplz`, `event_ort`, `event_deadline`, `fk_user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
	$eintrag = $db->prepare($sql);
	$eintrag->bind_param( 'sssssssi', $event_titel, $event_beschreibung, $event_ortdetail, $event_ortstrasse, $event_ortplz, $event_ort, $event_deadline, $fk_user_id);
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
	$values = $_SESSION['termine']; 
	$termin_termin_id = $_SESSION['event_id'];
	foreach ($values as $key => $value) 
		{
			$sql = 'INSERT INTO terminfindung (`terminfindung_datumzeit`, `termin_termin_id`) VALUES (?, ?)';
			$eintrag = $db->prepare($sql);
			$eintrag->bind_param( 'si', $value, $termin_termin_id);
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
	
	}
}
?>
<br class="clear"/>