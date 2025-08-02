<?php
include('doctor_header.php');
include('database.php');

if (!isset($_SESSION['doctor_id'])) {
    echo "<script>alert('Unauthorized access!'); window.location.href='login.php';</script>";
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $medhis = mysqli_real_escape_string($conn, $_POST['medhis']);

    $sql = "INSERT INTO patient_detail (d_id, p_name, p_email, p_gender, p_add, p_age, p_contact, p_medhis) 
            VALUES ('$doctor_id', '$fullname', '$email', '$gender', '$address', '$age', '$contact_no', '$medhis')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Patient added successfully!'); window.location.href='manage_patient.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
            margin-top: 2%;
            margin-left: 2%;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input, textarea {
            width: 99%;
            padding: 7px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s;
        }
        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        .radio-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            font-weight: lighter;
        }
        .radio-group input {
            margin: 0; 
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width:25%;
            transition: background 0.3s;
            margin-left: 35%;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Patient</h2>
        <form method="post">
            <label>Patient Name</label>
            <input type="text" name="fullname" required>

            <label>Patient Email</label>
            <input type="email" name="email" required>

            <label>Gender</label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Female" required> Female</label>
                <label><input type="radio" name="gender" value="Male" required> Male</label>
                <label><input type="radio" name="gender" value="Other" required> Other</label>
            </div>

            <label>Patient Address</label>
            <textarea name="address" required></textarea>

            <label>Patient Age</label>
            <input type="number" name="age" required>

            <label>Contact No</label>
            <input type="text" name="contact_no" required>

            <label>Medical History</label>
            <textarea name="medhis"></textarea>

            <button type="submit" class="btn-submit">Add</button>
        </form>
    </div>
</body>
</html>
