<?php
require_once '../../core/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Метод не POST. Проверьте форму.");
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';
$isAdmin = isset($_POST['is_admin']) ? 1 : 0;

if (empty($username) || empty($password)) {
    exit("Логин и пароль обязательны.");
}

$hashedPassword = Eshop::createHash($password);

$user = new User($username, $hashedPassword, $email, $isAdmin);

try {
    Eshop::userAdd($user);
    header("Location: /bookstore-php/eshop/login.php");
    exit;
} catch (PDOException $e) {
    echo "Ошибка при добавлении пользователя: " . $e->getMessage();
    exit;
}
?>
