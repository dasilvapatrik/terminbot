<?php
/* ######### PHP Datum europäisch ausgeben ######### 
function date_mysql2german($date) {
    $d    =    explode("-",$date);
		return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
}
/* ######### PHP Datum europäisch ausgeben ENDE ######### */
	
## GLOBAL ##
//$loginuser = mysqli_real_escape_string($db, $_SESSION['username']);
## GLOBAL ENDE ##
?>

<section id="inhalttitel">Hilfe - FAQ</section>
<p>Hier ist eine Übersicht der wichtigsten Fragen rund um die TerminBot-Plattform.</p>
<article>
	<details>
			<summary><b>Login</b> - Wo kann ich mich einloggen?</summary>
			<p>Das Login-Formular befindet sich auf der <b>Startseite</b>. Sobald das Login erfolgreich war, wird der Privatbereich aufgerufen.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilder" src="img/hilfe/login.PNG"></td></tr>
			</table>
	</details>
</article>
<article>
	<details>
			<summary><b>Registrierung</b> - Wo kann ich mich registrieren?</summary>
			<p>Das Registrierungs-Formular befindet sich auf der <b>Startseite</b> unterhalb des Login-Formulars.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilder" src="img/hilfe/registrierung.PNG"><br></td></tr>
			</table>
		<br>
			<table class="tablehilfe">
				<p>Registrierungs-Formular:</p>
				<tr><td><img class="hilfe_bilder" src="img/hilfe/registrierung_formular.PNG"></td></tr>
			</table>
		</details>
</article>


<article>	
	<details>
			<summary><b>Event erstellen</b> - Wo kann ich Events erstellen?</summary>
			<p>Im <b>Privatbereich</b> können neue Events erstellt werden. Der Knopf befindet sich oberhalb der Event-Listen.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilderbreit" src="img/hilfe/event_erstellen_button.PNG"></td></tr>
			</table>	
	</details>
</article>
<article>	
	<details>
			<summary><b>Event bearbeiten</b> - Wo kann ich Events bearbeiten?</summary>
			<p>Im <b>Privatbereich</b> können die eigenen Events bearbeitet werden. Dazu wird hinter jedem selbst erstellten Event ein solcher Bearbeitungs-Knopf angezeigt:</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bearbeitungsbutton" src="img/hilfe/edit_icon.PNG"></td></tr>
			</table>	
	</details>
</article>
<article>	
	<details>
			<summary><b>Event deaktivieren/aktivieren</b> - Wo kann ich Events deaktivieren oder aktivieren?</summary>
			<p>Die Veranstaltung kann für die Teilnehmer deaktiviert und wieder aktiviert werden. Im deaktivierten Modus, hat nur der Veranstalter den Zugriffsrecht auf die Verantstaltung</p>
			<p>In der <b>Eventverwaltung</b> kann ein Event deaktiviert oder aktiviert werden.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilderbreit" src="img/hilfe/event_deaktivieren_aktivieren.PNG"></td></tr>
			</table>	
	</details>
</article>
<article>	
	<details>
			<summary><b>Deaktivierte Events</b> - Wo befinden sich die deaktivierten Events?</summary>
			<p>Im <b>Privatbereich</b> unter <b>Meine deaktivierten Events</b> werden die deaktivierten Veranstaltungen aufgelistet und können dort bearbeitet werden.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilderbreit" src="img/hilfe/deaktivierteEvents_aufgeklappt.PNG"></td></tr>
			</table>
	</details>
</article>
<article>	
	<details>
			<summary><b>Event löschen</b> - Wo kann ich ein Event löschen?</summary>
			<p>In der <b>Eventverwaltung</b> kann ein Event gelöscht werden. Dazu muss ganz nach unten gescrollt werden.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilderbreit" src="img/hilfe/event_loeschen.PNG"></td></tr>
			</table>
			<p>Aufklappen um zu bestätigen.</p>
			<table class="tablehilfe">
				<tr><td><img class="hilfe_bilderbreit" src="img/hilfe/event_loeschen_ausgeklappt.PNG"></td></tr>
			</table>			
	</details>
</article>





