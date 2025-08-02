<?php
session_start();
include("database.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin_mast WHERE a_id = '$admin_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);
} else {
    echo "Admin not found.";
    exit();
}
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = mysqli_real_escape_string($conn, $name);
    $new_email = mysqli_real_escape_string($conn, $new_email);
    $password = mysqli_real_escape_string($conn, $password);
    if ($password === $admin['password']) {
        $update_query = "UPDATE admin_mast SET name='$name', email='$new_email' WHERE a_id='$admin_id'";
        if (mysqli_query($conn, $update_query)) {
            $message = "Account details updated successfully!";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $doctor = mysqli_fetch_assoc($result);
            }
        } else {
            $message = "Error updating account details.";
        }
    } else {
        $message = "Incorrect password. Please try again.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $password = trim($_POST['password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $password = mysqli_real_escape_string($conn, $password);
    $new_password = mysqli_real_escape_string($conn, $new_password);
    $confirm_password = mysqli_real_escape_string($conn, $confirm_password);
    if ($password === $admin['password']) {
        if ($new_password === $confirm_password) {
            $update_query = "UPDATE admin_mast SET password='$new_password' WHERE a_id='$admin_id'";
            if (mysqli_query($conn, $update_query)) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error updating password.";
            }
        } else {
            $message = "New passwords do not match!";
        }
    } else {
        $message = "Incorrect current password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="website icon" href="img/logo1.jpg" type="jpg">
    <link rel="stylesheet" href="css/account_style.css">
</head>
<body>
    <header>
        <h2>Your Account</h2>
        <nav>
            <a href="admin_index.php">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <section class="sec">
            <h2>Your Information</h2><br>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($admin['name']); ?></p><br>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p><br>
            <p><strong>Password:</strong> <?php echo str_repeat('*', strlen($admin['password'])); ?></p><br>

            <button class="btn1" onclick="toggleForm('update-info-form')">Update Info</button>
            <button class="btn1" onclick="toggleForm('change-password-form')">Change Password</button>

            <form method="POST" id="update-info-form" class="form-section">
                <br><label for="name">Name:</label><br>
                <input type="text" id="name" name="name" class="ipt1" value="<?php echo htmlspecialchars($admin['name']); ?>" required><br>

                <label for="email">New Email:</label>
                <input type="email" id="email" name="email" class="email-pass" value="<?php echo htmlspecialchars($admin['email']); ?>" required><br>

                <label for="password">Current Password:</label>
                <input type="password" id="password" class="email-pass" name="password" required><br>

                <button type="submit" class="btn" name="update">Update</button><br>
            </form>
            <form method="POST" id="change-password-form" class="form-section">
                <br><h3>Verify Your Old Password</h3><br>
                <label for="password">Current Password:</label>
                <input type="password" id="password" class="email-pass" name="password" required><br>

                <h3>Enter Your New Password</h3><br>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" class="ipt" name="new_password" required><br>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" class="ipt" name="confirm_password" required><br>

                <button type="submit" class="btn" name="change_password">Change Password</button>
            </form>
        </section>
    </div>
    <?php
    if($message){
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    ?>
    <script>
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
</body>
</html>
