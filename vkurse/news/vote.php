<?php
	session_start();

	// Проверка наличия сессии
	if (!isset($_COOKIE["session"]) || empty($_COOKIE["session"])) {
	    header("Location: /");
	    exit();
	}

	// Подключение к базе данных
	$db = new mysqli('db', 'root', 'rootpassword', 'vkurse_db');
	if ($db->connect_error) {
	    die("Connection failed: " . $db->connect_error);
	}

	// Получение данных из POST
	$post_id = $_POST['post_id'] ?? null;
	$vote = isset($_POST['vote']) ? (int) $_POST['vote'] : null; // Проверка наличия ключа 'vote'

	// Получение user_id из сессии
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
	$user_id = $row['id'];

	// Обработка голоса
	if ($post_id && $vote !== null) {
	    // Проверяем, голосовал ли пользователь ранее
	    $query = "SELECT vote FROM votes WHERE id_post = ? AND id_user = ?";
	    $stmt = $db->prepare($query);
	    $stmt->bind_param("ii", $post_id, $user_id);
	    $stmt->execute();
	    $result = $stmt->get_result();

	    if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$previous_vote = (int) $row['vote']; // Получаем предыдущий голос

		if ($previous_vote === $vote) {
		    // Если пользователь выбрал тот же вариант, удаляем голос (отмена)
		    $query = "DELETE FROM votes WHERE id_post = ? AND id_user = ?";
		    $stmt = $db->prepare($query);
		    $stmt->bind_param("ii", $post_id, $user_id);
		} else {
		    // Если пользователь изменил голос, обновляем
		    $query = "UPDATE votes SET vote = ? WHERE id_post = ? AND id_user = ?";
		    $stmt = $db->prepare($query);
		    $stmt->bind_param("iii", $vote, $post_id, $user_id);
		}
	    } else {
		// Если пользователь не голосовал, добавляем новый голос
		$query = "INSERT INTO votes (id_post, id_user, vote) VALUES (?, ?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("iii", $post_id, $user_id, $vote);
	    }

	    // Выполняем запрос и перенаправляем
	    if ($stmt->execute()) {
		header("Location: /news/"); // Перенаправление обратно на страницу поста
		exit(); // Завершаем выполнение скрипта
	    } else {
		echo "Ошибка при обработке голоса: " . $stmt->error;
	    }
	} else {
	    echo "Неверные данные.";
	}

	$stmt->close();
	$db->close();
?>
