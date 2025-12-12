<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header("Location: login_register.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }

    include 'config/db.php';

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $size = isset($_POST['size']) ? $_POST['size'] : 'Vừa';
        $quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1; 

        if ($product_id <= 0) {
            header("Location: menu.php");
            exit();
        }

        $sql = "SELECT name, base_price, image_path FROM products WHERE product_id = $product_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 0) {
            header("Location: menu.php"); 
            exit();
        }
        $product_db = $result->fetch_assoc();
        $conn->close();

        $base_price = $product_db['base_price'];
        $price_increase = ($size == 'Lớn') ? 5000 : 0;
        $final_price = $base_price + $price_increase;

        $item_id = $product_id . '_' . $size;

        if (array_key_exists($item_id, $_SESSION['cart'])) {
            $_SESSION['cart'][$item_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$item_id] = [
                'id' => $product_id,
                'name' => $product_db['name'],
                'size' => $size,
                'price' => $final_price,
                'quantity' => $quantity,
                'image' => $product_db['image_path']
            ];
        }
    }

    header("Location: checkout.php"); 
    exit();
?>