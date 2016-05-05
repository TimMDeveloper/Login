<?php
if (User::loggedIn())
{
	header("Location: {$config['url']}/index.php?p=home");
	exit("Beste {$user->data('username')}, u bent al ingelogd. <a href='{$config['url']}/index.php?p=home'>Klik hier om naar het ingelogde deel te gaan.</a>");
}
if (isset($_POST['register']))
{
	$array = User::register($_POST['username'], $_POST['password']);
	if (is_array($array))
	{
		if (isset($array['id']))
		{
			$_SESSION['id'] = $array['id'];
			$error = $array['msg'];
			header("Location: {$config['url']}/index.php?p=home");
			exit("Beste {$_POST['username']}, u bent succesvol ingelogd. <a href='{$config['url']}/index.php?p=home'>Klik hier om naar het ingelogde deel te gaan.</a>");
		}
		else
		{
			$error = $array['msg'];
		}
	}
	else
	{
		$error = 'Er is een fout opgetreden want er wordt geen array return.';
	}

}
?>
<?= "<div class='error'>".$error."</div>" ?>
<form method="POST">
	<input type="text" name="username" placeholder="Gebruikersnaam">
	<input type="password" name="password" placeholder="Wachtwoord">
	<input type="submit" name="register" value="Registreren">
</form>
