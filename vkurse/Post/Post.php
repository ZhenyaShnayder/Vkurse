<?php
	session_start();
	if(!isset($_COOKIE["session"]) || empty($_COOKIE["session"])){
		header("Location: /");
		exit();
	}
	
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

	$db->set_charset("utf8");
	
	$title = $_POST['title'] ?? '';
	$post_text = $_POST['post_text'] ?? '';
	if (empty($title) || empty($post_text)) {
	    echo "Заголовок и текст поста обязательны.";
	    exit();
	}
	$session_cookie = $_COOKIE["session"];
	$query = "SELECT id FROM session WHERE cookie = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param("s", $session_cookie);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows === 0) {
	    echo "Ошибка: сессия не найдена.";
	    exit();
	}

	$row = $result->fetch_assoc();
	$id_user = $row['id'];
	$vote = $_POST['vote'] ?? 0;
	$comments = $_POST['comment'] ?? 0;
	$vote_int = (int) $vote;
	$comments_int = (int) $comments;
	
	$date = date('Y-m-d H:i:s');
	function generateUniquePostId($db) {
	    $query = "SELECT MAX(id_post) as max_id FROM posts";
	    $result = $db->query($query);
	    $row = $result->fetch_assoc();
	    return $row['max_id'] + 1;
	}
	$id_post = generateUniquePostId($db);
	$query = "INSERT INTO posts (id_user, title, post_text, date, vote, comments, id_post) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $db->prepare($query);
	$stmt->bind_param("isssiii", $id_user, $title, $post_text, $date, $vote_int, $comments_int, $id_post);

	if ($stmt->execute()) {
		header("Location: /news/"); // redirrect
		$_SESSION['message'] = "Пост успешно добавлен!";
	} else {
		echo "Ошибка при добавлении поста: " . $stmt->error;
	}
	
	
	header("Location: /news/");
	// Закрытие соединения
	$stmt->close();
	$db->close();
?>
