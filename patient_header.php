<?php
    include('database.php');
    if (!isset($_SESSION['patient_id'])) {
        header('Location: patient_login.php');
        exit;
    }
    $patient_name = $_SESSION['patient_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link rel="website icon" href="img/logo1.jpg" type="jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            background-color: #f0f8ff;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background:rgb(66, 134, 206);
            color: white;
            padding: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .sidebar ul li a:hover {
            background:rgb(94, 142, 193);
            border-radius: 5px;
        }
        .main-content {
            flex: 1;
            padding:5px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard {
            margin-top: 20px;
        }
        .cards {
            display: flex;
            justify-content: space-evenly;
            gap: 15px;
        }
        .card {
            background: white;
            padding: 20px;
            text-align: center;
            width: 30%;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 50px;
            margin-bottom: 10px;
        }
        .card a {
            display: block;
            margin-top: 10px;
            color:rgb(50, 128, 210);
            text-decoration: none;
        }
        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="patient_index.php">Dashboard</a></li>
            <li><a href="book_appointment.php">Book Appointment</a></li>
            <li><a href="appointment_history.php">Appointment History</a></li>
            <li><a href="medical_history.php">Medical History</a></li>
            <li><a href="logout.php" onclick="confirmLogout()">Logout</a></li>
            <script>
                function confirmLogout() {
                    if (confirm("Are you sure you want to log out?")) {
                        window.location.href = "logout.php";
                    }
                }
            </script>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h2>&nbsp;&nbsp;Hospital Management System</h2>
            <div class="user-info" style="font-weight: bold; margin-right:1%;">
            <i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $patient_name; ?>
            </div>
        </header>
        