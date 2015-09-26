<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##

session_start();
if(isset($_SESSION["loginname"])) 
{




## Username aus DB auslesen ##
			$sql = $db->query("SELECT * FROM user WHERE user_email = '$loginuser'");		
			while($row = $sql->fetch_object())
					{	
?>
<section id="inhalttitel">Privatbereich von <?php echo $row->user_vorname . " " . $row->user_name ; }
?> </section>



<p>Events erstellen: hier</p>

<section id="inhalttitel">Meine Events</section>


<?php echo "hallo " . $loginuser; 
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

