<?php

require_once __DIR__ . '/../core/init.php';

if (empty(Basket::read())) {
    die("У вас пустая корзина. Нужно добавить товары в корзину для оформления заказа.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = htmlspecialchars($_POST['customer'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $items = Basket::read();

    if (empty($customer) || empty($email) || empty($phone) || empty($address)) {
        die("Вся форма должна быть заполнена");
    }

    $order = new Order($customer, $email, $phone, $address, $items);

    if (Eshop::saveOrder($order)) {
        echo "<p>Заказ оформлен</p>";
        echo "<a href='/bookstore-php/eshop/catalog'>Вернуться в каталог</a>";
        exit;
    } else {
        echo "<p>Ошибка оформления заказа</p>";
        exit;
    }
} else {
    echo "<p>Некорректный метод запроса.</p>";
}
