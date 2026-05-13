<?php
require __DIR__ . '/Connection.php';
include 'includes/navbar.php';

$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $eventType = trim($_POST['event_type'] ?? '');
    $dateNeeded = trim($_POST['date_needed'] ?? '');
    $details = trim($_POST['details'] ?? '');

    if (
        $name === '' ||
        $email === '' ||
        $details === ''
    ) {
        $error = "Please fill out all required fields.";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO custom_orders
            (
                Name,
                Email,
                Phone,
                EventType,
                DateNeeded,
                Details
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssss",
            $name,
            $email,
            $phone,
            $eventType,
            $dateNeeded,
            $details
        );

        $stmt->execute();

        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Custom Orders | Sweet Delights Bakery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="custom-hero">
    <div>
        <p class="eyebrow">Custom Cakes & Desserts</p>

        <h1>Tell us your sweet vision.</h1>

        <p>
            From elegant birthday cakes to weddings and dessert tables,
            we create custom sweets designed just for your celebration.
        </p>
    </div>
</section>

<section class="custom-layout">

    <div class="custom-info-card">
        <h2>What We Can Create</h2>

        <ul>
            <li>Birthday Cakes</li>
            <li>Wedding Cakes</li>
            <li>Baby Shower Desserts</li>
            <li>Luxury Cupcake Boxes</li>
            <li>Dessert Tables</li>
            <li>Holiday & Seasonal Treats</li>
        </ul>

        <div class="custom-note">
            <h3>Ordering Tips</h3>

            <p>
                Please provide inspiration photos, colors, themes,
                servings needed, and your event date for the best experience.
            </p>
        </div>
    </div>

    <div class="custom-form-card">

        <?php if ($success): ?>
            <div class="success-box">
                Your custom order request has been sent successfully.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-box">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <h2>Request a Custom Order</h2>

        <form method="POST">

            <label>Your Name *</label>
            <input type="text" name="name" required>

            <label>Email Address *</label>
            <input type="email" name="email" required>

            <label>Phone Number</label>
            <input type="text" name="phone">

            <label>Event Type</label>
            <select name="event_type">
                <option value="">Select Event</option>
                <option>Birthday</option>
                <option>Wedding</option>
                <option>Baby Shower</option>
                <option>Graduation</option>
                <option>Holiday</option>
                <option>Other</option>
            </select>

            <label>Date Needed</label>
            <input type="date" name="date_needed">

            <label>Describe Your Order *</label>
            <textarea
                name="details"
                required
                placeholder="Tell us flavors, colors, theme, servings, inspiration ideas, etc."
            ></textarea>

            <button type="submit" class="btn btn-primary">
                Submit Request
            </button>

        </form>
    </div>

</section>

<section class="cta">
    <h2>Need inspiration first?</h2>
    <p>Browse our gallery to see past creations and dessert designs.</p>
    <a href="gallery.php" class="btn btn-light">View Gallery</a>
</section>

<footer>
    <p>&copy; <?php echo date('Y'); ?> Sweet Delights Bakery. All rights reserved.</p>
</footer>

</body>
</html>