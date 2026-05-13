<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../includes/admin_auth.php';
require __DIR__ . '/../Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE MessageID = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();

    header("Location: messages.php?deleted=1");
    exit;
}

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY CreatedAt DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Messages</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="admin-page">

    <div class="admin-topbar">
        <div>
            <p class="eyebrow">Admin Panel</p>
            <h1>Customer Messages</h1>
            <p>View and manage customer contact messages.</p>
        </div>

        <div>
            <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="success-box">Message deleted successfully.</div>
    <?php endif; ?>

    <div class="message-grid">

        <?php if ($messages && $messages->num_rows > 0): ?>

            <?php while ($row = $messages->fetch_assoc()): ?>

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

                    <div class="message-body">
                        <?php echo nl2br(htmlspecialchars($row['Message'])); ?>
                    </div>

                    <form method="POST" onsubmit="return confirm('Delete this message?');">
                        <input type="hidden" name="delete_id" value="<?php echo (int)$row['MessageID']; ?>">

                        <button type="submit" class="btn delete-btn">
                            Delete Message
                        </button>
                    </form>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="empty-gallery">
                <h2>No messages yet</h2>
                <p>Customer messages from the contact page will appear here.</p>
            </div>

        <?php endif; ?>

    </div>

</section>

</body>
</html>