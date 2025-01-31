<?php
$servername = "localhost";
$username = "root";  // Cseréld ki a saját MySQL felhasználónevedre
$password = "";      // Cseréld ki a saját MySQL jelszavadra
$dbname = "bolt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Termékek lekérése
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProducts') {
    $result = $conn->query("SELECT * FROM termek");
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
    exit();
}

// Rendelések lekérése az üzenőfalhoz
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getOrders') {
    $result = $conn->query("SELECT f.nev, t.termeknev, k.mennyiseg, k.egysegar, k.ido FROM kosar k JOIN felhasznalo f ON k.felhid = f.id JOIN termek t ON k.termekkod = t.tkod ORDER BY k.ido DESC");
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    echo json_encode($orders);
    exit();
}

// Rendelés mentése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $customerName = $conn->real_escape_string($data['customer']);
    $cart = $data['cart'];

    // Felhasználó mentése
    $conn->query("INSERT INTO felhasznalo (nev) VALUES ('$customerName')");
    $felhid = $conn->insert_id;
    
    // Termékek mentése a kosárba
    foreach ($cart as $item) {
        $termekkod = (int)$item['id'];
        $mennyiseg = 1;
        $egysegar = (int)$item['price'];
        $conn->query("INSERT INTO kosar (felhid, termekkod, mennyiseg, egysegar) VALUES ($felhid, $termekkod, $mennyiseg, $egysegar)");
    }
    echo json_encode(["success" => true]);
    exit();
}
?>
