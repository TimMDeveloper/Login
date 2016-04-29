<?php
if (!User::loggedIn())
{
	header("Location: {$config['url']}");
	exit("Je hebt geen toegang om deze pagina te bekijken. <a href='{$config['url']}'>Klik hier om naar de inlogpagina te gaan.</a>");
}
?>
<a href="?p=logout">Uitloggen</a><br>
Beste <?= $user->data("username") ?>,<br><br>

Welkom op het ingelogde deel van dit LoginSysteem.<br><br>

Powered by <a href="http://timdev.nu">TimDev</a>.