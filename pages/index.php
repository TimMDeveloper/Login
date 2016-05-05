<?php
if (User::loggedIn())
{
	header("Location: {$config['url']}/index.php?p=home");
	exit("Beste {$user->data('username')}, u bent al ingelogd. <a href='{$config['url']}/index.php?p=home'>Klik hier om naar het ingelogde deel te gaan.</a>");
}
if (isset($_POST['login']))
{
	if ($user = User::ByUsername($_POST['username']))
	{
	  		if($user->login($_POST['password']))
	  		{
        		$_SESSION['id'] = $user->data('id');
						$error = 'Logged in succesfully';
						header("Location: {$config['url']}/index.php?p=home");
						exit("Beste {$user->data('username')}, u bent succesvol ingelogd. <a href='{$config['url']}/index.php?p=home'>Klik hier om naar het ingelogde deel te gaan.</a>");
	  		}
			else
			{
		    	$error = 'Fout wachtwoord!';
			}
	}
	else
	{
	  $error = 'Uw gebruikersnaam klopt niet.';
	}
}
?>
<?= "<div class='error'>".$error."</div>" ?>
<form method="POST">
	<input type="text" name="username" placeholder="Gebruikersnaam">
	<input type="password" name="password" placeholder="Wachtwoord">
	<input type="submit" name="login" value="Inloggen">
</form>
<a href="?p=register">Registreer</a>
