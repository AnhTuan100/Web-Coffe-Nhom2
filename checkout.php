<?php 
    include 'includes/header.php'; 

    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $total = 0;
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    if (empty($cart_items)) {
        echo "<div style='text-align: center; margin: 50px;'><h2>Giỏ hàng của bạn đang trống.</h2><p><a href='menu.php'>Quay lại menu</a></p></div>";
        include 'includes/footer.php';
        exit();
    }
?>

<div class="checkout-container">
    <section class="shipping-info">
        <h3>Địa chỉ nhận hàng</h3>
        <form id="order_form" action="place_order.php" method="POST">
            <input type="text" name="address" placeholder="Địa chỉ nhận hàng" required>
            <input type="text" name="recipient" placeholder="Tên người nhận" required>
            <input type="text" name="phone" placeholder="Số điện thoại" required>

            <h3 style="margin-top: 30px;">Phương thức thanh toán</h3>
            <div class="payment-info">
                <input type="radio" id="cash" name="payment_method" value="Tiền mặt" checked>
                <label for="cash">Tiền mặt</label><br>

                <input type="radio" id="bank" name="payment_method" value="Thẻ ngân hàng">
                <label for="bank">Thẻ ngân hàng</label>
            </div>
        </form>
    </section>

    <aside class="order-summary">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>Các món đã chọn</h3>
            <a href="menu.php" class="btn-primary" style="text-decoration: none; padding: 5px 10px; background-color: #f9f9f9; color: var(--text-color);">Thêm món</a>
        </div>
        
        <?php foreach ($cart_items as $item): ?>
            <div class="order-item">
                <span><?php echo $item['quantity']; ?>x <?php echo $item['name']; ?> (<?php echo $item['size']; ?>)</span>
                <span><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> đ</span>
            </div>
        <?php endforeach; ?>

        <div class="total-price">
            <p>Tổng cộng</p>
            <p style="font-size: 1.5em; color: var(--primary-color);">
                <?php echo number_format($total, 0, ',', '.'); ?> đ
            </p>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%;" form="order_form">Đặt hàng</button>
        <p style="text-align: right; margin-top: 15px;"><a href="clear_cart.php" style="color: red; text-decoration: none;">Xóa đơn hàng</a></p>
    </aside>
</div>

<?php include 'includes/footer.php'; ?>