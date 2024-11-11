<?php
include 'config.php';


// Получаем название товара из URL
$product = isset($_GET['product']) ? $_GET['product'] : '';

// Если товар не выбран, перенаправляем на главную страницу
if (!$product) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1>Order Your Product</h1>
    </header>

    <main>
        <section class="order-form-container">
            <h2>Order: <?php echo htmlspecialchars($product); ?></h2>

            <form action="submit_order.php" method="POST" class="order-form">
                <input type="hidden" name="product" value="<?php echo htmlspecialchars($product); ?>">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required placeholder="Your full name">

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required placeholder="Your phone number" pattern="[0-9]{10}">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Your email address">

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required>

                <button type="submit" class="submit-btn">Place Order</button>
            </form>
        </section>
    </main>

    <footer>
        <a href="terms.html">Terms & Conditions</a> |
        <a href="privacy.html">Privacy policy</a> |
        <a href="return.html">Returns, Refunds and Exchanges Policy</a>
    </footer>
</body>
</html>
