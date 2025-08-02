<?php
include("doctor_header.php");
include('database.php');
if (!isset($_SESSION['doctor_id'])) {
    header('Location: doctor_login.php');
    exit;
}

$doctor_id = intval($_SESSION['doctor_id']);
if (!isset($_GET['p_detail_id']) || empty($_GET['p_detail_id'])) {
    echo "<script>alert('Invalid patient ID.'); window.location.href='doctor_dashboard.php';</script>";
    exit;
}

$p_detail_id = intval($_GET['p_detail_id']);
$query = "SELECT * FROM patient_detail WHERE p_detail_id = '$p_detail_id' AND d_id = '$doctor_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Patient not found.'); window.location.href='doctor_dashboard.php';</script>";
    exit;
}

$patient = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_add = mysqli_real_escape_string($conn, $_POST['p_add']);
    $p_email = mysqli_real_escape_string($conn, $_POST['p_email']);
    $p_gender = mysqli_real_escape_string($conn, $_POST['p_gender']);
    $p_age = intval($_POST['p_age']);
    $p_medhis = mysqli_real_escape_string($conn, $_POST['p_medhis']);

    $update_query = "UPDATE patient_detail SET 
                        p_name='$p_name', 
                        p_add='$p_add', 
                        p_email='$p_email', 
                        p_gender='$p_gender', 
                        p_age='$p_age', 
                        p_medhis='$p_medhis' 
                    WHERE p_detail_id='$p_detail_id' AND d_id='$doctor_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Patient details updated successfully.'); window.location.href='view_patient.php?p_detail_id=$p_detail_id';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating details: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        section.edit-form {
            width: 50%;
            margin: 20px auto;
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
        label {
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: rgb(46, 143, 204);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            width: 25%;
            display: block;
            margin: 10px auto; /* Centers the button horizontally */
            text-align: center;
        }
        input[type="submit"]:hover {
            background-color:rgb(39, 118, 174);
        }
        .back-btn {
            display: inline-block;
            background-color:rgb(69, 163, 226);
            color: white;
            padding: 3px 10px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .gender-options {
            display: flex;
            gap: 10px;
            margin: 5px 0;
            align-items: center;
        }

        .gender-options label {
            display: flex;
            align-items: center;
            font-weight: normal;
        }

        .gender-options input {
            margin-right: 3px;
        }
    </style>
</head>
<body>
<section class="edit-form">
    <h3>Edit Patient Details</h3>
    <form method="POST" action="">
        <label>Full Name:</label>
        <input type="text" name="p_name" value="<?php echo htmlspecialchars($patient['p_name']); ?>" required>
        
        <label>Address:</label>
        <input type="text" name="p_add" value="<?php echo htmlspecialchars($patient['p_add']); ?>" required>
        
        <label>Email:</label>
        <input type="email" name="p_email" value="<?php echo htmlspecialchars($patient['p_email']); ?>" required>
        
        <label>Gender:</label>
        <div class="gender-options">
            <label><input type="radio" name="p_gender" value="Male" <?php if ($patient['p_gender'] == 'Male') echo 'checked'; ?>> Male</label>
            <label><input type="radio" name="p_gender" value="Female" <?php if ($patient['p_gender'] == 'Female') echo 'checked'; ?>> Female</label>
            <label><input type="radio" name="p_gender" value="Other" <?php if ($patient['p_gender'] == 'Other') echo 'checked'; ?>> Other</label>
        </div>
        
        <label>Age:</label>
        <input type="number" name="p_age" value="<?php echo htmlspecialchars($patient['p_age']); ?>" required>
        
        <label>Medical History:</label>
        <textarea name="p_medhis" rows="4" required><?php echo htmlspecialchars($patient['p_medhis']); ?></textarea>
        
        <input type="submit" value="Update">
    </form>
    <a href="manage_patient.php" class="back-btn">Back to Patient List</a>
</section>
</body>
</html>