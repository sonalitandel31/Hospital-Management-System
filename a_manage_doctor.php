<?php
include("database.php");
include("admin_header.php");

$sql = "SELECT d_id, name, specilization FROM doctor_mast";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .table-container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #0288d1;
            color: white;
        }
        .action-btn {
            padding: 8px 12px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .edit-btn {
            background: #fbc02d;
        }
        .delete-btn {
            background: #d32f2f;
        }
        .edit-btn:hover {
            background: #f57f17;
        }
        .delete-btn:hover {
            background: #b71c1c;
        }
    </style>
</head>
<body>

    <div class="table-container">
        <h2>Manage Doctors</h2>
        <table>
            <tr>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['specilization'] ?></td>
                    <td>
                        <a href="a_edit_doctor.php?d_id=<?= $row['d_id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="a_delete_doctor.php?d_id=<?= $row['d_id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
