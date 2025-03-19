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

$topic_id = $_GET['topic_id'];
$stmt = $pdo->prepare("SELECT * FROM messages WHERE topic_id = ?");
$stmt->execute([$topic_id]);
$messages = $stmt->fetchAll();

echo json_encode(['success' => true, 'messages' => $messages]);
?>