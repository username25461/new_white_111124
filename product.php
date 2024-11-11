<?php
include 'config.php';

// Получение названия товара из параметра URL
$productName = isset($_GET['name']) ? $_GET['name'] : null;
$language = getLanguage();
$translations = getTranslations($language);
$hash = md5($_SERVER['HTTP_HOST']);



// Поиск информации о товаре
$product = null;
foreach ($products as $item) {
    if ($item['name'] === $productName) {
        $product = $item;
        break;
    }
}

// Если товар не найден, отобразить сообщение об ошибке
if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

// Загрузка описания и изображения
$description = loadProductDescription($product['category'], $language, $product['indez']);
$image = getRandomImage($product['img'], $product['indez']);
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1><?php echo $translations['title']; ?></h1>
    </header>
    
    <main>
        <div class="product-detail">
            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($description); ?></p>
            <p class="price"><?php echo $product['price']; ?></p>
            <a href="order.php?product=<?php echo urlencode($product['name']); ?>" class="order-btn"><?php echo $translations['order']; ?></a>
        </div>
    </main>

    <footer class="<?php echo $hash; ?>">
        <a href="terms.html">Terms & Conditions</a> |
        <a href="privacy.html">Privacy policy</a> |
        <a href="return.html">Returns, Refunds and Exchanges Policy</a>
    </footer>
</body>
</html>
