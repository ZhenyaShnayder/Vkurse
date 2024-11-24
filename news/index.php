<?php
	if(!isset($_COOKIE["session"])){
		header("Location: /");
		exit;
	}
	
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
	
	if ($db->query("SELECT * FROM session WHERE cookie='" . $_COOKIE["session"] . "';")->fetch_array() == null){
		header("Location: /");
	}
	
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="news.css">
		<script src="news.js"></script>
		<title>News</title>
	</head>
	<body>
		<div class='panel'>
			<h1>Vkurse</h1>
			<div class="Name_out">
				<button class="outside" onclick="proverka();">Выйти</button>
				<pre>Ivan Aktanov</pre>
			</div>
		</div>
	</body>
</html>
