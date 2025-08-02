<?php
session_start();
include("database.php");

$p_id = (int)$_SESSION['patient_id'];

$sql_history = "SELECT * FROM medical_history WHERE p_detail_id = $p_id";
$result_history = $conn->query($sql_history);
?>
<?php
include("patient_header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
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
    <h2>Medical History</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>BP</th>
            <th>BS</th>
            <th>Weight</th>
            <th>Temperature</th>
            <th>Prescription</th>
            <th>Created At</th>
        </tr>
        <?php
        if ($result_history->num_rows > 0) {
            while ($row = $result_history->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['m_id']}</td>
                    <td>{$row['bp']}</td>
                    <td>{$row['bs']}</td>
                    <td>{$row['weight']}</td>
                    <td>{$row['temperature']}</td>
                    <td>{$row['m_prescription']}</td>
                    <td>{$row['created_at']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No medical history found.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
