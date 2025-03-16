<?php
	$db = new mysqli('db', 'root', 'rootpassword', 'vkurse_db'); // connect to database
	
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

	$email = $_POST['email'] ?? '';
	$password = $_POST['password'] ?? '';
	if (empty($email) || empty($password)) {
	    	header("Location: /");
	    	exit();
	}
    	if(!isset($_POST['email']) || !isset($_POST['password'])){
    		header("Location: /");
    		exit();
    	}

	// construct SELECT person query
	$query = "SELECT id, role, departament, email FROM users WHERE email = ? AND password = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param("ss", $email, $password);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows > 0) {
		$user_info = $result->fetch_array(); // take first row

		// check session existance
		$query = "SELECT * FROM session WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $user_info['id']);
		$stmt->execute();
		$result = $stmt->get_result();
		$session_row = $result->fetch_array();

		if ($session_row != null){
			$query = "DELETE FROM session WHERE id = ?";
			$stmt = $db->prepare($query);
			$stmt->bind_param("i", $user_info['id']);
			$stmt->execute();
		}

		// generate cookie
		if ($user_info == null) {
		    echo "Пользователь не найден.";
		    exit();
		}
		$cookie = hash('sha256', $user_info['email'] . date(DATE_RFC2822));
		//echo "New Cookie: $cookie\n
		//User email:", $user_info['email'], "\n
		//Date:", date(DATE_RFC2822), "\n";


		// construct INSERT session query
		$query = "INSERT INTO session VALUES(" . $user_info['id'] . ", '" . $cookie . "')";
		//echo "Insert session query: $query "; //*

		$result = $db->query($query); // send query
		if (!$result){
			echo "Insert Query failed \n";
			exit();
		}

		header("Location: /news/"); // redirrect
		setcookie('session', $cookie); // set new cookie 
	} else{
		header("Location: /"); // redirrect
		echo "User wasn't found\n";
			exit();
	}
	$stmt->close();
	//$db->close();
?>

