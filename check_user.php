<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$role = $data['role'];

// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=forum', 'root', '');

// Проверка существования пользователя
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND role = :role');
$stmt->execute(['username' => $username, 'role' => $role]);
$user = $stmt->fetch();

echo json_encode(['exists' => !!$user]);
?>