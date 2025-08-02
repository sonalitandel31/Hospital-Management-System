<?php
    session_start();
    include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS | Patient Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/rl_style.css">
</head>
<body>
    <div class="container">
    <h1>HMS | Patient Registration</h1>
        <div class="form-container" style="margin-bottom: 3%;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                <fieldset>
                    <legend>Sign Up</legend>
                    <p class="p1">Enter your personal details below.</p>

                    <input type="text" id="fullname" name="fullname" class="input-field" placeholder="Full Name" required>
                    <input type="text" id="address" name="address" class="input-field" placeholder="Address" required>
                    <input type="text" id="city" name="city" class="input-field" placeholder="City" required>
                
                    <label style="color: grey;">Gender:</label>
                    <div class="radio-group" >
                        <input type="radio" id="female" name="gender" value="Female" required>
                        <label for="female" style="color: grey;">Female</label>
                        <input type="radio" id="male" name="gender" value="Male" required>
                        <label for="male" style="color: grey;">Male</label>
                        <input type="radio" id="other" name="gender" value="Other" required>
                        <label for="other" style="color: grey;">Other</label>
                    </div>
                    <p class="p1">Enter your account details below.</p>

                    <div class="input-group">
                    <label for="email">
                        <i class="fa fa-envelope"></i>
                    </label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    
                    <div class="input-group">
                    <label for="password">
                        <i class="fa fa-lock"></i>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirm_password">
                            <i class="fa fa-lock"></i>
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>
                                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">I agree</label>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </fieldset>
    <?php
        include("database.php");
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $fullname =filter_input(INPUT_POST,"fullname",FILTER_SANITIZE_SPECIAL_CHARS);
            $address =filter_input(INPUT_POST,"address",FILTER_SANITIZE_SPECIAL_CHARS);
            $city =filter_input(INPUT_POST,"city",FILTER_SANITIZE_SPECIAL_CHARS);
            $gender =filter_input(INPUT_POST,"gender",FILTER_SANITIZE_SPECIAL_CHARS);
            $email =filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
            $password =filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
            $password_hash=password_hash($password,PASSWORD_DEFAULT);
            if(empty($_POST["fullname"]) || empty($_POST["email"]) || empty($_POST["address"]) || empty($_POST["city"]) || empty($_POST["gender"]) || empty($_POST["password"])){ echo "";}
            else{
                $sql = "INSERT INTO patient_mast(fullname, address, city, gender, email, password) VALUES ('$fullname', '$address', '$city', '$gender', '$email', '$password_hash')";
                try {
                    mysqli_query($conn, $sql);
                    $patient_id = $conn->insert_id;
                    $_SESSION['patient_id'] = $patient_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['patient_name'] = $fullname;
                    header("Location: index.php");    
                } catch (mysqli_sql_exception) {
                    echo "<p style='color:red'>Sign up failed..</p>";
                }
            }
        }
        mysqli_close($conn);
    ?>
    </form>
            <p>Already have an account? <a href="patient_login.php">LogIn</a></p>
        </div>
    </div>
    <?php
        include("footer.php");  
    ?>
</body>
</html>