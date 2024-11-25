<?php
	$db = new mysqli('127.0.0.1', 'root', '', 'vkurse_db'); // connect to database
	
	if (!$db) {
		echo "<!DOCTYPE html>
		<html>
		<body>
		<h1>Connection to DB failed. Errno:" . $db->connect_errno . "</h1>
		</body>
		</html>"; 
		exit();
	}

	$db->set_charset("utf8"); // set charset

    	if(!isset($_POST['email']) || !isset($_POST['password'])){
    		header("Location: /");
    		exit();
    	}

	// construct SELECT person query
	$query = "SELECT id, role, departament FROM users WHERE email = '" . $_POST['email'] . "' AND password = '" . $_POST['password'] . "';";
	//echo "Select user query: $query" . "\n"; //*
	
	$result = $db->query($query); // send query
	
	if (!$result){
		echo "Select user query failed \n";
		exit();
	}
	
	$user_info = $result->fetch_array(); // take first row
	if($user_info == null){
		header("Location: /");
		echo "User wasn't found\n";
		exit();
	}

	// check session existance
	$query ="SELECT * FROM session WHERE id = '" . $user_info['id'] . "'";
	echo " Select session query: $query\n"; //*

	$result = $db->query($query); // send query
	if (!$result){
		echo "Select session query failed\n";
		exit();
	}
	$session_row = $result->fetch_array();

	if ($session_row != null){
		$query ="DELETE FROM session WHERE id = '" . $session_row['id'] . "'";
		// echo "Delete session query: $query\n"; //*

		$result = $db->query($query); // send query

		if (!$result){
			echo "Delete query failed \n";
			exit();
		}
	}

	// generate cookie
	$cookie = hash('sha256', $user_info['email'] . date(DATE_RFC2822));
	echo "New Cookie: $cookie\n
	User email:", $user_info['email'], "\n
	Date:", date(DATE_RFC2822), "\n";


	// construct INSERT session query
	$query = "INSERT INTO session VALUES(" . $user_info['id'] . ", '" . $cookie . "')";
	echo "Insert session query: $query "; //*

	$result = $db->query($query); // send query
	if (!$result){
		echo "Insert Query failed \n";
		exit();
	}

	header("Location: /news/"); // redirrect
	setcookie('session', $cookie); // set new cookie 
	//$db->close();
?>

