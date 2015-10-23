<script>
function copyToClipboard(elementId) {

  // Create a "hidden" input
  var aux = document.createElement("input");

  // Assign it the value of the specified element
  aux.setAttribute("value", document.getElementById(elementId).innerHTML);

  // Append it to the body
  document.body.appendChild(aux);

  // Highlight its content
  aux.select();

  // Copy the highlighted text
  document.execCommand("copy");

  // Remove it from the body
  document.body.removeChild(aux);

}
</script>


<p id="p1">P1: I am paragraph 1</p>
<p id="p2">P2: I am a second paragraph</p>
<button class="buttonstyle" onclick="copyToClipboard('p1')">Copy P1</button>
<button class="buttonstyle" onclick="copyToClipboard('p2')">Copy P2</button>
<br/><br/><input type="text" placeholder="Paste here for test" />

					<form>
				<ul class="formstyle">
					<li>
						<label>Direktlink1</label>
						<input id="p11" type="text" readonly name="event_link" class="feld-lang" value="P1: I am paragraph 1"/></input>
					</li>
					<li>
						<label>Direktlink2</label>
						<input id="p22" type="text" readonly name="event_link" class="feld-lang" value="P2: I am a second paragraph"/></input>
					</li>
					<li>
					<input type="text" placeholder="Paste here for test" />
					</li>
				</ul>
			</form>
			<button onclick="copyToClipboard('p11')">Copy P1</button>
			<button onclick="copyToClipboard('p22')">Copy P2</button>
			<br>
			
			
<article>
<?php
if(!isset($_GET["page"])) 
{
?>

	<form method="post" action="index.php?section=test&page=2">
		<ul class="formstyle">
				<li>
					<label>Direktlink</label>
					<input required readonly type="text" name="direktlink" class="feld-lang" value="http://localhost/terminbot/index.php?section=test" />
				</li>
					<label>E-Mail Empfänger</label>
					<input autofocus type="text" name="email" class="feld-lang" />
				<li>
					<input type="submit" value="senden" />
					<input type="reset" value="reset" />
				</li>
			</ul>
		</form>
<?php
}
if(isset($_GET["page"])) 
{
	if($_GET["page"] == "2") 
	{
		$direktlink = $_POST['direktlink'];
		$mail 		= $_POST['terminbot@umgekehrt.ch'];

		
		
		$absender = 'From: terminbot@umgekehrt.ch' . "\r\n" .
					'Reply-To: terminbot@umgekehrt.ch' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
			
$betreff = "TerminBot - Eventeinladung";
$inhalt = "Hallo, Du wurdest zu folgenden Event eingeladen. Hier ist der direktlink:\n" . $direktlink . "\n\n
Bitte folge dem Link und Log dich auf Terminbot-Plattform an und bestätige die Einladung.\n\n
Beste Grüsse\n\n\n
TerminBot - eine erweiterte Eventanmeldungsplattform.\n";
					
		$gesendet = "Deine Einladung wurde an den Empfänger gesendet.";
		
		mail($mail, $betreff, $inhalt, $absender);
		echo "<br>direktlink: " . $direktlink;
		echo "<br><br>mail: " . $mail;
		echo "<br><br>absender: " . $absender;
		echo "<br><br>betreff: " . $betreff;
		echo "<br><br>inhalt: " . $inhalt;
		echo $gesendet;
	}
}
if(isset($_GET["page"])) 
{
	if($_GET["page"] == "3") 
	{
		
		echo "<br><br>hallo seite 3 ";

	}
}
?>
</article>

	<article>
		<h1>CK Editor</h1>
		<?php
			if(!isset($_GET["page"])) 
			{
			?>
			<p>Du kannst deinen Gästen auch direkt eine Einladung per E-Mail senden.<br>Bitte gibt die E-Mail Adresse des Empfängers ein.<br>Nach dem senden kannst Du den nächsten Empfänger eingeben.<p>
				<form method="post" action="index.php?section=test&ckeditor=2">
					<ul class="formstyle">
							<li>
								<label>Beschreibung</label>
								<li>
									<textarea type="text"  id="editor1" name="event_beschreibung"/>   This is my textarea to be replaced with CKEditor.</textarea>
										<script>
											// Replace the <textarea id="editor1"> with a CKEditor
											// instance, using default configuration.
											CKEDITOR.replace( 'editor1' );
										</script>
								</li>
							</li>
							<li>
								<input type="submit" value="OK" />
							</li>
						</ul>
					</form>
			<?php
			}
			if(isset($_GET["ckeditor"])) 
			{
				if($_GET["ckeditor"] == "2") 
				{
					//$event_beschreibung = mysqli_real_escape_string($db, $_POST['event_beschreibung']);
					//$event_beschreibung = str_ireplace('\r\n', '', $event_beschreibung);
					
					$event_beschreibung = $_POST['event_beschreibung'];
					
					echo "beschreibung: <br><br>" . $event_beschreibung;
					echo "<hr>";
					?>
					<form method="post" action="index.php?section=test&ckeditor=2">
					<ul class="formstyle">
							<li>
								<label>auslesen aus post</label>
								<li>
									<textarea type="text"  id="editor1" name="event_beschreibung" />   <?php echo $event_beschreibung; ?></textarea>
										<script>
											// Replace the <textarea id="editor1"> with a CKEditor
											// instance, using default configuration.
											CKEDITOR.replace( 'editor1' );
										</script>
								</li>
							</li>
						</ul>
					</form>
					<?php
				}
			}?>
	</article>

