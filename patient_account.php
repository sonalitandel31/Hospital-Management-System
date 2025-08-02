<?php
session_start();
include("database.php");

if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$query = "SELECT * FROM patient_mast WHERE p_id = '$patient_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $patient = mysqli_fetch_assoc($result);
} else {
    die("Patient not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = trim($_POST['fullname']);
    $new_email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $gender = trim($_POST['gender']);
    $name = mysqli_real_escape_string($conn, $name);
    $new_email = mysqli_real_escape_string($conn, $new_email);
    $password = mysqli_real_escape_string($conn, $password);
    $address = mysqli_real_escape_string($conn, $address);
    $city = mysqli_real_escape_string($conn, $city);
    $gender = mysqli_real_escape_string($conn, $gender);

    if (password_verify($password, $patient['password'])) {
        $update_query = "UPDATE patient_mast SET fullname='$name', email='$new_email', address='$address', city='$city', gender='$gender' WHERE p_id='$patient_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Account details updated successfully!'); window.location.href='patient_account.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating account details.');</script>";
        }
    } else {
        echo "<script>alert('Incorrect password. Please try again.');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $password = trim($_POST['password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (password_verify($password, $patient['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE patient_mast SET password='$hashed_new_password' WHERE p_id='$patient_id'";
            if (mysqli_query($conn, $update_query)) {
                echo "<script>alert('Password updated successfully!'); window.location.href='patient_account.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error updating password.');</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Incorrect current password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
        }
        nav {
            margin-top: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }
        .container {
            width: 30%;
            background-color: white;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .sec {
            text-align: center;
        }
        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .form-section {
            display: none;
            padding: 20px;
            background-color: #ecf0f1;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .form-section label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
            margin-left: 2%;
        }
        .radio-group {
            display: flex;
            align-items: center;
            gap:10px; /* Space between Male and Female */
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 3px;
            margin: 0;
            margin-left: 2%;
            margin-top: 2%;
            font-weight: lighter;
        }
        .radio-group input[type="radio"] {
            margin: 0;
            padding: 0;
        }

        input, select {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Your Account</h2>
        <nav>
            <a href="patient_index.php">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <section class="sec">
            <h2>Your Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['fullname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($patient['address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($patient['city']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>

            <?php if ($message): ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php endif; ?>

            <button class="btn" onclick="toggleForm('update-info-form')">Update Info</button>
            <button class="btn" onclick="toggleForm('change-password-form')">Change Password</button>

            <form method="POST" id="update-info-form" class="form-section">
                <label>Full Name:</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($patient['fullname']); ?>" required>

                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>

                <label>Address:</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($patient['address']); ?>" required>

                <label>City:</label>
                <input type="text" name="city" value="<?php echo htmlspecialchars($patient['city']); ?>" required>

                <label>Gender:</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male" <?php if ($patient['gender'] == 'Male') echo 'checked'; ?>>Male</label>
                    <label><input type="radio" name="gender" value="Female" <?php if ($patient['gender'] == 'Female') echo 'checked'; ?>>Female</label>
                    <label><input type="radio" name="gender" value="Other" <?php if ($patient['gender'] == 'Other') echo 'checked'; ?>>Other</label>
                </div>

                <label>Current Password:</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn" name="update">Update</button>
            </form>

            <form method="POST" id="change-password-form" class="form-section">
                <label>Current Password:</label>
                <input type="password" name="password" required>

                <label>New Password:</label>
                <input type="password" name="new_password" required>

                <label>Confirm New Password:</label>
                <input type="password" name="confirm_password" required>

                <button type="submit" class="btn" name="change_password">Change Password</button>
            </form>
        </section>
    </div>

    <script>
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            form.style.display = form.style.display === "block" ? "none" : "block";
        }
    </script>
</body>
</html>
