<?php
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Неизвестная ошибка'
];

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data === null) {
        throw new Exception('Некорректные данные');
    }

    $requiredFields = ['first_name', 'last_name', 'email', 'password'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Поле {$field} обязательно для заполнения");
        }
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Некорректный email');
    }

    if (strlen($data['password']) < 6) {
        throw new Exception('Пароль должен быть не менее 6 символов');
    }

    $db = new mysqli('db', 'root', 'rootpassword', 'vkurse_db');
    if (!$db) {
        throw new Exception('Ошибка подключения к базе данных');
    }

    $db->set_charset("utf8");

    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $data['email']);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        throw new Exception('Этот email уже зарегистрирован');
    }

    $hashedPassword = $data['password'];//password_hash($data['password'], PASSWORD_DEFAULT);

    function generateUniqueUserId($db) {
	    $query = "SELECT MAX(id) as max_id FROM users";
	    $result = $db->query($query);
	    $row = $result->fetch_assoc();
	    return $row['max_id'] + 1;
	}

	$user_id = generateUniqueUserId($db);
    $middle_name = $data['middle_name'] ?? '';

    $stmt = $db->prepare("INSERT INTO users (id, name, surname, middle_name, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss",
        $user_id, 
        $data['first_name'],
        $data['last_name'],
        $middle_name,
        $data['email'],
        $hashedPassword
    );

    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Регистрация успешна'
        ];
    } else {
        throw new Exception('Ошибка при сохранении данных');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    if (isset($db)) {
        $db->close();
    }
}

echo json_encode($response);
?>