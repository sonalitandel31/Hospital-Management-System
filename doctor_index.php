<?php
    include("doctor_header.php");
    include("database.php");

    // Fetch doctor ID from session
    $doctor_id = $_SESSION['doctor_id'];
    $current_date = date('Y-m-d');
    
    // Query to get pending appointments
    $query = "SELECT COUNT(*) AS pending_count FROM appointment WHERE d_id = $doctor_id AND a_date = '$current_date' AND d_status = 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $pending_count = $row['pending_count'];

    // Query to get available years for the doctor
    $years_query = "SELECT DISTINCT YEAR(a_date) AS year FROM appointment WHERE d_id = $doctor_id ORDER BY year DESC";
    $years_result = mysqli_query($conn, $years_query);
    
    $years = [];
    while ($row = mysqli_fetch_assoc($years_result)) {
        $years[] = $row['year'];
    }

    // Query to get monthly earnings for the doctor in the current year
    $earnings_query = "SELECT MONTH(a_date) AS month, SUM(fees) AS total_income 
                       FROM appointment 
                       WHERE d_id = $doctor_id AND d_status = 1 AND YEAR(a_date) = YEAR(CURRENT_DATE)
                       GROUP BY MONTH(a_date) 
                       ORDER BY MONTH(a_date)";
    $earnings_result = mysqli_query($conn, $earnings_query);
    
    $earnings_data = [];
    while ($earnings_row = mysqli_fetch_assoc($earnings_result)) {
        $earnings_data[] = $earnings_row;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="your-style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <section class="dashboard">
        <h3 style="font-size:larger; margin-left:2%;">Doctor | Dashboard</h3><br>
        <div class="cards">
            <div class="card">
                <i class="fas fa-user-circle fa-2x" style="opacity: 0.9;"></i><br>
                <h4 style="margin-top:0.8%;">My Profile</h4>
                <a href="doctor_account.php">Update Profile</a>
            </div>
            <div class="card">
                <i class="fas fa-calendar-check fa-2x" style="opacity: 0.9;"></i>
                <h4 style="margin-top:0.8%;">My Appointments</h4>
                <a href="dr_appointment_history.php">
                    View Appointment History 
                    <?php if ($pending_count > 0) { ?>
                        <span style="color: red; font-weight: bold;">(<?= $pending_count ?> pending)</span>
                    <?php } ?>
                </a>
            </div>
        </div>

        <!-- Year Selector -->
        <div style="margin-top: 20px; margin-left: 30px;margin-bottom:-3%;">
            <label for="yearSelect">Select Year:</label>
            <select id="yearSelect" style="border:none;">
                <?php foreach ($years as $year) { ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- Earnings Chart Section -->
        <div style="width: 60%; height: 200px; overflow: hidden; margin: 60px 0 0 30px;">
            <h4>Monthly Earnings</h4>
            <canvas id="earningsChart" style="height: 180px; width: 100%;"></canvas>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('earningsChart').getContext('2d');
            const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            
            // Initial earnings data from PHP
            const earningsData = <?= json_encode($earnings_data) ?>;

            // Prepare chart data
            const earningsByMonth = new Array(12).fill(0);
            earningsData.forEach(item => {
                earningsByMonth[item.month - 1] = item.total_income;
            });

            // Create the chart
            const earningsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months, // Months as labels
                    datasets: [{
                        label: 'Earnings',
                        data: earningsByMonth, // Monthly earnings data
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                            }
                        }
                    }
                }
            });

            // Handle year selection change
            document.getElementById('yearSelect').addEventListener('change', function() {
                const selectedYear = this.value;

                // Fetch new earnings data based on selected year
                const formData = new FormData();
                formData.append('doctor_id', '<?= $doctor_id ?>');
                formData.append('year', selectedYear);

                fetch('<?= $_SERVER['PHP_SELF'] ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const earningsByMonth = new Array(12).fill(0);
                    data.forEach(item => {
                        earningsByMonth[item.month - 1] = item.total_income;
                    });

                    // Update chart with new data
                    earningsChart.data.datasets[0].data = earningsByMonth;
                    earningsChart.update();
                })
                .catch(error => console.error('Error fetching earnings data:', error));
            });
        });
    </script>
</body>
</html>

<?php
// Handle the form submission (AJAX) for fetching earnings data based on selected year
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $year = $_POST['year'];

    // Query to get monthly earnings for the doctor in the selected year
    $earnings_query = "SELECT MONTH(a_date) AS month, SUM(fees) AS total_income 
                       FROM appointment 
                       WHERE d_id = $doctor_id AND d_status = 1 AND YEAR(a_date) = $year
                       GROUP BY MONTH(a_date) 
                       ORDER BY MONTH(a_date)";
    $earnings_result = mysqli_query($conn, $earnings_query);

    $earnings_data = [];
    while ($earnings_row = mysqli_fetch_assoc($earnings_result)) {
        $earnings_data[] = $earnings_row;
    }

    // Return the earnings data as JSON
    echo json_encode($earnings_data);
    exit;
}
?>
