<?php
	switch($section)
	{
		case "hilfe":
			include("hilfe_terminbot.php"); 
		break;
		
		case "kontakt":
			include("kontakt_terminbot.php"); 
		break;

		case "registrierung":
			include("registrierung_terminbot.php"); 
		break;
	
		case "logout":
			include("logout_terminbot.php"); 
		break;		
		
		case "event_erstellen":
			include("event_erstellen_terminbot.php"); 
		break;
		
		case "event":
			include("event_terminbot.php"); 
		break;
		
		case "event_edit":
			include("event_edit_terminbot.php"); 
		break;

		case "test":
			include("test.php"); 
		break;
		
		default:
			include("startseite_terminbot.php"); 
		break;
	}