<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##
session_start();
?>
<section id="inhalttitel">Kontakt</section>
<?php
if(!isset($_SESSION["loginname"])) 
{
?>
	<p>Wenn du Fragen, Anregungen oder Probleme auf der Website hast, dann melde dies bitte hier.</p>
		<form method="post" action="index.php?section=kontakt&page=2">
			<ul class="formstyle">
					<li>
						<label>Name</label>
						<input type="text" autofocus required name="kontakt_vorname" class="feld-halbiert" placeholder="Vorname"/>&nbsp;
						<input type="text" required align-right name="kontakt_name" class="feld-halbiertRechts" placeholder="Nachname" />			
					</li>
					<li>
						<label>E-Mail Adresse</label>
						<input required type="email" name="kontakt_email" class="feld-lang" />
					</li>
					<li>
						<label>Betreff</label>
						<input type="text" required name="kontakt_betreff" class="feld-lang" />
					</li>
					<li>
						<label>Mitteilung</label>
						<textarea required type="text" name="kontakt_mitteilung" class="feld-lang feld-textarea"/></textarea>
					</li>
					<li>
						<input type="submit" value="Abschicken" />
					</li>
				</ul>
			</form>
<?php	
}	
else
{

	if(!isset($_GET["page"])) 
	{
	## Username aus DB auslesen ##
			$sql = $db->query("SELECT * FROM user WHERE user_email = '$loginuser'");		
			while($row = $sql->fetch_object())
			{	
	?>
	<p><b>Hallo <?php echo $row->user_vorname . " " . $row->user_name ; ?></b></p>
		<p>Wenn du Fragen, Anregungen oder Probleme auf der Website hast, dann melde dies bitte hier.</p>
			<form method="post" action="index.php?section=kontakt&page=2">
				<ul class="formstyle">
						<li>
							<label>Name</label>
							<input type="text" readonly required name="kontakt_vorname" class="feld-halbiertReadOnly" value="<?php echo $row->user_vorname; ?>"/>&nbsp;
							<input type="text" readonly required align-right name="kontakt_name" class="feld-halbiertRechtsReadOnly" value="<?php echo $row->user_name; ?>" />			
						</li>
						<li>
							<label>E-Mail Adresse</label>
							<input readonly required type="email" name="kontakt_email" class="feld-langReadOnly" value="<?php echo $row->user_email; ?>"/>
						</li>
						<li>
							<label>Betreff</label>
							<input type="text" autofocus required name="kontakt_betreff" class="feld-lang" />
						</li>
						<li>
							<label>Mitteilung</label>
							<textarea required type="text" name="kontakt_mitteilung" class="feld-lang feld-textarea"/></textarea>
						</li>
						<li>
							<input type="submit" value="Abschicken" />
						</li>
					</ul>
				</form>
	<?php	
			}
	}
}

if(isset($_GET["page"])) 
{
	if($_GET["page"] == "2") 
	{
		$kontakt_email = $_POST['kontakt_email'];
		$kontakt_vorname = $_POST['kontakt_vorname'];
		$kontakt_name = $_POST['kontakt_name'];
		$kontakt_betreff = $_POST['kontakt_betreff'];
		$kontakt_mitteilung = $_POST['kontakt_mitteilung'];
		
		$mail = "terminbot@umgekehrt.ch";	
		$mailinhalt = "Absendername: " . $kontakt_vorname . " " . $kontakt_name . "\n\n" . $kontakt_mitteilung;
		

					
					
		/* Sicherheit */
		$checked_kontakt_email = str_replace(array("\n", "\r"), '', $kontakt_email);
		$checked_mail = str_replace(array("\n", "\r"), '', $mail);
		
		$absender = 'From: terminbot@umgekehrt.ch' . "\r\n" .
			'Reply-To: '. $checked_kontakt_email . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		mail($checked_mail, $kontakt_betreff, $mailinhalt, $absender);?>
		
							<section id="meldungOK">
								<p id="meldungTitel">Hinweis</p>
								<p>Dein Anfrage wurde erfolgreich abgeschickt.</p>
							</section>
		
		<!--<meta http-equiv="refresh" content="2; URL=http://umgekehrt.ch/tbz/test/index.php" />-->
		<?php
	}
}
?>

