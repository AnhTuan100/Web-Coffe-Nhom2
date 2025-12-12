<?php
session_start();
include 'config/db.php'; 
if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: menu.php");
    exit();
}

$customer_name = $conn->real_escape_string($_POST['recipient']);
$customer_phone = $conn->real_escape_string($_POST['phone']);
$shipping_address = $conn->real_escape_string($_POST['address']);
$payment_method = $conn->real_escape_string($_POST['payment_method']);
$total_amount = 0; 

foreach ($_SESSION['cart'] as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

$sql_order = "INSERT INTO orders (customer_name, customer_phone, shipping_address, total_amount, payment_method, status) 
              VALUES ('$customer_name', '$customer_phone', '$shipping_address', $total_amount, '$payment_method', 'Mới')";

if ($conn->query($sql_order) === TRUE) {
    $order_id = $conn->insert_id;
    $sql_details = "INSERT INTO order_details (order_id, product_id, product_name, quantity, unit_price, size_option) VALUES ";
    $values = [];
    
    foreach ($_SESSION['cart'] as $item) {
        $product_id = intval($item['id']);
        $product_name = $conn->real_escape_string($item['name']);
        $quantity = intval($item['quantity']);
        $price = $item['price'];
        $size = $conn->real_escape_string($item['size']);
        
        $values[] = "('$order_id', '$product_id', '$product_name', $quantity, $price, '$size')";
    }
    
    $sql_details .= implode(", ", $values);

    if ($conn->query($sql_details) === TRUE) {
        unset($_SESSION['cart']);
        $conn->close();
        header("Location: order_success.php?id=" . $order_id);
        exit();
        
    } else {
        die("Lỗi khi thêm chi tiết đơn hàng: " . $conn->error);
    }

} else {
    // Lỗi orders
    die("Lỗi khi tạo đơn hàng: " . $conn->error);
}
?>