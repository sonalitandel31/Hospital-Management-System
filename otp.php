<?php
include("database.php");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('./PHPMailer-master/src/Exception.php');
require('./PHPMailer-master/src/PHPMailer.php');
require('./PHPMailer-master/src/SMTP.php');

function sendOtp($email,$otp){
    $mail=new PHPMailer(true);
    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hmsonline3111@gmail.com';
        $mail->Password = 'qjcqkyuggdcmksbk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('hmsonline3111@gmail.com', 'HMS');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject='Recovery Password';
        $mail->Body="OTP: <b>$otp</b>";
        $mail->send();
        return true;
    }catch(Exception $e){
        return false;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_otp'])) {
    $email = $_POST['email'];
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        $stmt = $conn->prepare("SELECT email FROM patient_mast WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['email'] = $email;
            $_SESSION['otp'] = rand(1000, 9999);

            if (sendOtp($email, $_SESSION['otp'])) {
                $otp_sent = "OTP has been sent to your email.";
            } else {
                $error = "Failed to send OTP.";
            }
        } else {
            echo "<script>
                    alert('Email not found in our records. Please try again.');
                    window.location.href = 'otp.php';
                  </script>";
            exit;
        }

        $stmt->close();

    } else {
        $error = "Invalid email address. Please try again.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
    $enteredOtp = $_POST['otp'];

    if ($enteredOtp == $_SESSION['otp']) {
        unset($_SESSION['otp']); 
        header('Location: change_password.php');
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-modal {
            background-color: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 350px;
            position: relative;
        }
        .otp-close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 18px;
            background: none;
            border: none;
            cursor: pointer;
        }
        .otp-heading {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .otp-subheading {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }
        .otp-input-container {
            width: 100%;
            display: flex;
            flex-direction: row;
            gap: 10px;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            }
        .otp-input {
            background-color: rgb(228, 228, 228);
            width: 30px;
            height: 30px;
            text-align: center;
            border: none;
            border-radius: 7px;
            caret-color: rgb(127, 129, 255);
            color: rgb(44, 44, 44);
            outline: none;
            font-weight: 600;
            }

        .otp-input:focus,
        .otp-input:valid {
            background-color: rgba(127, 129, 255, 0.199);
            transition-duration: .3s;
        }
        .otp-email {
                width: 100%;
                padding: 12px;
                font-size: 1rem;
                border: 1px solid #ccc;
                border-radius: 8px;
        }
        .otp-button {
                width: 60%;
                padding: 10px;
                background-color:#007bff;
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-bottom: 20px;
        }
        .otp-button:hover {
                background-color:#0056b3;
        }
        .otp-resend {
                margin-top: 15px;
                font-size: 0.9rem;
                color: #007bff;
                text-decoration: none;
                cursor: pointer;
        }
        .otp-resend:hover {
                text-decoration: underline;
        }
        .otp-error {
                color: #dc3545;
                font-size: 0.9rem;
                margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="otp-modal">
        
        <?php if (!isset($_POST['send_otp'])): ?>
            <form method="POST">
                <h2 class="otp-heading">Enter Email ID</h2>
                <div class="otp-input-container">
                    <input type="email" name="email" class="otp-email" placeholder="example@mail.xyz" required>
                </div>
                <button type="submit" name="send_otp" class="otp-button">Send OTP</button>
            </form>
        <?php else: ?>
            <p class="otp-subheading">We have sent a verification code to your email: <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong>.</p>
            <form method="POST">
                <h2 class="otp-heading">Enter OTP</h2>
                <div class="otp-input-container">
                    <input type="text" maxlength="1" name="otp_digit[]" class="otp-input" required>
                    <input type="text" maxlength="1" name="otp_digit[]" class="otp-input" required>
                    <input type="text" maxlength="1" name="otp_digit[]" class="otp-input" required>
                    <input type="text" maxlength="1" name="otp_digit[]" class="otp-input" required>
                </div>
                <input type="hidden" name="otp" id="otp" value="">
                <button type="submit" name="verify_otp" class="otp-button" onclick="combineOtp()">Verify</button>
            </form>
            <a href="#" class="otp-resend">Resend Code</a>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="otp-error"><?php echo $error; ?></p>
        <?php elseif (isset($otp_sent)): ?>
            <p class="otp-error" style="color: #28a745;"><?php echo $otp_sent; ?></p>
        <?php endif; ?>
    </div>

    <script>
        function combineOtp() {
            const inputs = document.querySelectorAll('.otp-input');
            const otpField = document.getElementById('otp');
            otpField.value = Array.from(inputs).map(input => input.value).join('');
        }
    </script>
</body>
</html>
