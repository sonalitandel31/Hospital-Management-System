<?php
include("database.php");
include("admin_header.php");

if (isset($_GET['d_id'])) {
    $d_id = $_GET['d_id'];

    $query = "SELECT * FROM doctor_mast WHERE d_id = $d_id";
    $result = mysqli_query($conn, $query);
    $doctor = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specilization = $_POST['specilization'];
    $docfees = $_POST['docfees'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_query = $password ? ", password='" . password_hash($password, PASSWORD_DEFAULT) . "'" : "";

    $update_sql = "UPDATE doctor_mast SET 
                    name='$name', 
                    specilization='$specilization', 
                    docfees='$docfees', 
                    contact='$contact', 
                    email='$email' 
                    $password_query
                    WHERE d_id=$d_id";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Doctor updated successfully!'); window.location.href='a_manage_doctor.php';</script>";
    } else {
        echo "<script>alert('Error updating doctor: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            text-align: center;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
            margin-top: 30px;
            width: 50%;
            margin-left: 2%;
        }
        .form-title {
            color: #0277bd;
        }
        .form-label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #90caf9;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-button {
            width: 25%;
            padding: 12px;
            background: #0288d1;
            color: white;
            border: none;
            border-radius: 4px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-button:hover {
            background: #01579b;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2 class="form-title">Edit Doctor</h2>
        <form method="POST">
            <label class="form-label">Doctor Name:</label>
            <input type="text" name="name" class="form-input" value="<?= $doctor['name'] ?>" required>

            <label class="form-label">Specialization:</label>
            <select name="specilization" class="form-select" required>
                <option value="">Select Specialization</option>
                <?php
                $result = mysqli_query($conn, "SELECT DISTINCT specilization FROM specilization");
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['specilization'] == $doctor['specilization']) ? "selected" : "";
                    echo "<option value='" . $row['specilization'] . "' $selected>" . $row['specilization'] . "</option>";
                }
                ?>
            </select>

            <label class="form-label">Doctor Fees:</label>
            <input type="number" name="docfees" class="form-input" value="<?= $doctor['docfees'] ?>" required>

            <label class="form-label">Contact:</label>
            <input type="text" name="contact" class="form-input" value="<?= $doctor['contact'] ?>" required>

            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-input" value="<?= $doctor['email'] ?>" required>

            <label class="form-label">Password (Leave blank to keep the same):</label>
            <input type="password" name="password" class="form-input">

            <button type="submit" class="form-button">Update Doctor</button>
        </form>
    </div>

</body>
</html>
