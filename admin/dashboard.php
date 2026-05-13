<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../includes/admin_auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="admin-page">

    <div class="admin-topbar">
        <div>
            <p class="eyebrow">Admin Panel</p>
            <h1>Admin Dashboard</h1>

            <p>
                Logged in as:
                <strong><?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'Admin'); ?></strong>
            </p>
        </div>

        <div>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>

    <div class="admin-actions">

        <a href="pastries.php" class="link-card">
            <span>🧁</span>
            <h3>Manage Pastries</h3>
            <p>Add, edit, delete, and update bakery menu items.</p>
        </a>

        <a href="custom_orders.php" class="link-card">
            <span>🎂</span>
            <h3>Custom Orders</h3>
            <p>View and manage custom cake and dessert requests.</p>
        </a>

        <a href="messages.php" class="link-card">
            <span>💌</span>
            <h3>Customer Messages</h3>
            <p>Read and delete contact form submissions.</p>
        </a>

        <a href="../gallery.php" class="link-card">
            <span>📸</span>
            <h3>View Gallery</h3>
            <p>See how pastry photos appear to customers.</p>
        </a>

        <a href="../menu.php" class="link-card">
            <span>🍰</span>
            <h3>View Menu</h3>
            <p>Preview the customer pastry menu.</p>
        </a>
       

        <a href="logout.php" class="link-card">
            <span>🚪</span>
            <h3>Logout</h3>
            <p>Securely sign out of the admin panel.</p>
        </a>

    </div>

</section>

</body>
</html>