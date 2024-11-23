<?php
	if(!isset($_COOKIE["test_cookie"])){
		header("Location: /");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="news.css">
		<script src="news.js"></script>
	</head>
	<body>
		<button class="outside" onclick="proverka();">Выйти</button>
	</body>
</html>
