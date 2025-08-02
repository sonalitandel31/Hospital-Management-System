<?php
    include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Hospital Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 80%; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        h2 { color: #2c3e50; text-align: center; }
        p { line-height: 1.6; font-size: 16px; color: #333; }
        .team { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px; }
        .team-member { text-align: center; width: 200px; }
        .team-member img { width: 100%; border-radius: 50%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
        .team-member h4 { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>About Our Hospital</h2>
        <p>Welcome to our Hospital Management System. Our mission is to provide high-quality healthcare services through an efficient and reliable system. We aim to streamline patient care, manage medical records, and enhance communication between doctors, nurses, and administrative staff.</p>
        
        <h2>Our Vision</h2>
        <p>To be a leading healthcare provider, integrating technology and medical expertise to ensure the best patient care experience.</p>
        
        <h2>Our Team</h2>
        <div class="team">
            <div class="team-member">
                <img src="img/doctor1.jpg" alt="Dr. Smith">
                <h4>Dr. John Smith</h4>
                <p>Chief Medical Officer</p>
            </div>
            <div class="team-member">
                <img src="img/doctor2.jpg" alt="Dr. Jane Doe">
                <h4>Dr. Jane Doe</h4>
                <p>Head of Surgery</p>
            </div>
            <div class="team-member">
                <img src="img/admin.jpg" alt="Admin">
                <h4>Mr. Robert Brown</h4>
                <p>Hospital Administrator</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    include("footer.php");
?>