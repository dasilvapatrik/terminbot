<?php
if ($_SESSION['loginname'] == '')
	{
		include("login.php");
	}
	else
	{
		include("privatbereich.php");
	}
?>