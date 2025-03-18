<?php
	session_start();
	if (!isset($_COOKIE["session"])) {
	    header("Location: /");
	    exit;
	}

	$db = new mysqli('db', 'root', 'rootpassword', 'vkurse_db'); // Подключение к базе данных
	if (!$db) {
	    die("Ошибка подключения к базе данных: " . $db->connect_error);
	}

	$db->set_charset("utf8");

	// Получаем ID пользователя из сессии
	$session_cookie = $_COOKIE["session"];
	$user_id = $db->query("SELECT id FROM session WHERE cookie='" . $session_cookie . "'")->fetch_array()['id'];

	if (!$user_id) {
	    die("Ошибка: пользователь не найден.");
	}

	// Получаем данные из формы
	$id_post = $_POST['id_post'] ?? null;
	$comment_text = $_POST['comment_text'] ?? null;

	if (empty($id_post) || empty($comment_text)) {
	    die("Ошибка: не указан пост или текст комментария.");
	}

	// Генерация уникального ID для комментария
	$id_comment = $db->query("SELECT MAX(id_comment) as max_id FROM comments")->fetch_array()['max_id'] + 1;

	// Вставляем комментарий в базу данных
	$query = "INSERT INTO comments (id_comment, id_post, id_user, comment_text, date) VALUES (?, ?, ?, ?, NOW())";
	$stmt = $db->prepare($query);
	$stmt->bind_param("iiis", $id_comment, $id_post, $user_id, $comment_text);

	if ($stmt->execute()) {
	    header("Location: /news/"); // Перенаправляем обратно на страницу с постами
	} else {
	    die("Ошибка при добавлении комментария: " . $stmt->error);
	}

	$stmt->close();
	$db->close();
?>
