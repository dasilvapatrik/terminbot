<section id="inhalttitel">Kontakt</section>
<?php
if(!isset($_GET["page"])) 
{
?>
<p>Wenn du Fragen, Anregungen oder Probleme auf der Website hast, dann melde dies bitte hier.</p>
	<form method="post" action="index.php?page=2">
		<ul class="formstyle">
				<li>
					<label>Name</label>
					<input type="text" required name="kontakt_vorname" class="feld-halbiert" placeholder="Vorname"/>&nbsp;
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
					<input required type="text" name="kontakt_mitteilung" class="feld-lang feld-textarea" />
				</li>
				<li>
					<input type="submit" value="Abschicken" />
				</li>
			</ul>
		</form>
<?php
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
		
		
		$gesendet = "Deine Einladung wurde an den Empfänger gesendet.";
		
		mail($mail, $kontakt_betreff, $mailinhalt, $kontakt_email);
		echo "<br>an: " . $mail;
		echo "<br><br>betreff: " . $kontakt_betreff;
		echo "<br><br>mitteilung: " . $kontakt_mitteilung;
		echo "<br><br>absender: " . $kontakt_email;
		echo $gesendet;
		?>
		<meta http-equiv="refresh" content="2; URL=http://umgekehrt.ch/tbz/test/index.php" />
		<?php
	}
}
?>

