<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../includes/admin_auth.php';
require __DIR__ . '/../Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM custom_orders WHERE OrderID = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();

    header("Location: custom_orders.php?deleted=1");
    exit;
}

$orders = $conn->query("SELECT * FROM custom_orders ORDER BY CreatedAt DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Custom Order Requests</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="admin-page">

    <div class="admin-topbar">
        <div>
            <p class="eyebrow">Admin Panel</p>
            <h1>Custom Orders</h1>
            <p>View and delete custom cake and dessert requests from customers.</p>
        </div>

        <div>
            <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="success-box">Custom order deleted successfully.</div>
    <?php endif; ?>

    <div class="message-grid">

        <?php if ($orders && $orders->num_rows > 0): ?>

            <?php while ($row = $orders->fetch_assoc()): ?>

                <div class="message-card">

                    <div class="message-header">
                        <div>
                            <h2><?php echo htmlspecialchars($row['Name']); ?></h2>
                            <p><?php echo htmlspecialchars($row['Email']); ?></p>
                        </div>

                        <span>
                            <?php echo htmlspecialchars($row['CreatedAt']); ?>
                        </span>
                    </div>

                    <?php if (!empty($row['Phone'])): ?>
                        <p>
                            <strong>Phone:</strong>
                            <?php echo htmlspecialchars($row['Phone']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($row['EventType'])): ?>
                        <p>
                            <strong>Event Type:</strong>
                            <?php echo htmlspecialchars($row['EventType']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($row['DateNeeded'])): ?>
                        <p>
                            <strong>Date Needed:</strong>
                            <?php echo htmlspecialchars($row['DateNeeded']); ?>
                        </p>
                    <?php endif; ?>

                    <div class="message-body">
                        <?php echo nl2br(htmlspecialchars($row['Details'])); ?>
                    </div>

                    <form method="POST" onsubmit="return confirm('Delete this custom order?');">
                        <input type="hidden" name="delete_id" value="<?php echo (int)$row['OrderID']; ?>">

                        <button type="submit" class="btn delete-btn">
                            Delete Custom Order
                        </button>
                    </form>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="empty-gallery">
                <h2>No custom orders yet</h2>
                <p>Custom order requests from customers will appear here.</p>
            </div>

        <?php endif; ?>

    </div>

</section>

</body>
</html>