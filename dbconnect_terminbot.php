<?php

# Konfiguration

/*
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "terminbot";*/

$db_host = "localhost";
$db_user = "terminbotuser";
$db_pass = "xDWpR88m56L7PShs";
$db_name = "terminbot";

# Verbindung

$db = @new mysqli($db_host, $db_user, $db_pass, $db_name);
	if($db->connect_error)
	{
		die("<pre>" . $db->connect_error . "</pre>");
	}
	
?>