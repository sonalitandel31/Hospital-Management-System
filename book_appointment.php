<?php
session_start();
include('database.php');

if (!isset($_SESSION['patient_id'])) {
    header('location:patient_login.php');
    exit;
}

$patient_id = $_SESSION['patient_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor']); 
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $docfees = mysqli_real_escape_string($conn, $_POST['docfees']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);

    if (!empty($doctor_id) && !empty($specialization) && !empty($docfees) && !empty($date) && !empty($time)) {
        $min_time = "10:00";
        $max_time = "17:00";

        if ($time < $min_time || $time > $max_time) {
            $message = "<p style='color: red; text-align: center;'>Appointments can only be booked between 10:00 AM and 5:00 PM.</p>";
        } else {
            $checkQuery = "SELECT * FROM appointment 
                           WHERE d_id='$doctor_id' 
                           AND a_date='$date' 
                           AND ABS(TIMESTAMPDIFF(MINUTE, STR_TO_DATE(a_time, '%H:%i'), STR_TO_DATE('$time', '%H:%i'))) < 15";
            $result = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($result) > 0) {
                $message = "<p style='color: red; text-align: center;'>This doctor is already booked within 15 minutes of the selected time. Please choose another time.</p>";
            } else {
                $insertQuery = "INSERT INTO appointment (specilization, d_id, p_id, fees, a_date, a_time, userstatus, d_status) 
                                VALUES ('$specialization', '$doctor_id', '$patient_id', '$docfees', '$date', '$time', 1, 0)";

                if (mysqli_query($conn, $insertQuery)) {
                    $message = "<p style='color: green; text-align: center;'>Appointment successfully booked.</p>";
                } else {
                    $message = "<p style='color: red; text-align: center;'>Error booking appointment: " . mysqli_error($conn) . "</p>";
                }
            }
        }
    } else {
        $message = "<p style='color: red; text-align: center;'>All fields are required.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            margin-left: 40px;
            margin-top: 20px;
            background: white;
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 1000px;
        }
        h2 {
            color: #0277bd;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            text-align: left;
        }
        select, input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #90caf9;
            border-radius: 4px;
        }
        button {
            width: 50%;
            padding: 12px;
            background: #0288d1;
            color: white;
            border: none;
            border-radius: 4px;
            margin-left: 20.50%;
            margin-top: 20px;
            cursor: pointer;
        }
        button:hover {
            background: #01579b;
        }
        .message {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php include("patient_header.php"); ?>

<div class="form-container">
    <h2>USER | BOOK APPOINTMENT</h2>
    <?php echo $message; ?>
    <form method="POST" action="" onsubmit="return validateTime()">         
        <label>Doctors</label>
        <select name="doctor" id="doctor" required>
            <option value="">Select Doctor</option>
            <?php 
            $doctorQuery = "SELECT d_id, name, specilization, docfees FROM doctor_mast";
            $doctorResult = mysqli_query($conn, $doctorQuery);
            if ($doctorResult && mysqli_num_rows($doctorResult) > 0) {
                while ($row = mysqli_fetch_assoc($doctorResult)) {
                    echo "<option value='{$row['d_id']}' data-specialization='{$row['specilization']}' data-fees='{$row['docfees']}'>{$row['name']}</option>";
                }
            } else {
                echo "<option disabled>No doctors available</option>";
            }
            ?>
        </select>
        <label>Doctor Specialization</label>
        <input type="text" id="specialization" name="specialization" readonly>
        <label>Consultancy Fees</label>
        <input type="text" id="docfees" name="docfees" readonly>
        <label>Date</label>
        <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
        <label>Time</label>
        <input type="time" name="time" id="time" required min="10:00" max="17:00">
        <button type="submit">Submit</button>
    </form>
</div>

<script>
    document.getElementById("doctor").addEventListener("change", function() {
        let selectedDoctor = this.options[this.selectedIndex];
        document.getElementById("specialization").value = selectedDoctor.getAttribute("data-specialization") || "";
        document.getElementById("docfees").value = selectedDoctor.getAttribute("data-fees") || "";
    });

    function validateTime() {
        let timeInput = document.getElementById("time").value;
        let minTime = "10:00";
        let maxTime = "17:00";

        if (timeInput < minTime || timeInput > maxTime) {
            alert("Appointments can only be booked between 10:00 AM and 5:00 PM.");
            return false;
        }
        return true;
    }
</script>
</body>
</html>
