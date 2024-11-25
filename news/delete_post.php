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
	
	if(!isset($_COOKIE["session"])){
		header("Location: /");
		exit();
	}
	
	
	if (isset($_POST['post_id'])){
		$user_info = $db->query("SELECT * FROM users INNER JOIN session ON users.id=session.id WHERE session.cookie=\"" . $_COOKIE["session"] . "\";")->fetch_array();
	
		$post_info = $db->query("SELECT * FROM posts WHERE id_post=" . $_POST['post_id'] . ";")->fetch_array();
		$post_date = $db->query("SELECT CAST(date AS date) FROM posts WHERE id_post=" . $_POST['post_id'] . ";")->fetch_array();
		if($user_info['role'] == 'admin' || ($user_info['role']='editor' && date("Y-m-d") == $post_date['CAST(date AS date)'])){
			$db->query("DELETE FROM posts WHERE id_post=" . $_POST['post_id'] . ";");
		}
	}
	
	header("Location: /news/");	
?>	
