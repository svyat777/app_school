<?php

session_start();

// Подключение к базе данных
$host = 'localhost';
$db   = 'auth_example';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к базе данных']);
    exit;
}

// Получение данных из POST-запроса
$title = isset($_POST['title']) ? $_POST['title'] : '';

// Проверка на наличие заголовка темы
if (empty($title)) {
    echo json_encode(['success' => false, 'message' => 'Заголовок темы не может быть пустым']);
    exit;
}

// Вставка новой темы в базу данных
$user_id = $_SESSION['user_id']; // Получаем ID пользователя из сессии
$stmt = $pdo->prepare('INSERT INTO topics (title, user_id) VALUES (:title, :user_id)');
$stmt->execute(['title' => $title, 'user_id' => $user_id]);

// Возвращаем успешный ответ
echo json_encode(['success' => true, 'message' => 'Тема успешно создана']);
?>
