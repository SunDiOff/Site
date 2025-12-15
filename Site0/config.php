<?php
// Конфигурация базы данных
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // замените на вашего пользователя
define('DB_PASS', ''); // замените на ваш пароль
define('DB_NAME', 'user_management');

// Старт сессии
session_start();

// Подключение к базе данных
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    return $conn;
}

// Проверка авторизации
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Перенаправление если не авторизован
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>