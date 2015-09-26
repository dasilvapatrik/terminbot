<?php
## GLOBAL ##
$loginuser = mysqli_real_escape_string($db, $_SESSION['loginname']);
## GLOBAL ENDE ##

if ($_SESSION['loginname'] == '')
{
?>
<section id="menubar">
	<ul>
		<li><a class="menubutton" href="#menu"><img src="img/menu.png" /></a></li>
	</ul>
</section>
<nav class="nav">
	<ul>
		<li><a class="nav" href="index.php?section=startseite">Startseite</a></li>
		<li><a class="nav" href="index.php?section=hilfe">Hilfe</a></li>
		<li><a class="nav" href="index.php?section=kontakt">Kontakt</a></li>
	</ul>
</nav>
<?php	}	else	{	?>
<section id="menubar">
	<ul>
		<li><a class="menubutton" href="#menu"><img src="img/menu.png" /></a></li>
	</ul>
</section>
<nav class="nav">
	<ul>
		<li><a class="nav" href="index.php?section=startseite">Startseite</a></li>
		<li><a class="nav" href="index.php?section=hilfe">Hilfe</a></li>
		<li><a class="nav" href="index.php?section=kontakt">Kontakt</a></li>
		<li><a class="nav" href="index.php?section=logout">Logout</a></li>
	</ul>
</nav>
<?php	}	?>
