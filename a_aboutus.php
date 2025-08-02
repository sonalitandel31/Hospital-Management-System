<?php
ob_start(); // Start output buffering
include("admin_header.php");
include("database.php");

// Fetch existing About Us data (Assuming only one entry exists for type='about')
$query = "SELECT * FROM pages WHERE type='about' LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Image Upload Handling
    $img = $row['img']; // Keep old image if not changed
    if (!empty($_FILES['img']['name'])) {
        $img = basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], "img/" . $img);
    }

    // Update existing record
    $updateQuery = "UPDATE pages SET description='$description', img='$img' WHERE type='about'";
    mysqli_query($conn, $updateQuery);

    // Redirect and exit to prevent further output
    header("Location: a_aboutus.php");
    exit;
}
ob_end_flush(); // End output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Us</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 90%; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; margin-top: 5px; height: 100px; }
        .form-group button { background-color: #0277bd; color: white; padding: 10px; border: none; cursor: pointer; }
        .form-group button:hover { background-color: #02569b; }
        .image-preview { margin-top: 10px; display: flex; align-items: center; }
        .image-preview img { width: 200px; height: auto; margin-left: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h2>About Us Section</h2><br>

        <!-- Edit About Us Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Current Image:</label>
                <div class="image-preview">
                    <?php if (!empty($row['img'])) { ?>
                        <img src="img/<?php echo htmlspecialchars($row['img']); ?>" alt="Image">
                    <?php } else { echo "No Image"; } ?>
                </div>
            </div>
            <div class="form-group">
                <label>Change Image (Optional):</label>
                <input type="file" name="img" style="margin-bottom: -6%;">
            </div>
            <div class="form-group">
                <button type="submit">Update About Us</button>
            </div>
        </form>
    </div>
</body>
</html>
