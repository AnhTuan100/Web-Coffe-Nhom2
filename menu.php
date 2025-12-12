<?php 
    include 'config/db.php'; 
    include 'includes/header.php'; 
    $filter_category = isset($_GET['cat']) && $_GET['cat'] != 'Tất Cả' ? $conn->real_escape_string($_GET['cat']) : '';
    
    $sql = "SELECT product_id, name, category, base_price, image_path FROM products";
    
    if ($filter_category) {
        $sql .= " WHERE category = '$filter_category'";
    }

    $result = $conn->query($sql);
    $products = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    $categories = ['Tất Cả', 'Cà Phê', 'Trà Sữa', 'Trà Trái Cây', 'Bánh'];
    $current_category = $filter_category ? $filter_category : 'Tất Cả';
?>
<div class="menu-container">
    <aside class="sidebar">
        <h3>Danh Mục</h3>
        <ul>
            <?php foreach ($categories as $cat): ?>
                <li><a href="?cat=<?php echo urlencode($cat); ?>" class="<?php echo $current_category == $cat ? 'active' : ''; ?>"><?php echo $cat; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <section class="product-grid">
        <?php foreach ($products as $product): ?>
            <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" class="product-card">
                <img src="assets/images/<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo number_format($product['base_price'], 0, ',', '.'); ?> đ</p>
            </a>
        <?php endforeach; ?>
    </section>
</div>

<?php 
    $conn->close();
    include 'includes/footer.php'; 
?>