<?php
session_start();
require __DIR__ . '/../Connection.php';

if (!empty($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT AdminID, Password FROM admins WHERE Email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($adminId, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['admin_id'] = $adminId;
        $_SESSION['admin_email'] = $email;

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="splash-body">

<div class="splash-card">
    <h2>Admin Login</h2>
    <p>Enter your admin credentials to manage pastries.</p>

    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Admin email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn btn-primary">Enter Admin</button>
    </form>

    <a href="../splash.php" class="admin-link">Back to Website</a>
</div>

</body>
</html>