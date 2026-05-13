<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../includes/admin_auth.php';
require __DIR__ . '/../Connection.php';

$message = "";
$editMode = false;
$uploadDir = __DIR__ . '/../images/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$editPastry = [
    'PastryID' => '',
    'Name' => '',
    'Description' => '',
    'Price' => '',
    'Category' => '',
    'Image' => '',
    'IsAvailable' => 1
];

function uploadPastryImage($file, $uploadDir) {
    if (empty($file['name'])) {
        return "";
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        return "";
    }

    $newName = 'pastry_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
    $destination = $uploadDir . $newName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return "";
    }

    return $newName;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_id'])) {
        $deleteId = (int) $_POST['delete_id'];

        $stmt = $conn->prepare("SELECT Image FROM pastries WHERE PastryID = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $stmt->bind_result($oldImage);
        $stmt->fetch();
        $stmt->close();

        if (!empty($oldImage) && file_exists($uploadDir . $oldImage)) {
            unlink($uploadDir . $oldImage);
        }

        $stmt = $conn->prepare("DELETE FROM pastries WHERE PastryID = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();

        header("Location: pastries.php?deleted=1");
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float) ($_POST['price'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $currentImage = trim($_POST['current_image'] ?? '');
    $isAvailable = isset($_POST['is_available']) ? 1 : 0;
    $pastryId = (int) ($_POST['pastry_id'] ?? 0);

    $uploadedImage = uploadPastryImage($_FILES['image_upload'] ?? [], $uploadDir);
    $image = $uploadedImage !== "" ? $uploadedImage : $currentImage;

    if ($name === '' || $price <= 0) {
        $message = "Please enter a pastry name and valid price.";
    } else {
        if ($pastryId > 0) {
            if ($uploadedImage !== "" && !empty($currentImage) && file_exists($uploadDir . $currentImage)) {
                unlink($uploadDir . $currentImage);
            }

            $stmt = $conn->prepare("
                UPDATE pastries
                SET Name = ?, Description = ?, Price = ?, Category = ?, Image = ?, IsAvailable = ?
                WHERE PastryID = ?
            ");
            $stmt->bind_param("ssdssii", $name, $description, $price, $category, $image, $isAvailable, $pastryId);
            $stmt->execute();

            header("Location: pastries.php?updated=1");
            exit;
        } else {
            $stmt = $conn->prepare("
                INSERT INTO pastries (Name, Description, Price, Category, Image, IsAvailable)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("ssdssi", $name, $description, $price, $category, $image, $isAvailable);
            $stmt->execute();

            header("Location: pastries.php?created=1");
            exit;
        }
    }
}

if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];

    $stmt = $conn->prepare("
        SELECT PastryID, Name, Description, Price, Category, Image, IsAvailable
        FROM pastries
        WHERE PastryID = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $editId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $editPastry = $result->fetch_assoc();
        $editMode = true;
    }
}

$pastries = $conn->query("SELECT * FROM pastries ORDER BY CreatedAt DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Pastries</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="admin-page">

    <div class="admin-topbar">
        <div>
            <p class="eyebrow">Admin Panel</p>
            <h1>Manage Pastries</h1>
            <p>Add, edit, upload photos, delete, and control what appears on the customer menu.</p>
        </div>

        <div>
            <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>

    <?php if (isset($_GET['created'])): ?>
        <div class="success-box">Pastry added successfully.</div>
    <?php elseif (isset($_GET['updated'])): ?>
        <div class="success-box">Pastry updated successfully.</div>
    <?php elseif (isset($_GET['deleted'])): ?>
        <div class="success-box">Pastry deleted successfully.</div>
    <?php elseif ($message): ?>
        <div class="error-box"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="crud-layout">

        <div class="admin-form-card">
            <h2><?php echo $editMode ? 'Edit Pastry' : 'Add New Pastry'; ?></h2>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="pastry_id" value="<?php echo htmlspecialchars($editPastry['PastryID']); ?>">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($editPastry['Image']); ?>">

                <label>Pastry Name</label>
                <input type="text" name="name" required value="<?php echo htmlspecialchars($editPastry['Name']); ?>">

                <label>Description</label>
                <textarea name="description"><?php echo htmlspecialchars($editPastry['Description']); ?></textarea>

                <label>Price</label>
                <input type="number" step="0.01" name="price" required value="<?php echo htmlspecialchars($editPastry['Price']); ?>">

                <label>Category</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($editPastry['Category']); ?>">

                <label>Upload Pastry Photo</label>
                <input type="file" name="image_upload" accept="image/*">

                <?php if (!empty($editPastry['Image'])): ?>
                    <div class="current-image-preview">
                        <p>Current Photo:</p>
                        <img src="../images/<?php echo htmlspecialchars($editPastry['Image']); ?>" alt="">
                    </div>
                <?php endif; ?>

                <label class="checkbox-label">
                    <input type="checkbox" name="is_available" <?php echo $editPastry['IsAvailable'] ? 'checked' : ''; ?>>
                    Available on Menu
                </label>

                <button type="submit" class="btn btn-primary">
                    <?php echo $editMode ? 'Update Pastry' : 'Create Pastry'; ?>
                </button>

                <?php if ($editMode): ?>
                    <a href="pastries.php" class="btn btn-secondary">Cancel Edit</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="admin-list-card">
            <h2>Current Pastries</h2>

            <div class="pastry-admin-grid">
                <?php if ($pastries && $pastries->num_rows > 0): ?>
                    <?php while ($row = $pastries->fetch_assoc()): ?>
                        <div class="pastry-admin-card">
                            <?php if (!empty($row['Image'])): ?>
                                <img src="../images/<?php echo htmlspecialchars($row['Image']); ?>" alt="">
                            <?php else: ?>
                                <div class="no-image">No Image</div>
                            <?php endif; ?>

                            <div class="pastry-admin-info">
                                <h3><?php echo htmlspecialchars($row['Name']); ?></h3>
                                <p><?php echo htmlspecialchars($row['Description']); ?></p>

                                <strong>$<?php echo number_format((float)$row['Price'], 2); ?></strong>

                                <span class="status-badge <?php echo $row['IsAvailable'] ? 'available' : 'hidden'; ?>">
                                    <?php echo $row['IsAvailable'] ? 'Available' : 'Hidden'; ?>
                                </span>

                                <div class="admin-card-actions">
                                    <a href="pastries.php?edit=<?php echo (int)$row['PastryID']; ?>" class="btn btn-secondary">Edit</a>

                                    <form method="POST" onsubmit="return confirm('Delete this pastry?');">
                                        <input type="hidden" name="delete_id" value="<?php echo (int)$row['PastryID']; ?>">
                                        <button type="submit" class="btn delete-btn">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No pastries have been added yet.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

</section>

</body>
</html>