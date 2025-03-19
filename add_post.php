<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'auth_example';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'Ошибка подключения к базе данных']));
}

$data = json_decode(file_get_contents('php://input'), true);
$content = $data['content'];
$user_id = $data['user_id']; // ID пользователя, создавшего сообщение
$topic_id = $data['topic_id']; // ID темы, к которой относится сообщение

$stmt = $pdo->prepare("INSERT INTO posts (content, user_id, topic_id) VALUES (?, ?, ?)");
if ($stmt->execute([$content, $user_id, $topic_id])) {
    echo json_encode(['success' => true, 'message' => 'Сообщение успешно добавлено']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении сообщения']);
}
?>