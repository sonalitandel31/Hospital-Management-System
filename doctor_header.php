<?php
    session_start();
    include('database.php');
    if (!isset($_SESSION['doctor_id'])) {
        header('Location: doctor_login.php');
        exit;
    }
    $doctor_name = $_SESSION['doctor_name'];
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
            /*justify-content: space-between;*/
            gap: 20px;
            margin-left: 2%;
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
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropbtn {
            margin-left: -19%;
            margin-top: -10%;
            margin-bottom: -10%;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color:rgb(255, 255, 255);
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color:black;
            padding: 6px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <ul>
        <li><a href="doctor_index.php">Dashboard</a></li>
        <li><a href="dr_appointment_history.php">Appointment History</a></li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Patients <i class="fas fa-caret-down"></i></a>
            <div class="dropdown-content">
                <a href="add_patient.php" style="color: black; border-radius:0;">Add Patient</a>
                <a href="manage_patient.php" style="color: black; border-radius:0;">Manage Patient</a>
            </div>
        </li>
        <li><a href="search_patient.php">Search</a></li>
        <li><a href="logout.php" onclick="return confirmLogout()">Logout</a>
            <script>
                function confirmLogout() {
                    return confirm("Are you sure you want to log out?");
                }
            </script>
        </li>
    </ul>
</div>
    <div class="main-content">
        <header>
            <h2>&nbsp;&nbsp;Hospital Management System</h2>
            <div class="user-info" style="font-weight: bold; margin-right:1%;">
            <i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $doctor_name; ?>
            </div>
        </header>