<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##

if ($_SESSION['loginname'] == '')
{
?>
<p>bla bla bla registrierung vorteil bla</p>

	<section id="inhalttitel">Registrierung</section>
	<?php
	if(!isset($_GET["page"])) {
	?>
		<form method="post" action="index.php?section=registrierung&page=2">
			<ul class="formstyle">
				<li>
					<label>Vorname</label>
					<input required autofocus type="text" name="user_vorname" class="feld-lang" />
				</li>
				<li>
					<label>Nachname</label>
					<input required type="text" name="user_name" class="feld-lang" />
				</li>
				<li>
					<label>E-Mail Adresse</label>
					<input required type="email" name="user_email" class="feld-lang" />
				</li>
				<li>
					<label>Password</label>
					<input required type="password" name="pw1" class="feld-lang" />
				</li>
				<li>
					<label>Password wiederholen</label>
					<input required type="password" name="pw2" class="feld-lang" />
				</li>
				<li>
					<input type="submit" value="registrieren" />
				</li>
			</ul>
		</form>
	<?php
	}
}
else	
	{ ?>
			<section id="meldungError">
				<p>Du hast dich bereits unter den Loginnamen: <?php $loginuser ?> eingeloggt. <a href="index.php?section=startseite">Zurück</a></p>
			</section>
<?php	
	}

	
if(isset($_GET["page"])) 
{
	if($_GET["page"] == "2") 
	{
	$user_vorname = ($_POST["user_vorname"]);
	$user_name = ($_POST["user_name"]);
	$user_email = strtolower($_POST["user_email"]);
	$pw1 = sha1($_POST["pw1"]);
	$pw2 = sha1($_POST["pw2"]);
	
	if($pw1 != $pw2) 
		{  ?>
		<section id="meldungError">
			<p>Passwort stimmt nicht überein. Bitte neu eingeben: <a href="#" onclick="history.back(); return false">Zurück</a></p>
		</section>
			<?php		
		} 
	else 
		{
	
	$control = 0;		
			$sql = $db->query("SELECT user_email FROM user WHERE user_email = '$user_email'");		
			while($row = $sql->fetch_object())
					{
						$control++;
					}				
	
			if($control != 0) {
				?>
				<section id="meldungError">
					<p id="meldungTitel">Error</p>
					<p>User bereits vergeben. Bitte verwende einen anderen Usernamen. <a href="#" onclick="history.back(); return false">Zurück</a></p>
				</section>
				<?php
			} 
			else 
			{
			
			$sql = 'INSERT INTO user (`user_name`, `user_vorname`, `user_password`, `user_email`) VALUES (?, ?, ?, ?)';
			$eintrag = $db->prepare($sql);
			$eintrag->bind_param( 'ssss', $user_name, $user_vorname, $pw1, $user_email);
			$eintrag->execute();

			// Pruefen ob der Eintrag efolgreich war
			if ($eintrag->affected_rows == 1)
				{
				?>
					<section id="meldungOK">
						<p id="meldungTitel">Hinweis</p>
						<p>Neuer User ist nun registriert. <a href="index.php?section=startseite">Weiter zum Login</a></p>
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
	}
}
?>
<br class="clear"/>