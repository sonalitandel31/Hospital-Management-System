<?php
ob_start(); 
include("admin_header.php");
include('database.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location:admin_login.php');
    exit;
}

$admin_id = intval($_SESSION['admin_id']);

if (isset($_GET['p_detail_id'])) {
    $p_detail_id = intval($_GET['p_detail_id']);

    $query = "SELECT * FROM patient_detail WHERE p_detail_id = '$p_detail_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Patient not found or access denied.</p>";
        exit;
    }
} else {
    echo "<p>Invalid request.</p>";
    exit;
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    .container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        width: 100%;
        margin: 20px auto;
    }
    h3 {
        text-align: center;
        color: #333;
        font-size: 22px;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 6px;
        font-size: 14px;
        text-align: left;
    }
    th {
        background-color: rgb(99, 178, 231);
        color: white;
        font-weight: bold;
    }
    .toggle-btn {
        display: block;
        margin: 20px auto;
        padding: 10px 16px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }
    .toggle-btn:hover {
        background-color: #2980b9;
    }
    @media (max-width: 600px) {
        .container {
            padding: 15px;
        }
        th, td {
            padding: 8px;
        }
        .toggle-btn {
            width: 100%;
        }
    }
    </style>
</head>
<body>
<div class="container">
    <h3>Patient Details</h3>
    <table>
        <tr><th style="width: 20%;">Patient ID</th><td><?php echo $row['p_detail_id']; ?></td></tr>
        <tr><th>Full Name</th><td><?php echo $row['p_name']; ?></td></tr>
        <tr><th>Address</th><td><?php echo $row['p_add']; ?></td></tr>
        <tr><th>Gender</th><td><?php echo $row['p_gender']; ?></td></tr>
        <tr><th>Email</th><td><?php echo $row['p_email']; ?></td></tr>
        <tr><th>Contact Number</th><td><?php echo $row['contact_no']; ?></td></tr>
        <tr><th>Medical History</th><td><?php echo $row['p_medhis']; ?></td></tr>
        <tr><th>Created At</th><td><?php echo $row['created_at']; ?></td></tr>
    </table>
    
    <h3>Medical History</h3>
    <?php
    $medical_query = "SELECT * FROM medical_history WHERE p_detail_id = '$p_detail_id'";
    $medical_result = mysqli_query($conn, $medical_query);
    if (mysqli_num_rows($medical_result) > 0) { ?>
        <table>
            <tr>
                <th>Blood Pressure</th>
                <th>Blood Sugar</th>
                <th>Weight</th>
                <th>Temperature</th>
                <th>Prescription</th>
                <th>Date</th>
            </tr>
            <?php while ($med_row = mysqli_fetch_assoc($medical_result)) { ?>
                <tr>
                    <td><?php echo $med_row['bp']; ?></td>
                    <td><?php echo $med_row['bs']; ?></td>
                    <td><?php echo $med_row['weight']; ?></td>
                    <td><?php echo $med_row['temperature']; ?></td>
                    <td><?php echo $med_row['m_prescription']; ?></td>
                    <td><?php echo $med_row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No medical history available.</p>
    <?php } ?>
</div>
</body>
</html>
