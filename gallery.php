<?php
require __DIR__ . '/Connection.php';
include 'includes/navbar.php';

$gallery = $conn->query("
    SELECT Name, Description, Image, Category
    FROM pastries
    WHERE Image IS NOT NULL 
    AND Image != ''
    AND IsAvailable = 1
    ORDER BY CreatedAt DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery | Sweet Delights Bakery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="gallery-hero">
    <p class="eyebrow">Our Creations</p>
    <h1>Sweet moments, beautifully made.</h1>
    <p>Browse our cakes, pastries, cupcakes, and custom dessert designs.</p>
</section>

<section class="gallery-grid">
    <?php if ($gallery && $gallery->num_rows > 0): ?>
        <?php while ($item = $gallery->fetch_assoc()): ?>
            <div class="gallery-card">
                <img src="images/<?php echo htmlspecialchars($item['Image']); ?>" alt="<?php echo htmlspecialchars($item['Name']); ?>">

                <div class="gallery-overlay">
                    <span><?php echo htmlspecialchars($item['Category']); ?></span>
                    <h3><?php echo htmlspecialchars($item['Name']); ?></h3>
                    <p><?php echo htmlspecialchars($item['Description']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="empty-gallery">
            <h2>No gallery photos yet</h2>
            <p>Add pastries with photos from the admin panel and they will show here automatically.</p>
            <a href="menu.php" class="btn btn-primary">View Menu</a>
        </div>
    <?php endif; ?>
</section>

<section class="cta">
    <h2>Want something custom?</h2>
    <p>Send us your cake or dessert idea and we’ll make it beautiful.</p>
    <a href="custom-orders.php" class="btn btn-light">Start an Order</a>
</section>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Sweet Delights Bakery. All rights reserved.</p>
</footer>

</body>
</html>