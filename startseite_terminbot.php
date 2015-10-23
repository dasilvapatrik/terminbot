<?php
if ($_SESSION['loginname'] == '')
	{
		include("login_terminbot.php");
	}
	else
	{
		include("privatbereich_terminbot.php");
	}
?>