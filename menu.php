<?php
session_start();
require 'Connection.php';
include 'includes/navbar.php';

$result = mysqli_query($conn, "SELECT * FROM pastries WHERE IsAvailable = 1 ORDER BY CreatedAt DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu | Sweet Delights</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="page-header">
    <p class="eyebrow">Fresh Daily</p>
    <h1>Our Pastry Menu</h1>
    <p>Choose your favorites and start your order.</p>
</section>

<section class="pastry-grid">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="pastry-card">
            <?php if (!empty($row['Image'])): ?>
                <img src="images/<?php echo htmlspecialchars($row['Image']); ?>" alt="">
            <?php endif; ?>

            <h3><?php echo htmlspecialchars($row['Name']); ?></h3>
            <p><?php echo htmlspecialchars($row['Description']); ?></p>
            <strong>$<?php echo number_format($row['Price'], 2); ?></strong>

            <a href="custom-orders.php?pastry=<?php echo $row['PastryID']; ?>" class="btn btn-primary">
                Order This
            </a>
        </div>
    <?php endwhile; ?>
</section>

</body>
</html>