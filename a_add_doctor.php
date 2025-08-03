<?php
include("database.php"); 
include("admin_header.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specilization = $_POST['specilization'];
    $docfees = $_POST['docfees'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {

        $sql = "INSERT INTO doctor_mast (name, specilization, docfees, contact, email, password) 
                VALUES ('$name', '$specilization', '$docfees', '$contact', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Doctor added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 700px;
            text-align: center;
            margin-top: 2%;
            margin-left: 2%;
        }
        .form-title {
            color: #0277bd;
            margin-bottom: 20px;
            margin-left: 2%;
        }
        .form-label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            text-align: left;
            margin-left: 2%;
        }
        .form-input, .form-select {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #90caf9;
            border-radius: 4px;
            font-size: 14px;
            margin-left: -1%;
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

        .form-message {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2 class="form-title">Add Doctor</h2>
    <form method="POST">
        <label class="form-label">Doctor Name:</label>
        <input type="text" name="name" class="form-input" required>

        <label class="form-label">Specialization:</label>
        <select name="specilization" class="form-select" required>
            <option value="">Select Specialization</option>
            <?php
            $result = mysqli_query($conn, "SELECT DISTINCT specilization FROM specilization");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['specilization'] . "'>" . $row['specilization'] . "</option>";
            }
            ?>
        </select>

        <label class="form-label">Doctor Fees:</label>
        <input type="number" name="docfees" class="form-input" required>

        <label class="form-label">Contact:</label>
        <input type="text" name="contact" class="form-input" required>

        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-input" required>

        <label class="form-label">Password:</label>
        <input type="password" name="password" class="form-input" required>

        <label class="form-label">Confirm Password:</label>
        <input type="password" name="confirm_password" class="form-input" required>

        <button type="submit" class="form-button">Add Doctor</button>
    </form>
</div>

</body>
</html>
