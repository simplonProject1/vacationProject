<?php

	if (isset($_POST['rememberMe'])) {
	    if (isset($_POST ['login'])) {
	    	setcookie("username111",$_POST['username'], time()+3600);
	    	setcookie("password111",$_POST['password'], time()+3600);
	   }
	}

	$error = false;

	if(isset($_POST['login'])) {

	    $users = simplexml_load_file('database.xml');
	    $usersArray = [];
	    for ($i = 0; $i < count($users); $i++) {
	        $userNew = trim($users->person[$i]->username);
	        $passwordNew = trim($users->person[$i]->psw);
	        $usersArray[$userNew] = $passwordNew;
	    }

	    $username = $_POST['username'];
	    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


		foreach ($usersArray as $key => $value) {
			if (($key == $username) && (password_verify($value, $password))) {
				session_start();
				$_SESSION['username'] = $username;
				header('Location: index.php');
				die;
			}
			$error = true;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css.css" />
</head>
<body>
	<h2>Apprenant.e, connecte toi</h2>
	<form method="post" action="">
		<label for="username"><b>Nom d'utilisateur</b></label>
		<input type="text" name="username" value="<?php if(isset($_COOKIE['username111'])){ echo $_COOKIE['username111'];}?>" required><br><br>
		<label for="password"><b> Mot de passe </b></label>
		<input type="password" name="password" value="<?php if(isset($_COOKIE['password111'])){ echo $_COOKIE['password111'];}?>" required><br><br>
		<?php
			if($error) {
				echo '<p>Invalid username and/or password</p>';
			}
		?>
		<input type="checkbox" name="rememberMe" title="Nous utilisons des cookies, cette option n'est donc pas 100% sécurisée"/>Se souvenir de mon nom d'utilisateur et de mon mot de passe<br>
		<p><input type="submit" value="Se connecter" name="login"></p>
	</form>
</body>
</html>
