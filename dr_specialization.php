<?php
ob_start(); // Start output buffering
include("admin_header.php");
include("database.php");

// Handle Adding Specialization
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_specialization'])) {
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

    if (!empty($specialization)) {
        $query = "INSERT INTO specilization (specilization) VALUES ('$specialization')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Specialization added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding specialization!');</script>";
        }
    }
}

// Handle Specialization Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_specialization'])) {
    $s_id = intval($_POST['s_id']);
    $updated_specialization = mysqli_real_escape_string($conn, $_POST['updated_specialization']);

    if (!empty($updated_specialization)) {
        $update_query = "UPDATE specilization SET specilization='$updated_specialization' WHERE s_id=$s_id";
        mysqli_query($conn, $update_query);
        header("Location: dr_specialization.php");
        exit();
    }
}

// Handle Specialization Deletion
if (isset($_GET['delete_id'])) {
    $s_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM specilization WHERE s_id = $s_id";
    mysqli_query($conn, $delete_query);

    header("Location: dr_specialization.php");
    exit();
}

// Fetch Specializations
$query = "SELECT * FROM specilization ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

ob_end_flush(); // End output buffering
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Specialization</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 15px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
            font-size: 15px;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        .btn {
            padding: 4px 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-add {
            background-color: rgb(46, 128, 204);
            color: white;
            margin-bottom: 10px;
            width: 30%;
            padding: 7px;
            font-size: 15px;
            display: inline-block;
            text-align: center;
        }
        .btn-container {
            text-align: center;
            margin-top: 10px;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
            border-radius: 4px;
        }
        .btn-edit {
            background-color: #f39c12;
            color: white;
            border-radius: 4px;
        }
        .btn:hover {
            opacity: 0.8;
        }
        form {
            margin-top: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }
        .edit-form {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <script>
        function showEditForm(id, specialization) {
            document.getElementById("edit-form").style.display = "block";
            document.getElementById("s_id").value = id;
            document.getElementById("updated_specialization").value = specialization;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Doctor Specialization</h2>

    <!-- Add Specialization Form -->
    <form method="POST">
        <input type="text" name="specialization" placeholder="Enter Specialization" required>
        <div class="btn-container">
            <button type="submit" name="add_specialization" class="btn btn-add">Add Specialization</button>
        </div>
    </form>

    <!-- Display Specializations -->
    <table>
        <tr>
            <th>Specialization</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['specilization']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="javascript:void(0);" class="btn btn-edit" onclick="showEditForm('<?php echo $row['s_id']; ?>', '<?php echo htmlspecialchars($row['specilization']); ?>')">Edit</a>
                <a href="dr_specialization.php?delete_id=<?php echo $row['s_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Edit Specialization Form -->
    <div id="edit-form" class="edit-form">
        <h3>Edit Specialization</h3>
        <form method="POST">
            <input type="hidden" name="s_id" id="s_id">
            <input type="text" name="updated_specialization" id="updated_specialization" required>
            <button type="submit" name="update_specialization" class="btn btn-edit">Update</button>
        </form>
    </div>
</div>

</body>
</html>
