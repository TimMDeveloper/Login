<?php
if (isset($_POST['login']))
{
	 if ($user = User::ByUsername($_POST['username']) !== '0')
	 {
		if(User::ByUsername($_POST['username']) != false)
		{
		  	$user = User::ByUsername($_POST['username']);
	  		if($user->login($_POST['password']))
	  		{
	  			$_SESSION['id'] = $user->data("id");
	  			$user->session($user->data('id'));
				$error = 'Logged in succesfully';
	  		}
			else 
			{
		    	$error = 'Wrong password!';
			}
		} 
		else
		{
		  $error = 'Username not found!';
		}
	}
}

?>
<?= "<div class='error'>".$error."</div>" ?>
<form method="POST">
	<input type="text" name="username" placeholder="Gebruikersnaam">
	<input type="password" name="password" placeholder="Wachtwoord">
	<input type="submit" name="login" value="Inloggen">
</form>