<?php
    include("header.php");
?>
    <section class="logins-section">
        <h2 style="margin-top: -2%;">Logins</h2>
        <div class="login-cards">
            <div class="login-card">
                <img src="img/patient.jpg" alt="Patient Login"><br>
                <p class="log">Patient Login</p>
                <a href="patient_login.php"><Button class="logBtn">Click Here</Button></a>
            </div>
            <div class="login-card">
                <img src="img/doctor.jpg" alt="Doctor Login"><br>
                <p class="log">Doctor Login</p>
                <a href="doctor_login.php"><Button class="logBtn">Click Here</Button></a>
            </div>
            <div class="login-card">
                <img src="img/admin.jpg" alt="Admin Login"><br>
                <p class="log">Admin Login</p>
                <a href="admin_login.php"><Button class="logBtn">Click Here</Button></a>
            </div>
        </div>
    </section>
<?php
    include("footer.php");
?>