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

session_start();
if(isset($_SESSION["loginname"])) 
{




## Username aus DB auslesen ##
			$sql = $db->query("SELECT * FROM user WHERE user_email = '$loginuser'");		
			while($row = $sql->fetch_object())
					{	
					
			$user_id = $row->user_id; //variable setzen für abfrage im privatbereich
?>
<section id="inhalttitel">Privatbereich von <?php echo $row->user_vorname . " " . $row->user_name ; }?> 
<form><input class="buttonstyle" type="button" value="Event erstellen" onClick="window.location='index.php?section=event_erstellen'"></form>
<br class="clear"/></section>


<p>Willkommen beim TerminBot. Dies ist eine erweiterte Eventanmeldeplattform.<br>Du befindest dich nun in deinem Privatbereich, wo deine Events aufgelistet sind.</p>


		<article>
<section id="inhalttitel">Meine Events</section>
			<table>
				<tr><th align="left" id="event">Event</th><th align="center" id="deadline">Anmelde-Deadline</th><th align="left" id="veranstalter">Veranstalter</th></tr>
							
<?php
# Die SQL-Abfrage -> Events:
$sql = $db->query('select distinct
		terminfindung.FK_event_id,
		user.user_email,
		user.user_vorname, 
		user.user_name, 
		event.event_id, 
		event.event_titel,
		event.event_link,
		event.event_deadline 
	from
		terminfindung 
	JOIN
		terminfindung_has_user
	ON
		(terminfindung_has_user.fk_terminfindung_id = terminfindung.terminfindung_id)
	JOIN 
		user 
	ON 
		(terminfindung_has_user.fk_user_id = user.user_id)
	JOIN 
		event 
	ON 
		(event.event_id = terminfindung.FK_event_id)
	WHERE
		terminfindung_has_user.fk_user_id = "' . $user_id . '"
	OR
		user_email = "' . $loginuser . '";');				
					
					while($row = $sql->fetch_object())
					{
						echo '<tr class="linkzeile" onMouseover="this.bgColor=\'#aaaaaa\'" onMouseout="this.bgColor=\'transparent\'">';
						echo '<td align="left" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. $row->event_titel .'</td>';
						echo '<td align="center" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. datumEU($row->event_deadline) .'</td>';
						echo '<td align="left" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. $row->user_vorname . " " . $row->user_name .'</td>';
						echo '</tr>';
					}
?>
		</table>
	</article>
<?php 
}
else
{?>
	<section id="meldungError">
		<p id="meldungTitel">Error</p>
		<p>Du hast keine Berechtigungen.</p>
		<p>Du musst dich zuerst einloggen: <a href="index.php?section=startseite">Weiter zum Login</a></p>
	</section>
<?php
}?>
<br class="clear"/>

