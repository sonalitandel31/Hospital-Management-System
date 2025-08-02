<?php
ob_start();
include("doctor_header.php");
include('database.php');

if (!isset($_SESSION['doctor_id'])) {
    header('Location: doctor_login.php');
    exit;
}

$doctor_id = intval($_SESSION['doctor_id']);

if (isset($_GET['p_detail_id'])) {
    $p_detail_id = intval($_GET['p_detail_id']);

    $query = "SELECT * FROM patient_detail WHERE p_detail_id = '$p_detail_id' AND d_id = '$doctor_id'";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_medical'])) {
        $bp = mysqli_real_escape_string($conn, $_POST['bp']);
        $bs = mysqli_real_escape_string($conn, $_POST['bs']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);
        $temperature = mysqli_real_escape_string($conn, $_POST['temperature']);
        $m_prescription = mysqli_real_escape_string($conn, $_POST['m_prescription']);

        $med_update_query = "INSERT INTO medical_history (p_detail_id, bp, bs, weight, temperature, m_prescription, created_at) 
                             VALUES ('$p_detail_id', '$bp', '$bs', '$weight', '$temperature', '$m_prescription', NOW())";

        mysqli_query($conn, $med_update_query);
        header("Location: view_patient.php?p_detail_id=$p_detail_id");
        exit;
    }
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
        .form-container {
            display: none;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
        .form-container label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            color: #333;
        }
        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-container textarea {
            resize: vertical;
            height: 80px;
        }
        button[type="submit"] {
            background-color: rgb(67, 146, 211);
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button[type="submit"]:hover {
            background-color: rgb(73, 130, 190);
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            th, td {
                padding: 8px;
            }
            .toggle-btn, button[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Patient Details</h3>
    <table>
        <tr><th style="width: 25%;">Patient ID</th><td><?php echo $row['p_detail_id']; ?></td></tr>
        <tr><th>Full Name</th><td><?php echo $row['p_name']; ?></td></tr>
        <tr><th>Contact No</th><td><?php echo $row['contact_no']; ?></td></tr>
        <tr><th>Address</th><td><?php echo $row['p_add']; ?></td></tr>
        <tr><th>Gender</th><td><?php echo $row['p_gender']; ?></td></tr>
        <tr><th>Email</th><td><?php echo $row['p_email']; ?></td></tr>
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
    <?php } else { echo "<p>No medical history available.</p>"; } ?>

    <button class="toggle-btn" onclick="toggleForm('medicalForm')">+ Add Medical History</button>

    <div id="medicalForm" class="form-container">
        <form method="POST" action="">
            <label>Blood Pressure:</label><input type="text" name="bp" required>
            <label>Blood Sugar:</label><input type="text" name="bs" required>
            <label>Weight:</label><input type="text" name="weight" required>
            <label>Temperature:</label><input type="text" name="temperature" required>
            <label>Prescription:</label><textarea name="m_prescription" required></textarea>
            <button type="submit" name="update_medical">Save</button>
        </form>
    </div>
</div>

<script>
function toggleForm(id) {
    var form = document.getElementById(id);
    form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
}
</script>

</body>
</html>
