<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['username']);
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
	$_SESSION["username"] = $email;
	$verhalten = 1;
	} 	
	else 
	{
		$verhalten = 2;
	}
}
?>

Willkommen beim TerminBot. Dies ist eine erweiterte Eventanmeldeplattform.

	<section id="inhalttitel">Login</section>

	<article>
	<?php
	if($verhalten == 0) {
	?>	
		<form method="post" action="index.php?section=startseite&page=log">
			<ul class="formstyle">
				<li>
					<label>E-Mail Adresse</label>
					<input required autofocus type="email" name="email" class="field-long" />
				</li>
				<li>
					<label>Password</label>
					<input required autocomplete type="password" name="password" class="field-long" />
				</li>
				<li>
					<input type="submit" value="Login" />
				</li>
			</ul>
		</form>
	<?php
	}
	if($verhalten == 1) {
	?>
	Login OK. Privat Bereich wird geladen...
	<?php
	}

	if($verhalten == 1) {
	?>
		<!--Du hast dich richtig eingeloggt!!!! <br> <?php //echo $loginuser . $testvar; ?>-->
		<meta http-equiv="refresh" content="2; URL=index.php?section=events" />
		<!-- nach login - eventseite anzeigen lassen statt startseite
		<meta http-equiv="refresh" content="0; URL=index.php?section=events" />-->
	<?php
	}

	if($verhalten == 2) {
	?>
	Du hast dich nicht richtig eingeloggt, <a class="footerlinks" href="index.php?section=startseite">zurück</a>.
	
	<?php
	}	
	?>
	</article>





<br class="clear"/>

