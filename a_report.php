<?php
include("admin_header.php");
include("database.php");
$from_date = "";
$to_date = "";
$result = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    if (!empty($from_date) && !empty($to_date)) {
        $query = "SELECT * FROM patient_mast WHERE created_at BETWEEN ? AND ? ORDER BY created_at DESC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $from_date, $to_date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        echo "<script>alert('Please select both dates!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report (B/w Dates)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-left: 2%;
        }
        
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        label {
            font-size: 15px;
            font-weight: bold;
        }
        input[type="date"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 8px 12px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            opacity: 0.8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #3498db;
            color: white;
        }
        .no-data {
            text-align: center;
            font-size: 16px;
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="margin-bottom: 2%;">Patient Report (B/w Dates)</h2>
    <form method="POST">
        <label>From: </label>
        <input type="date" name="from_date" value="<?php echo $from_date; ?>" required>
        <label>To: </label>
        <input type="date" name="to_date" value="<?php echo $to_date; ?>" required>
        <button type="submit" name="filter">Generate Report</button>
    </form>
    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Created At</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php } ?>
        </table>
    <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <p class="no-data">No records found for the selected dates.</p>
    <?php } ?>
</div>

</body>
</html>
