<?php
/* ######### mySQLi Login ######### require_once statt include um script abzubrechen falls es nicht klappt! */
	require_once("dbconnect_terminbot.php"); 
/* ######### mySQLi Login ENDE ######### */

/* ######### Navigation ######### */
	if(isset($_GET["section"]))
		{
			$section = $_GET["section"];
		}
	else
		{
			$section = "";
		}	
/* ######### Navigation ENDE ######### */


/* ######### LoginScript ######### */
session_start();
$verhalten = 0;

if(!isset($_SESSION["loginname"]) and !isset($_GET["page"])) {
$verhalten = 0;
}
/* ######### LoginScript ENDE ######### */

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
		<!-- <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <title>TerminBot - eine erweiterte Eventanmeldungsplattform</title>
		<meta name="copyright" content="Patrik da Silva">
		<meta name="description" content="TerminBot - eine erweiterte Eventanmeldungsplattform 1.0">
		<meta name="keywords" content="Terminfindung, Eventanmeldungsplattform, Eventanmeldeplattform, Anmeldeplattform, Termine finden, Termine organisieren, Termine erstellen">
		<meta name="audience" content="Alle"><meta http-equiv="content-language" content="de">
		<meta name="robots" content="index, nofollow">
		
		<LINK REL="SHORTCUT ICON" HREF="img/terminbot.ico" />
        <link rel="stylesheet" href="css/terminbot.css" type="text/css" media="screen" />
		<script src="js/ckeditor/ckeditor.js"></script>
		<script src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.menubutton').click(function() {
					$('nav').slideToggle('slow');
				});
			});
		</script>
  	</head>

	<body>
		<header>
			<div id="titelbild"></div>
		</header>
		<section id="wrapper">
			<section id="inhaltsbereich"> <!-- Inhaltsbereich Weisser Container mit blauem Rand -->		
				<?php include("nav_terminbot.php");	/* Navigation */?>	
				<?php include("sites.php"); /* Seitenauswahl-Default: startseite.php*/?>
			</section>
			
			<footer>
				<p>Vertiefungsarbeit im 5. Semester an der TBZ HF<br><b>Patrik da Silva ITSE13a</b></p>
			</footer>
			<br class="clear"/>
		</section>
	</body>
</html>
