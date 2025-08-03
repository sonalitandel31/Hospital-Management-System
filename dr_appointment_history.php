<?php
ob_start();
include("doctor_header.php");
include('database.php');
if (!isset($_SESSION['doctor_id'])) {
    header('Location: doctor_login.php');
    exit;
}

$doctor_id = intval($_SESSION['doctor_id']); 
if (isset($_POST['confirm_id'])) {
    $confirm_id = intval($_POST['confirm_id']);
    $update_confirm_query = "UPDATE appointment SET d_status = 1 WHERE a_id = $confirm_id AND d_id = $doctor_id";
    mysqli_query($conn, $update_confirm_query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if (isset($_POST['cancel_id'])) {
    $cancel_id = intval($_POST['cancel_id']);
    $update_cancel_query = "UPDATE appointment SET d_status = 2 WHERE a_id = $cancel_id AND d_id = $doctor_id";
    mysqli_query($conn, $update_cancel_query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
$status_filter = isset($_GET['status']) ? intval($_GET['status']) : -1; 
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$query = "SELECT a.a_id, p.fullname AS patient_name, p.email, p.gender, a.a_date, a.a_time, a.d_status
          FROM appointment a
          INNER JOIN patient_mast p ON a.p_id = p.p_id
          WHERE a.d_id = $doctor_id";

if ($status_filter >= 0) {
    $query .= " AND a.d_status = $status_filter";
}

if (!empty($date_filter)) {
    $query .= " AND a.a_date = '$date_filter'";
}

$query .= " ORDER BY a.a_date DESC";
$result = mysqli_query($conn, $query);

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointment History</title>
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
        .status {
            font-weight: bold;
        }
        .completed { color: green; }
        .pending { color: orange; }
        .cancelled { color: red; }
        .confirm-btn, .cancel-btn {
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .confirm-btn { background-color: green; }
        .confirm-btn:hover { background-color: darkgreen; }
        .cancel-btn { background-color: red; }
        .cancel-btn:hover { background-color: darkred; }
        .filter-container {
            margin-bottom: 10px;
        }
        select, button, input {
            padding: 8px;
            font-size: 14px;
        }
        .filter-container {
            margin-top: 2%;
            margin-bottom: 10px;
        }
        select, input {
            padding: 4px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    <script>
        function confirmAppointment(a_id) {
            if (confirm("Are you sure you want to confirm this appointment?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "";
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "confirm_id";
                input.value = a_id;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function cancelAppointment(a_id) {
            if (confirm("Are you sure you want to cancel this appointment?")) {
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "";
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "cancel_id";
                input.value = a_id;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function filterAppointments() {
            let status = document.getElementById("status-filter").value;
            let date = document.getElementById("date-filter").value;
            let url = "?status=" + status;
            if (date) {
                url += "&date=" + date;
            }
            window.location.href = url;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Doctor's Appointment History</h2>
        <div class="filter-container">
            <label for="status-filter"><b>Filter by Status:</b></label>
            <select id="status-filter" onchange="filterAppointments()">
                <option value="-1" <?php if ($status_filter == -1) echo 'selected'; ?>>All</option>
                <option value="0" <?php if ($status_filter == 0) echo 'selected'; ?>>Pending</option>
                <option value="1" <?php if ($status_filter == 1) echo 'selected'; ?>>Completed</option>
                <option value="2" <?php if ($status_filter == 2) echo 'selected'; ?>>Cancelled</option>
            </select>
            <label for="date-filter"><b>&nbsp;&nbsp;&nbsp;Filter by Date:</b></label>
            <input type="date" id="date-filter" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>" onchange="filterAppointments()">
        </div>

        <table>
            <tr>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['a_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['a_time']); ?></td>
                        <td class="status <?php echo ($row['d_status'] == 1) ? 'completed' : (($row['d_status'] == 0) ? 'pending' : 'cancelled'); ?>">
                            <?php echo ($row['d_status'] == 1) ? 'Completed' : (($row['d_status'] == 0) ? 'Pending' : 'Cancelled'); ?>
                        </td>
                        <td>
                            <?php if ($row['d_status'] == 0) { ?>
                                <button class="confirm-btn" onclick="confirmAppointment(<?php echo $row['a_id']; ?>)">Confirm</button>
                                <button class="cancel-btn" onclick="cancelAppointment(<?php echo $row['a_id']; ?>)">Cancel</button>
                            <?php } else { echo "-"; } ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr><td colspan="7" style="text-align: center; font-weight: bold;">No appointments found.</td></tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>