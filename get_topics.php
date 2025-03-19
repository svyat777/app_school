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

$stmt = $pdo->query("SELECT topics.id, topics.title, users.username FROM topics JOIN users ON topics.user_id = users.id");
$topics = $stmt->fetchAll();

echo json_encode(['success' => true, 'topics' => $topics]);
?>