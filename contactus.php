<?php
include("header.php");
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contactus (name, email, mobile, message) VALUES ('$name', '$email', '$mobile', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="contact-section">
        <h2 style="margin-top: -1%;">Contact Us</h2>
        <form class="contact-form" action="" method="post">
            <input type="text" name="name" placeholder="Enter Name" required>
            <input type="email" name="email" placeholder="Enter Email Address" required>
            <input type="tel" name="mobile" placeholder="Enter Mobile Number" required>
            <textarea name="message" rows="4" placeholder="Enter Your Message" required></textarea>
            <button type="submit" style="width: 105%;">Send Message</button>
        </form>
    </section>
    <?php
        include("footer.php");
    ?>
</body>
</html>