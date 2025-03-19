<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['username' => 'Аноним']);
    exit;
}

// Теперь возвращаем сохраненный в сессии ник
echo json_encode(['username' => $_SESSION['username']]);
?>
