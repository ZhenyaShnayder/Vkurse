<?php
	session_start();
	if (!isset($_COOKIE["session"]) || empty($_COOKIE["session"])) {
	    header("Location: /");
	    exit();
	}

	$db = new mysqli('db', 'root', 'rootpassword', 'vkurse_db'); // Подключение к базе данных
	if (!$db) {
	    echo "<!DOCTYPE html>
	    <html>
	    <body>
	    <h1>Ошибка подключения к базе данных. Код ошибки: " . $db->connect_errno . "</h1>
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

	$vote_until = $_POST['vote_until'] ?? null;
	if ($vote == 1 && $vote_until) {
	    $current_date = date('Y-m-d H:i:s');
	    $vote_until_date = date('Y-m-d H:i:s', strtotime($vote_until));

	    if ($vote_until_date <= $current_date) {
		echo "Дата окончания голосования должна быть позже текущей даты и времени.";
		exit();
	    }
	} else {
	    $vote_until = null;
	}
	
	$path = null;
	$image_url = $_POST['path'] ?? null;
	if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
	    $upload_dir = '/var/www/html/images/'; // Папка для загрузки файлов
	    chmod($upload_dir, 0755); // Устанавливаем права доступа

	    // Допустимые расширения файлов
	    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
	    $file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

	    // Проверка расширения файла
	    if (!in_array($file_extension, $allowed_extensions)) {
		echo "Неподдерживаемый формат файла. Разрешены только JPG, JPEG, PNG и GIF.";
		exit();
	    }

	    // Генерация уникального имени файла
	    $file_name = generateUniquePostId($db) . $file_extension;
	    $file_path = $upload_dir . $file_name;

	    // Перемещение загруженного файла
	    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
		$path = '/images/' . $file_name; // Сохраняем путь в формате images/уникальное_значение.формат_файла
	    } else {
		echo "Ошибка при загрузке файла.";
		exit();
	    }
	}

	$query = "INSERT INTO posts (id_user, title, post_text, date, vote, comments, id_post, vote_until, path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $db->prepare($query);
	$stmt->bind_param("isssiiiss", $id_user, $title, $post_text, $date, $vote_int, $comments_int, $id_post, $vote_until, $path);
	
	if ($stmt->execute()) {
	    header("Location: /news/"); // Перенаправление
	    $_SESSION['message'] = "Пост успешно добавлен!";
	} else {
	    echo "Ошибка при добавлении поста: " . $stmt->error;
	}

	$stmt->close();
	$db->close();
?>
