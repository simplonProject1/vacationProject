<?php
	$error = false;

	if(isset($_POST['login'])) {

    $users = simplexml_load_file('database.xml');
    $usersArray = [];
    for ($i = 0; $i < count($users); $i++) { 
        $userNew = trim($users->person[$i]->username);
        $passwordNew = trim($users->person[$i]->psw);
        $usersArray[$userNew] = $passwordNew;
    }

		$username = preg_replace('/[^A-Za-z]/' , '', $_POST['username']);
		$password = $_POST['password'];


		foreach ($usersArray as $key => $value) {
			if (($key == $username) && ($value == $password)) {
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
</head>
<body>
	<h1>login</h1>
	<form method="post" action="">
		<p>username <input type="text" name="username"></p>
		<p>password <input type="password" name="password"></p>
		<?php
			if($error) {
				echo '<p>Invalid username and/or password</p>';
			}
		?>
		<p><input type="submit" value="Login" name="login"></p>
	</form>
</body>
</html>