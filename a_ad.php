<?php
ob_start(); 
include("admin_header.php");
include("database.php");

$ads = mysqli_query($conn, "SELECT * FROM pages WHERE type='ad'");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id']) && isset($_FILES['new_img'])) {
    $id = intval($_POST['update_id']);
    
    if (!empty($_FILES['new_img']['name'])) {
        $new_img = basename($_FILES['new_img']['name']);
        move_uploaded_file($_FILES['new_img']['tmp_name'], "img/" . $new_img);

        $updateQuery = "UPDATE pages SET img='$new_img' WHERE id=$id AND type='ad'";
        mysqli_query($conn, $updateQuery);
        
        header("Location: a_ad.php");
        exit;
    }
}

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    $imgQuery = "SELECT img FROM pages WHERE id = $id AND type='ad'";
    $imgResult = mysqli_query($conn, $imgQuery);
    $imgRow = mysqli_fetch_assoc($imgResult);

    $deleteQuery = "DELETE FROM pages WHERE id = $id AND type='ad'";
    mysqli_query($conn, $deleteQuery);

    header("Location: a_ad.php");
    exit;
}

ob_end_flush(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Advertisements</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 90%; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        .ads { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; }
        .ad-item { position: relative; width: 200px; text-align: center; }
        .ad-item img { width: 100%; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
        .update-form { margin-top: 10px; }
        .update-form input { width: 100%; padding: 8px; margin-top: 5px; }
        .update-form button { background-color: #0277bd; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; margin-bottom: 5px; }
        .update-form button:hover { background-color: #02569b; }
        
        .delete-icon {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #d32f2f;
            color: white;
            border: none;
            font-size: 15px;
            font-weight: bold;
            width: 22px;
            height:22px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .delete-icon:hover { background-color: #b71c1c; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Advertisements</h2><br>

        <div class="ads">
            <?php while ($row = mysqli_fetch_assoc($ads)) { ?>
                <div class="ad-item">
                    <a href="a_ad.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this ad?');">
                        <button class="delete-icon">✖</button>
                    </a>

                    <img src="img/<?php echo htmlspecialchars($row['img']); ?>" alt="Advertisement">
                    
                    <form method="POST" enctype="multipart/form-data" class="update-form">
                        <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
                        <input type="file" name="new_img" required>
                        <button type="submit">Update Image</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
