<?php
require __DIR__ . '/Connection.php';
include 'includes/navbar.php';

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $error = "Please fill out your name, email, and message.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO contact_messages (Name, Email, Phone, Message)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("ssss", $name, $email, $phone, $message);
        $stmt->execute();

        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | Sweet Delights Bakery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="contact-hero">
    <p class="eyebrow">Get In Touch</p>
    <h1>We’d love to hear from you.</h1>
    <p>Questions, custom orders, event desserts, or availability — send us a message.</p>
</section>

<section class="contact-layout">

    <div class="contact-info-card">
        <h2>Sweet Delights Bakery</h2>
        <p>
            Reach out for cakes, pastries, dessert tables, pricing, and custom event orders.
        </p>

        <div class="contact-detail">
            <span>📍</span>
            <div>
                <h3>Location</h3>
                <p>Southern California</p>
            </div>
        </div>

        <div class="contact-detail">
            <span>💌</span>
            <div>
                <h3>Email</h3>
                <p>hello@sweetdelights.com</p>
            </div>
        </div>

        <div class="contact-detail">
            <span>📱</span>
            <div>
                <h3>Phone</h3>
                <p>(555) 123-4567</p>
            </div>
        </div>

        <a href="custom-orders.php" class="btn btn-primary">Start Custom Order</a>
    </div>

    <div class="contact-form-card">

        <?php if ($success): ?>
            <div class="success-box">
                Your message has been sent successfully.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-box">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <h2>Send a Message</h2>

        <form method="POST">
            <label>Your Name *</label>
            <input type="text" name="name" required>

            <label>Email Address *</label>
            <input type="email" name="email" required>

            <label>Phone Number</label>
            <input type="text" name="phone">

            <label>Message *</label>
            <textarea name="message" required placeholder="How can we help?"></textarea>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

</section>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Sweet Delights Bakery. All rights reserved.</p>
</footer>

</body>
</html>