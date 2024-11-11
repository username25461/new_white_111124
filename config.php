<?php
function getLanguage() {
    if (isset($_GET['sub12'])) {
		$country = strtolower($_GET['sub12']);
		if ($country === 'nz' || $country === 'uk' || $country === 'au' || $country === 'en') {
			$country = 'en';
		}else if ($country === 'be' || $country === 'fr') {
			$country = 'fr';
		}else $country = $_GET['sub12'];
	}
	else {$country = 'en';}
	return $country;
}

$products = [
                ['category' => 'cosmetics', 'name' => 'Lip Oil', 'img' => 'clar', 'indez' => '0'],
                ['category' => 'cosmetics', 'name' => 'Lip Gloss', 'img' => 'kik', 'indez' => '1'],
                ['category' => 'perfume', 'name' => 'Perfume Sample Set', 'img' => 'seph', 'indez' => '0'],
                ['category' => 'pets', 'name' => 'Dry Pet Food', 'img' => 'royalcan', 'indez' => '0'],
                ['category' => 'electrboiler', 'name' => 'Electric Kettle', 'img' => 'electrboiler', 'indez' => '0'],
                ['category' => 'food', 'name' => 'Fast Food Set', 'img' => 'kf', 'indez' => '0'],
                ['category' => 'cosmetics', 'name' => 'Face Cream', 'img' => 'ritual', 'indez' => '2'],
                ['category' => 'food', 'name' => 'Fast Food Set', 'img' => 'mcdo', 'indez' => '1'],
                ['category' => 'perfume', 'name' => 'Eau de Toilette Spray', 'img' => 'victorsec', 'indez' => '1'],
                ['category' => 'pets', 'name' => 'Dog food', 'img' => 'royalcan', 'indez' => '1']
            ];

// Загрузка случайного описания товара
function loadProductDescription($category, $language, $indez) {
    $filePath = "content/{$category}_{$language}.txt";
    
    if (file_exists($filePath)) {
        $descriptions = explode("===", file_get_contents($filePath)); // Разделение описаний
        $count = count($descriptions);

        if ($count > 0) {
            // Случайный выбор описания на основе хэша
            $suffix = substr(md5($_SERVER['HTTP_HOST']), $indez, 1);
            $index = hexdec($suffix) % $count;
            return trim($descriptions[$index]);
        }
    }
    return "Description not available.";
}

// Функция для выбора случайного изображения для категории
function getRandomImage($category, $indez) {
    $images = glob("images/{$category}*.png"); // Поиск всех изображений для категории

    if (!empty($images)) {
        // Выбор случайного изображения на основе хэша
        $suffix = substr(md5($_SERVER['HTTP_HOST']), $indez, 1);
        $index = hexdec($suffix) % count($images);
        return $images[$index];
    }
    return 'images/default.jpg'; // Изображение по умолчанию, если ничего не найдено
}

// Массив для переводов интерфейса
function getTranslations($language) {
    $translations = [
        'en' => ['title' => 'Our Products', 'order' => 'Order Now', 'price' => '€1.95'],
        'fr' => ['title' => 'Nos Produits', 'order' => 'Commander Maintenant', 'price' => '1,95 €'],
        'es' => ['title' => 'Nuestros Productos', 'order' => 'Ordenar Ahora', 'price' => '€1,95'],
        'ro' => ['title' => 'Produsele noastre', 'order' => 'Comandă acum', 'price' => '9.95 lei'],
        'it' => ['title' => 'I Nostri Prodotti', 'order' => 'Ordina Ora', 'price' => '€1,95'],
        'sk' => ['title' => 'Naše produkty', 'order' => 'Ordina Ora', 'price' => '€1,95']
    ];
    return isset($translations[$language]) ? $translations[$language] : $translations['en'];
}
?>
