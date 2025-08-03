<?php
include("doctor_header.php");
include('database.php');

if (!isset($_SESSION['doctor_id'])) {
    header('Location: doctor_login.php');
    exit;
}

$doctor_id = intval($_SESSION['doctor_id']); 

if (isset($_POST['delete']) && isset($_POST['p_detail_id'])) {
    $p_detail_id = intval($_POST['p_detail_id']);
    $query = "DELETE FROM patient_detail WHERE p_detail_id = '$p_detail_id' AND d_id = '$doctor_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Patient deleted successfully.'); window.location.href='manage_patient.php';</script>";
    } else {
        echo "<script>alert('Error deleting patient: " . mysqli_error($conn) . "'); window.location.href='manage_patient.php';</script>";
    }
}

$query = "SELECT DISTINCT p_detail_id, p_name, p_add, p_email, p_gender, created_at 
          FROM patient_detail 
          WHERE d_id = '$doctor_id'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        section.dashboard {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: rgb(121, 187, 230);
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 8px;
            text-align: left;
        }
        td input[type="submit"] {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        td input[type="submit"]:hover {
            background-color: #c0392b;
        }
        .view-btn, .edit-btn {
            background-color: #3498db;
            color: white;
            padding: 1px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-left: 8px;
            display: inline-block;
        }
        .edit-btn {
            background-color: #f39c12;
        }
        @media screen and (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }
            td input[type="submit"] {
                padding: 4px 8px;
            }
        }
    </style>
</head>
<body>
<section class="dashboard">
<h3>Doctor | Manage Patients</h3><br>
<table border="1">
<thead>
    <tr>
        <th>Patient ID</th>
        <th>Full Name</th>
        <th>Address</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['p_detail_id']}</td>            
                    <td>{$row['p_name']}</td>
                    <td>{$row['p_add']}</td>
                    <td>{$row['p_gender']}</td>
                    <td>{$row['p_email']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <form method='POST' action='' onsubmit='return confirmDelete()' style='display:inline;'>
                            <input type='hidden' name='p_detail_id' value='{$row['p_detail_id']}'>
                            <input type='submit' name='delete' value='Delete'>
                        </form>
                        <a href='view_patient.php?p_detail_id={$row['p_detail_id']}' class='view-btn'>View</a>
                        <a href='edit_patient.php?p_detail_id={$row['p_detail_id']}' class='edit-btn'>Edit</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No patients found.</td></tr>";
    }
    ?>
</tbody>
</table>
</section>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this patient?');
    }
</script>
</body>
</html>
