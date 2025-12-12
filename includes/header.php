<?php session_start();
$current_page = basename($_SERVER['PHP_SELF']);
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <h1>Coffee</h1>
        <nav class="nav">
            <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Trang chủ</a>
            <a href="menu.php" class="<?php echo $current_page == 'menu.php' ? 'active' : ''; ?>">Thực đơn</a>
            <a href="danh_gia.php">Đánh giá</a>
        </nav>
        <div class="cart">
            <a href="checkout.php">
                <img class="cart-icon" src="assets/images/cart_icon.png" alt="Giỏ hàng">
                <span class="cart-badge"><?php echo $cart_count; ?></span>
            </a>
        </div>
    </header>
    <main>