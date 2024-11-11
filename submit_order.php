<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;

    // Тут можно обработать данные, например, сохранить их в базу данных
    // Или отправить email

    echo "<h1>Order Confirmed</h1>";
    echo "<p>Product: " . htmlspecialchars($product) . "</p>";
    echo "<p>Phone: " . htmlspecialchars($phone) . "</p>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
    echo "<p>Quantity: " . htmlspecialchars($quantity) . "</p>";
} else {
    header('Location: index.php'); // Перенаправление, если запрос не POST
    exit();
}
