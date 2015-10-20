<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##

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
else	/****************************************************************** Begin Event-Teilnahme wenn Login OK **************************************************************/
{

	/* abfrage event_status */
	$sql = $db->query("SELECT 
						event.event_status, 
						event.event_link,
						user.user_email
					FROM 
						event 
					JOIN
						user
					ON
						(event.fk_user_id = user.user_id)
					WHERE event_link = '" . $getlink . "'");
		while($row = $sql->fetch_object())
		{
			$event_status = $row->event_status; 
			$event_email = $row->user_email; 
		}
		/*echo "<br>status: " . $event_status;
		echo "<br>event_email: " . $event_email;
		echo "<br>";*/
		
/* Wenn Event deatkiviert dann Meldung sonst Event anzeigen. */
	if ($event_status != "0")
	{
		if(($event_email == $loginuser) AND $event_status == "1")
		{
		?>
			<section id="meldungError">
				<p id="meldungTitel">Event deaktiviert</p>
				<p>Dieser Event wurde von Dir deaktiviert.<br>Du kannst den Event im Privatbereich wieder aktivieren.<br><br>Im deaktivierten Modus hast nur Du einsicht auf die Details</p>
			</section>	
		<?php	
			include("event_details.php");	
		}
		else
		{
		?>
			<section id="meldungError">
				<p id="meldungTitel">Event deaktiviert oder gelöscht</p>
				<p>Dieser Event wurde vom Veranstalter deaktiviert oder gelöscht.</p>
			</section>	
		<?php
		}
	}
	else
	{
		include("event_details.php");	
	}
}
?>
	