<?php
	$errors = array();
	if(isset($_POST['login'])) {
		$username = preg_replace('/[^A-Za-z]/' , '', $_POST['username']);
		$email = $_POST['email'];
		$password = $_POST['password'];
		$c_password = $_POST['c_password'];
		if(file_exists('users/' . $username . '.xml')) {
			$errors[] = 'Username already exists';
		}
		if($username == '') {
			$errors[] = 'Username is blanc';
		}
		if($email == '') {
			$errors[] = 'Email is blanc';
		}
		if($password == '' || $c_password == '') {
			$errors[] = 'Passwords are blanc';
		}
		if($password != $c_password) {
			$errors[] = 'Passwords do not match';
		}
		if(count($errors) == 0) {
			$xml = new SimpleXMLElement('<user></user>');
			$xml->addChild('password', md5($password));
			$xml->addChild('email', $email);
			$xml->asXML('users/' .$username. '.xml');
			header('Location: login.php');
			die;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<h1>Register</h1>
	<form method="post" action="">
		<?php
			if(count($errors > 0)) {
				echo '<ul>';
				foreach ($errors as $key) {
					echo '<li>'. $key. '</li>';
				}
				echo '</ul>';
			}
		?>
		<p>Username <input type="text" name="username"></p>
		<p>Email <input type="email" name="email"></p>
		<p>Password <input type="password" name="password"></p>
		<p>Confirm password <input type="password" name="c_password"></p>
		<p><input type="submit" name="login" value="Login"></p>
	</form>
</body>
</html>