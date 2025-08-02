<?php
    include("admin_header.php");
    include('database.php');

    if (!isset($_SESSION['admin_id'])) {
        header('Location: admin_login.php');
        exit;
    }
    $query = "SELECT a.a_id, p.fullname AS patient_name, p.email, p.gender, a.a_date, a.a_time, a.d_status, 
                     d.name AS doctor_name 
              FROM appointment a
              JOIN patient_mast p ON a.p_id = p.p_id
              JOIN doctor_mast d ON a.d_id = d.d_id";

    $result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }
        .container {
            width: 98%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: rgb(66, 134, 206);
            color: white;
        }
        .status-form select {
            padding: 5px;
        }
        .status-form button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .status-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment History</h2><br>
        <table>
            <tr>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Doctor Name</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['a_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['a_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                    <td class="status-text" style="font-weight: bold;
                        <?php 
                            if ($row['d_status'] == 1) { 
                                echo 'color: green;';
                            } elseif ($row['d_status'] == 0) { 
                                echo 'color: orange;';
                            } else { 
                                echo 'color: red;';
                            }
                        ?>">
                        <?php 
                            echo ($row['d_status'] == 1) ? 'Completed' : 
                                (($row['d_status'] == 0) ? 'Pending' : 'Cancelled'); 
                        ?>
                    </td>
                </tr>
                            <?php } ?>
        </table>
    </div>
</body>
</html>
