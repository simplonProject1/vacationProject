<?php
	$error = false;

	if(isset($_POST['login'])) {

        class User {
            var $username;
            var $psw;
            
            function User ($aa) {
                foreach ($aa as $k=>$v)
                    $this->$k = $aa[$k];
            }
        }

        function readDatabase($filename) {
            // read the XML database of Users
            $data = implode("", file($filename));
            $parser = xml_parser_create();
            xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
            xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
            xml_parse_into_struct($parser, $data, $values, $tags);
            xml_parser_free($parser);

            // loop through the structures
            foreach ($tags as $key=>$val) {
                if ($key == "person") {
                    $molranges = $val;
                    // each contiguous pair of array entries are the 
                    // lower and upper range for each molecule definition
                    for ($i=0; $i < count($molranges); $i+=2) {
                        $offset = $molranges[$i] + 1;
                        $length = $molranges[$i + 1] - $offset;
                        $tdb[] = parseMol(array_slice($values, $offset, $length));
                    }
                } else {
                    continue;
                }
            }
            return $tdb;
        }

        function parseMol($mvalues) {
            for ($i=0; $i < count($mvalues); $i++) {
                $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
            }
            return new User($mol);
        }

        $db = readDatabase("database.xml");


		$usersArray = [];
		foreach ($db as $key => $value) {
		    $usersArray[$value->username] = $value->psw;
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