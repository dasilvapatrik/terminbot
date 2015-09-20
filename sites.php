<?php
	switch($section)
	{
		case "hilfe":
			include("hilfe.php"); 
		break;
		
		case "kontakt":
			include("kontakt.php"); 
		break;

		case "registrieren":
			include("registrieren.php"); 
		break;

		case "events":
			include("events.php"); 
		break;

		case "logout":
			include("logout.php"); 
		break;
							
		default:
			include("startseite.php"); 
		break;
	}