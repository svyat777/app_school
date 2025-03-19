<?php
session_start();
header('Content-Type: application/json');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json'); // Указываем, что ответ будет JSON


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
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к базе данных']);
    exit;
}

// Получение данных из формы
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$role = isset($_POST['choice']) ? $_POST['choice'] : 'user';

// Проверяем, заполнены ли все поля
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Fill all fields!']);
    exit;
}

// Проверка, существует ли пользователь
$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
$stmt->execute([$username]);
$userExists = $stmt->fetch();

if ($userExists) {
    echo json_encode(['success' => false, 'message' => 'User with that name already exists']);
    exit;
}

// Хешируем пароль
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Добавляем нового пользователя
$stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
$stmt->execute([$username, $hashedPassword, $role]);

// Сохраняем сессию после регистрации
$_SESSION['user_id'] = $pdo->lastInsertId();
$_SESSION['username'] = $username;

echo json_encode(["success" => true, "message" => "Registration sucess!"]);
exit;
?>
