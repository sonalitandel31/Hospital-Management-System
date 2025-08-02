<?php
    session_start();
    include('database.php');
    if(isset($_SESSION['patient_name'])){
        $patient_name = $_SESSION['patient_name'];
    }
    else{
        header('location:patient_login.php');
    }
?>
<?php
    include("patient_header.php");
?>
            <section class="dashboard">
            <h3 style="margin-left: 2%; font-size:20px;">User | Dashboard</h3><br>
            <div class="cards">
                <div class="card">
                    <i class="fas fa-user-circle fa-2x" style="opacity: 0.9;"></i><br>
                    <h4>My Profile</h4>
                    <a href="patient_account.php">Update Profile</a>
                </div>
                <div class="card">
                    <i class="fas fa-calendar-check fa-2x" style="opacity: 0.9;"></i>
                    <h4>My Appointments</h4>
                    <a href="appointment_history.php">View Appointment History</a>
                </div>
                <div class="card">
                    <i class="fas fa-calendar-plus fa-2x" style="opacity: 0.9;"></i>
                    <h4>Book My Appointment</h4>
                    <a href="book_appointment.php">Book Appointment</a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>