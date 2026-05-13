<?php include 'includes/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>V Bakery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="hero">
    <div class="hero-content">
        <p class="eyebrow">Fresh • Feminine • Handmade</p>

        <h1>Beautiful Pastries Made With Love</h1>

        <p class="hero-text">
            Custom cakes, delicate pastries, cupcakes, and sweet treats made fresh
            for birthdays, weddings, events, and everyday cravings.
        </p>

        <div class="hero-buttons">
            <a href="custom-orders.php" class="btn btn-primary">Start an Order</a>
            <a href="menu.php" class="btn btn-secondary">View Menu</a>
        </div>
    </div>

    <div class="hero-card">
        <h2>Today’s Favorites</h2>
        <ul>
            <li>Strawberry Cream Cake</li>
            <li>Mini Cupcake Boxes</li>
            <li>Chocolate Croissants</li>
            <li>Custom Birthday Cakes</li>
        </ul>
        <a href="gallery.php">See our gallery →</a>
    </div>
</section>

<section class="quick-links">
    <a href="menu.php" class="link-card">
        <span>🍰</span>
        <h3>Our Menu</h3>
        <p>Browse pastries, cakes, cupcakes, and seasonal sweets.</p>
    </a>

    <a href="custom-orders.php" class="link-card">
        <span>🎂</span>
        <h3>Custom Orders</h3>
        <p>Request a cake or dessert table for your special event.</p>
    </a>

    <a href="gallery.php" class="link-card">
        <span>🌸</span>
        <h3>Gallery</h3>
        <p>See our past creations and get inspired.</p>
    </a>

    <a href="contact.php" class="link-card">
        <span>💌</span>
        <h3>Contact Us</h3>
        <p>Ask questions, get pricing, or check availability.</p>
    </a>
</section>

<section class="about-preview">
    <div>
        <p class="eyebrow">Made fresh daily</p>
        <h2>Elegant desserts for life’s sweetest moments.</h2>
        <p>
            From soft pastel cakes to delicate pastries, we create desserts that
            look beautiful and taste unforgettable.
        </p>
        <a href="about.php" class="btn btn-primary">About the Bakery</a>
    </div>
</section>

<section class="cta">
    <h2>Ready to place an order?</h2>
    <p>Tell us what you’re dreaming of and we’ll help make it sweet.</p>
    <a href="custom-orders.php" class="btn btn-light">Order Now</a>
</section>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Sweet Delights Bakery. All rights reserved.</p>
</footer>

</body>
</html>