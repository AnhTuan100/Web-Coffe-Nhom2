<?php 
    include 'config/db.php'; 
    include 'includes/header.php'; 

    $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $sql = "SELECT product_id, name, base_price, description, image_path FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "<div style='text-align: center; margin: 50px;'><h2>Rất tiếc, không tìm thấy sản phẩm này.</h2><p><a href='menu.php'>Quay lại menu</a></p></div>";
        $conn->close();
        include 'includes/footer.php';
        exit();
    }
    
    $product = $result->fetch_assoc();
    $base_price = $product['base_price'];
?>

<div class="product-detail-container">
    <div class="product-image-large">
        <img src="assets/images/<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    <div class="product-info">
        <h2><?php echo $product['name']; ?></h2>
        <p class="price">
            <span class="current-price" data-base-price="<?php echo $base_price; ?>">
                <?php echo number_format($base_price, 0, ',', '.'); ?> đ
            </span>
        </p>

        <form action="cart_add.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $product['image_path']; ?>">
            
            <p>Chọn size :</p>
            <div class="product-size-options">
                <input type="radio" id="size_vua" name="size" value="Vừa" checked data-price-increase="0">
                <label for="size_vua">Vừa + 0 đ</label>

                <input type="radio" id="size_lon" name="size" value="Lớn" data-price-increase="5000">
                <label for="size_lon">Lớn + 5.000 đ</label>
            </div>
            
            <div class="quantity-input-row">
                <span class="quantity-label">Chọn số lượng :</span>
                
                <input type="number" 
                       name="quantity" 
                       value="1" 
                       min="1" 
                       max="99" 
                       required
                       class="quantity-input"> 
            </div>
            
            <button type="submit" class="btn-primary" style="margin-top: 20px; width: 350px;">
                Thêm vào giỏ hàng
            </button>
        </form>

        <div class="product-description">
            <h3>Mô tả sản phẩm</h3>
            <p><?php echo $product['description']; ?></p>
        </div>
    </div>
</div>

<?php 
    $conn->close();
    include 'includes/footer.php'; 
?>

<script>
    document.querySelectorAll('input[name="size"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const priceEl = document.querySelector('.current-price');
            const basePrice = parseInt(priceEl.getAttribute('data-base-price'));
            const increase = parseInt(this.getAttribute('data-price-increase'));
            let newPrice = basePrice + increase;
            priceEl.textContent = newPrice.toLocaleString('vi-VN') + ' đ';
        });
    });
</script>