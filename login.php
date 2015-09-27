<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##
?>

<?php
if($_GET["page"] == "log") 
{
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

<p>Willkommen beim TerminBot. Dies ist eine erweiterte Eventanmeldeplattform.</p>

</article>
	<section id="inhalttitel">Login</section>

	<?php
	if($verhalten == 0) 
	{
	?>	
		<form method="post" action="index.php?section=startseite&page=log">
			<ul class="formstyle">
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
		<p>Privatbereich wird geladen...</p>
	</section>
	<?php
	}

	if($verhalten == 1) 
	{
	?>
		<meta http-equiv="refresh" content="2; URL=index.php?section=events" />
		<!-- nach login - eventseite anzeigen lassen statt startseite-->
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
<br class="clear"/>

