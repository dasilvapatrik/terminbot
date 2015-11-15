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
<br class="clear"/></section>


<p>
	<table>
		<tr>
			<td id="privatbereich_welcometext">
				Willkommen beim TerminBot. Dies ist eine erweiterte Eventanmeldeplattform.<br>Du befindest dich nun in deinem Privatbereich, wo deine Events aufgelistet sind.
			</td>	
			<td align="right">
				<input class="buttonstyle" type="button" value="Event erstellen" onClick="window.location='index.php?section=event_erstellen'">
			</td>
		</tr>
	</table>
</p>

<article>
	<section id="inhalttitel">Meine Events</section>
		<table>
			<tr><th width="50%" align="left" id="privatbereich_event">Event</th><th width="20%" align="center" id="privatbereich_deadline">Anmeldeschluss</th><th align="center" id="privatbereich_veranstalter">Veranstalter</th><th width="20px" align="center" id="privatbereich_verwalten"></th></tr>
							
<?php
		# SQL-Abfrage -> Privatbereich Liste-Events:
		$sql = $db->query('select distinct
				user.user_email,
				user.user_vorname, 
				user.user_name,
				event_status,			
				event.event_titel,
				event.event_link,
				event.event_deadline,
				event.fk_user_id
			FROM
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
				terminfindung_has_user.fk_user_id = "' . $user_id . '" AND event_status = "0"
		UNION DISTINCT

			Select
				user.user_email,
				user.user_vorname, 
				user.user_name, 
				event_status,
				event.event_titel,
				event.event_link,
				event.event_deadline, 
				event.fk_user_id
			FROM
				event
			JOIN
				user
			ON
				(event.fk_user_id = user.user_id)

			WHERE
				user_email = "' . $loginuser . '" AND event_status = "0"
			ORDER BY event_deadline ASC');				
					
					while($row = $sql->fetch_object())
					{
						echo '<tr class="linkzeile" onMouseover="this.bgColor=\'#aaaaaa\'" onMouseout="this.bgColor=\'transparent\'">';
						echo '<td id="privatbereich_event" align="left" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. $row->event_titel .'</td>';
						echo '<td id="privatbereich_deadline" align="center" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. datumEU($row->event_deadline) .'</td>';	
								
							/* Veranstaltername abfrage - separat da sonst loginname aufgelistet wird */ 
							$sqleventname = $db->query('SELECT
								event.event_link,
								user.user_vorname,
								user.user_name,
								user.user_email
							FROM
								user
							JOIN
								event
							ON
								(event.fk_user_id = user.user_id)
							WHERE
								event_link = "' . $row->event_link . '"');
							while($roweventname = $sqleventname->fetch_object())
							{
								echo '<td id="privatbereich_veranstalter" align="center" onClick="window.location.href=\'?section=event&link=' . $roweventname->event_link . '\'">'. $roweventname->user_vorname . " " . $roweventname->user_name . '</td>';					
								
							/* ENDE - Veranstaltername abfrage - separat da sonst loginname aufgelistet wird */ 
						
							/* Verwaltungslink anzeigen wenn Eigener Event */ 
							
								if ($loginuser == $roweventname->user_email)
								{
									echo '<td id="privatbereich_verwalten" align="left" onClick="window.location.href=\'?section=event_edit&link=' . $row->event_link . '\'"><img src="img/edit_icon.png" height="20" width="20"></td>';
								}
								else
								{
								echo '<td onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'"></td>';
								}
							}
							/* ENDE - Verwaltungslink anzeigen wenn Eigener Event */
						
						
						
						echo '</tr>';
					}
?>
		</table>
</article>

<!-- Deaktivierte Events ab hier -->
<article>	
	<details>
		<summary><b>Meine deaktivierten Events</b></summary><br class="clear"/>
		<table>
			<tr><th width="50%" align="left" id="privatbereich_event">Event</th><th width="20%" align="center" id="privatbereich_deadline">Anmeldeschluss</th><th align="center" id="privatbereich_veranstalter">Veranstalter</th><th width="20px" align="center" id="privatbereich_verwalten"></th></tr>
							
<?php
		# Die SQL-Abfrage -> Events:
		$sql = $db->query('Select
							user.user_email,
							event.event_status,				
							event.event_titel,
							event.event_link,
							event.event_deadline, 
							event.fk_user_id
						FROM
							event
						JOIN
							user
						ON
							(event.fk_user_id = user.user_id)

						WHERE
							user_email = "' . $loginuser . '" AND event_status = "1"
						ORDER BY event_deadline ASC');				
					
					while($row = $sql->fetch_object())
					{
						echo '<tr class="linkzeile" onMouseover="this.bgColor=\'#aaaaaa\'" onMouseout="this.bgColor=\'transparent\'">';
						echo '<td id="privatbereich_event" align="left" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. $row->event_titel .'</td>';
						echo '<td id="privatbereich_deadline" align="center" onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'">'. datumEU($row->event_deadline) .'</td>';	
								
							/* Veranstaltername abfrage - separat da sonst loginname aufgelistet wird */ 
							$sqleventname = $db->query('SELECT
								event.event_link,
								user.user_vorname,
								user.user_name,
								user.user_email
							FROM
								user
							JOIN
								event
							ON
								(event.fk_user_id = user.user_id)
							WHERE
								event_link = "' . $row->event_link . '"');
							while($roweventname = $sqleventname->fetch_object())
							{
								echo '<td id="privatbereich_veranstalter" align="center" onClick="window.location.href=\'?section=event&link=' . $roweventname->event_link . '\'">'. $roweventname->user_vorname . " " . $roweventname->user_name . '</td>';					
								
							/* ENDE - Veranstaltername abfrage - separat da sonst loginname aufgelistet wird */ 
						
							/* Verwaltungslink anzeigen wenn Eigener Event */ 
							
								if ($loginuser == $roweventname->user_email)
								{
									echo '<td id="privatbereich_verwalten" align="left" onClick="window.location.href=\'?section=event_edit&link=' . $row->event_link . '\'"><img src="img/edit_icon.png" height="20" width="20"></td>';
								}
								else
								{
									echo '<td onClick="window.location.href=\'?section=event&link=' . $row->event_link . '\'"></td>';
								}
							}
							/* ENDE - Verwaltungslink anzeigen wenn Eigener Event */
						
						
						
						echo '</tr>';
					}
?>
		</table>
	</details>
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

