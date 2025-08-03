<?php
ob_start(); 
include("admin_header.php");
include("database.php");

$categories = mysqli_query($conn, "SELECT DISTINCT category FROM pages WHERE type='gallery'");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['img'])) {
    if (!empty($_FILES['img']['name']) && !empty($_POST['category'])) {
        $img = basename($_FILES['img']['name']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);

        move_uploaded_file($_FILES['img']['tmp_name'], "img/" . $img);

        $insertQuery = "INSERT INTO pages (img, category, type) VALUES ('$img', '$category', 'gallery')";
        mysqli_query($conn, $insertQuery);
        header("Location: a_gallery.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    $imgQuery = "SELECT img FROM pages WHERE id = $id AND type='gallery'";
    $imgResult = mysqli_query($conn, $imgQuery);
    $imgRow = mysqli_fetch_assoc($imgResult);
    
    if (!empty($imgRow['img']) && file_exists("img/" . $imgRow['img'])) {
        unlink("img/" . $imgRow['img']);
    }

    $deleteQuery = "DELETE FROM pages WHERE id = $id AND type='gallery'";
    mysqli_query($conn, $deleteQuery);
    header("Location: a_gallery.php");
    exit;
}

$selected_category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";
$query = "SELECT * FROM pages WHERE type='gallery'";
if (!empty($selected_category)) {
    $query .= " AND category = '$selected_category'";
}
$query .= " ORDER BY id DESC";
$result = mysqli_query($conn, $query);

ob_end_flush(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 90%; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; margin-top: 5px; }
        .form-group button { background-color: #0277bd; color: white; padding: 10px; border: none; cursor: pointer; }
        .form-group button:hover { background-color: #02569b; }
        .gallery { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; }
        .gallery-item { position: relative; width: 150px; }
        .gallery-item img { width: 100%; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
        .delete-btn { position: absolute; top: -5px; right: -5px; background: red; color: white; padding: 5px; border: none; cursor: pointer; font-size: 14px; border-radius: 50%;height: 23px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Gallery</h2><br>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Upload Image:</label>
                <input type="file" name="img" required>
            </div>
            <div class="form-group">
                <label>Select Category:</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?php echo htmlspecialchars($cat['category']); ?>">
                            <?php echo htmlspecialchars($cat['category']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Add Image</button>
            </div>
        </form>

        <form method="GET">
            <div class="form-group">
                <label>Filter by Category:</label>
                <select name="category" onchange="this.form.submit()">
                    <option value="">-- All Categories --</option>
                    <?php
                    mysqli_data_seek($categories, 0);
                    while ($cat = mysqli_fetch_assoc($categories)) {
                        $selected = ($cat['category'] == $selected_category) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($cat['category']) . "' $selected>" . htmlspecialchars($cat['category']) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </form>

        <div class="gallery">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="gallery-item">
                    <img src="img/<?php echo htmlspecialchars($row['img']); ?>" alt="Gallery Image">
                    <p style="text-align: center; margin: 5px 0; font-weight: bold;">
                        <?php echo htmlspecialchars($row['category']); ?>
                    </p>
                    <a href="a_gallery.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this image?')">
                        <button class="delete-btn">X</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
