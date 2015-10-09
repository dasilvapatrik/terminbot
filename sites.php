<?php
	switch($section)
	{
		/*case "login":
			include("login.php"); 
		break;
				
		case "privatbereich":
			include("privatbereich.php"); 
		break;*/
		
		case "hilfe":
			include("hilfe.php"); 
		break;
		
		case "kontakt":
			include("kontakt.php"); 
		break;

		case "registrierung":
			include("registrierung.php"); 
		break;
	
		case "logout":
			include("logout.php"); 
		break;		
		
		case "event_erstellen":
			include("event_erstellen.php"); 
		break;
		
		case "event":
			include("event.php"); 
		break;

		case "test":
			include("test.php"); 
		break;
		
		default:
			include("startseite.php"); 
		break;
	}