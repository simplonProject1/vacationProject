<?php
	session_start();
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		header('Location: login.php');
		die;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Page</title>
</head>
<body>
	<h1>User Page</h1>
	<h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
	<hr>
	<a href="logout.php">Logout</a>
</body>
</html>