<?php
	switch($section)
	{
		case "hilfe":
			include("hilfe.php"); 
		break;
		
		case "kontakt":
			include("kontakt.php"); 
		break;

		case "registrierung":
			include("registrierung.php"); 
		break;

		case "login":
			include("login.php"); 
		break;
		
		case "logout":
			include("logout.php"); 
		break;		
		
		case "events":
			include("events.php"); 
		break;
		
		case "event_erstellen":
			include("event_erstellen.php"); 
		break;

		case "test":
			include("test.php"); 
		break;
		
		default:
			include("startseite.php"); 
		break;
	}