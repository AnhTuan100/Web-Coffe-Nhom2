<?php 
    include 'config/db.php'; 
    include 'includes/header.php'; 

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
        
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header("Location: login_register.php?redirect=danh_gia.php");
            exit();
        }

        $name = $conn->real_escape_string($_POST['name']);
        $rating = intval($_POST['rating']);
        $comment = $conn->real_escape_string($_POST['comment']);

        if ($rating >= 1 && $rating <= 5 && !empty($name)) {
            $sql_insert = "INSERT INTO reviews (customer_name, rating, comment) VALUES ('$name', $rating, '$comment')";
            
            if ($conn->query($sql_insert) === TRUE) {
                header("Location: danh_gia.php?success=1");
                exit();
            } else {
                $error_message = "Lỗi khi gửi đánh giá: " . $conn->error;
            }
        } else {
            $error_message = "Vui lòng điền tên và chọn điểm đánh giá.";
        }
    }

    $sql_select = "SELECT customer_name, rating, comment, review_date FROM reviews ORDER BY review_date DESC";
    $result = $conn->query($sql_select);
    $reviews = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
?>

<div class="review-container">
    <h2>⭐️ Gửi Đánh Giá Của Bạn</h2>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-message">Cảm ơn bạn đã gửi đánh giá! Chúng tôi đã ghi nhận phản hồi của bạn.</p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="danh_gia.php" class="review-form">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p style="color: red; padding: 10px; border: 1px dashed red;">
                Bạn cần <a href="login_register.php?redirect=danh_gia.php">đăng nhập</a> để gửi đánh giá.
            </p>
        <?php endif; ?>
        
        <label for="name">Tên của bạn:</label>
        <input type="text" id="name" name="name" required <?php echo isset($_SESSION['user_id']) ? 'readonly value="Tên người dùng đã đăng nhập"' : ''; ?>>

        <label for="rating">Đánh giá sao:</label>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                <label for="star<?php echo $i; ?>">&#9733;</label>
            <?php endfor; ?>
        </div>
        
        <label for="comment">Bình luận:</label>
        <textarea id="comment" name="comment" rows="4"></textarea>

        <button type="submit" name="submit_review" class="btn-primary">Gửi Đánh Giá</button>
    </form>

    <hr>

    <h2>💬 Các Đánh Giá Gần Đây (<?php echo count($reviews); ?>)</h2>

    <div class="reviews-list">
        <?php if (empty($reviews)): ?>
            <p>Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <p class="review-meta">
                        <strong><?php echo htmlspecialchars($review['customer_name']); ?></strong> 
                        đã đánh giá: <span class="review-stars"><?php echo str_repeat('★', $review['rating']); ?></span>
                    </p>
                    <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                    <small class="review-date"><?php echo date('H:i, d/m/Y', strtotime($review['review_date'])); ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php 
    $conn->close();
    include 'includes/footer.php'; 
?>