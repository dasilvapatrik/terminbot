<?php
/* ######### mySQLi Login ######### require_once statt include um script abzubrechen falls es nicht klappt! */
	require_once("dbconnect.php"); 
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

if(!isset($_SESSION["username"]) and !isset($_GET["page"])) {
$verhalten = 0;
}
/* ######### LoginScript ENDE ######### */

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
		<!-- <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TerminBot - eine erweiterte Eventanmeldungsplattform</title>
        <link rel="stylesheet" href="css/terminbot.css" type="text/css" media="screen" />
		<script src="js/sorttable.js"></script>
  	</head>

	<body>
		<header>
			<div id="titelbild"></div>
			<?php //include("header_menu.php"); ?>
		</header>
		
		<section id="wrapper">
			<section id="inhaltsbereich">		
				<nav>	
					<?php include("nav.php"); /* Navigationsseite */?>	
				</nav>
				
				<?php include("sites.php"); /* Seitenauswahl-Default: startseite.php*/?>
			</section>
			
			<footer>
				<p>Vertiefungsarbeit im 5. Semester an der TBZ HF<br><b>Patrik da Silva ITSE13a</b></p>
			</footer>
			<br class="clear"/>
		</section>


		

	</body>
</html>
