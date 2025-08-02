<?php
session_start();
include('database.php');

if (!isset($_SESSION['patient_id'])) {
    echo "<p>Error: Patient ID not found in session.</p>";
    exit;
}
$p_id = $_SESSION['patient_id'];

if (isset($_POST['cancel']) && isset($_POST['a_id'])) {
    $a_id = mysqli_real_escape_string($conn, $_POST['a_id']);

    $query = "UPDATE appointment SET d_status = 2 WHERE a_id = '$a_id' AND p_id = '$p_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Appointment cancelled successfully.'); window.location.href='appointment_history.php';</script>";
    } else {
        echo "<p>Error cancelling appointment: " . mysqli_error($conn) . "</p>";
    }
}

$query = "SELECT a.a_id, d.name AS doctor_name, d.specilization AS specialization, d.docfees AS fees, 
                 a.a_date, a.a_time, a.postingdate AS created_at, a.d_status 
          FROM appointment a 
          JOIN doctor_mast d ON a.d_id = d.d_id 
          WHERE a.p_id = '$p_id'";
$result = mysqli_query($conn, $query);
?>

<?php include("patient_header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgb(121, 187, 230);
            color: white;
        }
        .cancel-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .cancel-btn:hover {
            background-color: #c0392b;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-completed {
            color: green;
            font-weight: bold;
        }
        .status-cancelled {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<section class="dashboard">
<h3>Patient | Appointment History</h3><br>
<table border="1">
    <thead>
        <tr>
            <th>Appointment ID</th>
            <th>Doctor Name</th>
            <th>Specialization</th>
            <th>Consultancy Fee</th>
            <th>Appointment Date / Time</th>
            <th>Appointment Creation Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $status = "";
                $status_class = "";
                if ($row['d_status'] == 0) {
                    $status = "Pending";
                    $status_class = "status-pending";
                } elseif ($row['d_status'] == 1) {
                    $status = "Completed";
                    $status_class = "status-completed";
                } elseif ($row['d_status'] == 2) {
                    $status = "Cancelled";
                    $status_class = "status-cancelled";
                }

                echo "<tr>
                        <td>{$row['a_id']}</td>            
                        <td>{$row['doctor_name']}</td>
                        <td>{$row['specialization']}</td>
                        <td>{$row['fees']}</td>
                        <td>{$row['a_date']} at {$row['a_time']}</td>
                        <td>{$row['created_at']}</td>
                        <td class='{$status_class}'>{$status}</td>
                        <td>";
                if ($row['d_status'] == 0) {
                    echo "<form method='POST' action='' onsubmit='return confirmDelete()'>
                              <input type='hidden' name='a_id' value='{$row['a_id']}'>
                              <input type='submit' class='cancel-btn' name='cancel' value='Cancel'>
                          </form>";
                } else {
                    echo "N/A"; 
                }

                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No Appointment Found.</td></tr>";
        }
        ?>
    </tbody>
</table>
</section>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to cancel this appointment?');
    }
</script>
</body>
</html>
