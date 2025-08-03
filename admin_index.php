<?php
include("admin_header.php");
include('database.php');

if (!isset($_SESSION['admin_name'])) {
    header('Location: admin_login.php');
    exit();
}

function getCount($conn, $query) {
    $result = $conn->query($query);
    return $result ? $result->fetch_assoc()['total'] ?? 0 : 0;
}

$patientCount = getCount($conn, "SELECT COUNT(*) AS total FROM patient_mast");
$doctorCount = getCount($conn, "SELECT COUNT(*) AS total FROM doctor_mast");
$appointmentCount = getCount($conn, "SELECT COUNT(*) AS total FROM appointment");
$queryCount = getCount($conn, "SELECT COUNT(*) AS total FROM contactus");
$totalIncome = getCount($conn, "SELECT SUM(fees) AS total FROM appointment WHERE d_status = 1");

$yearFilter = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$incomeData = [];
$doctorNames = []; 

$query = "SELECT a.d_id, d.name AS doctor_name, MONTH(a.a_date) as month, YEAR(a.a_date) as year, SUM(a.fees) as total_income 
          FROM appointment a
          JOIN doctor_mast d ON a.d_id = d.d_id
          WHERE a.d_status = 1 AND YEAR(a.a_date) = $yearFilter
          GROUP BY a.d_id, MONTH(a.a_date), YEAR(a.a_date)";

$result = $conn->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $incomeData[] = $row;
        $doctorNames[$row['d_id']] = $row['doctor_name']; 
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<section class="dashboard" style="height: 90vh; overflow: hidden;">
    <h3 style="text-align:center; font-size:20px;">Admin Dashboard</h3>
    <br>
    <div class="cards" style="display: flex; justify-content: space-around; flex-wrap: wrap;">
        <div class="card" style="height: 90px;"><h4><i class="fas fa-user-circle fa-2x"></i></h4><p><a href="admin_account.php" style="color:black;margin-top:1%">Admin Profile</a></p></div>
        <div class="card" style="height: 90px;"><h4>Total Patients</h4><p><?= $patientCount ?></p></div>
        <div class="card" style="height: 90px;"><h4>Total Doctors</h4><p><?= $doctorCount ?></p></div>
        <div class="card" style="height: 90px;"><h4>Total Appointments</h4><p><?= $appointmentCount ?></p></div>
        <div class="card" style="height: 90px;"><h4>Total Queries</h4><p><?= $queryCount ?></p></div>
        <div class="card" style="height: 90px;"><h4>Total Income</h4><p>₹<?= number_format($totalIncome, 2) ?></p></div>
    </div>

    <br>
    <div style="width: 80%; margin: auto; height: 300px;">
        <h4>Total Income by Doctor & Month</h4>

        <form method="GET" id="yearForm" style="margin-bottom: 20px;">
            <label for="year">Select Year: </label>
            <select name="year" id="year" style="width: 60px;height:30px; border:none" onchange="document.getElementById('yearForm').submit();">
                <?php 
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                    $selected = $i == $yearFilter ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
                ?>
            </select>
        </form>

        <canvas id="incomeChart" style="height: 250px;"></canvas>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('incomeChart').getContext('2d');
        let incomeChart; 

        function updateChart() {
            if (incomeChart) {
                incomeChart.destroy(); 
            }

            const incomeData = <?= json_encode($incomeData) ?>;
            const doctorNames = <?= json_encode($doctorNames) ?>;
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            const doctorIds = [...new Set(incomeData.map(item => item.d_id))];

            const datasets = doctorIds.map(doctor => ({
                label: doctorNames[doctor], 
                data: months.map((_, i) => {
                    const found = incomeData.find(item => item.d_id == doctor && item.month == (i + 1));
                    return found ? found.total_income : 0;
                }),
                borderColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 1)`,
                borderWidth: 2,
                fill: false
            }));

            incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months, 
                    datasets: datasets
                },
                options: { 
                    responsive: true, 
                    plugins: { 
                        legend: { position: 'top' } 
                    }, 
                    scales: { 
                        y: { beginAtZero: true } 
                    } 
                }
            });
        }

        updateChart(); 
    });
</script>

</body>
</html>
