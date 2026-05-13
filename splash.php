<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guest'])) {
        $_SESSION['guest'] = true;
        header("Location: index.php");
        exit;
    }

    if (!empty($_POST['email'])) {
        $_SESSION['customer_email'] = trim($_POST['email']);
        header("Location: menu.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome | Sweet Delights</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="splash-body">

<main class="splash-wrapper">

    <section class="splash-welcome">
        <p class="eyebrow">Welcome to</p>
        <h1>Sweet Delights Bakery</h1>
        <p>
            Handmade pastries, custom cakes, and elegant desserts made fresh
            for birthdays, weddings, parties, and sweet everyday moments.
        </p>
    </section>

    <section class="splash-card">
        <h2>Start Your Order</h2>
        <p>Continue with your email or browse as a guest.</p>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email">
            <button type="submit" class="btn btn-primary">Continue with Email</button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <form method="POST">
            <button type="submit" name="guest" value="1" class="btn btn-secondary">
                Continue as Guest
            </button>
        </form>

        <a href="admin/index.php" class="admin-link">Admin Login</a>
    </section>

</main>

</body>
</html>