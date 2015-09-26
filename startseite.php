<?php
if ($_SESSION['loginname'] == '')
	{
		include("login.php");
	}
	else
	{
		include("events.php");
	}
?>