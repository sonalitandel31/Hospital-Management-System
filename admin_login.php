<?php
    session_start();
    include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS | Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/rl_style.css">
</head>
<body>
    <section class="login-container" style="margin-bottom: -23%;">
    <h1>HMS | Admin Login</h1>
        <div class="login-box" style="margin-bottom: 25%;">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
                <p class="p2">Sign in to your account</p>
                <p class="p1">Please enter your name and password to log in.</p>
                <div class="input-group">
                    <label for="email">
                        <i class="fa fa-user"></i>
                    </label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <label for="password">
                        <i class="fa fa-lock"></i>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="login-btn">Login <i class="fa fa-arrow-right"></i></button>
                <?php
                    include("database.php");
                    if($_SERVER["REQUEST_METHOD"]=="POST")
                    {
                        $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
                        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);          
                        if(!empty($email) && !empty($password))
                        {
                            $sql = "SELECT * FROM admin_mast WHERE email = '$email'";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $user = mysqli_fetch_assoc($result);
                                if ($password === $user["password"]){
                                    $_SESSION['admin_id']=$user['a_id'];
                                    $_SESSION['admin_name']=$user['name'];
                                    header("location:admin_index.php");
                                    exit;
                                }
                            }
                        }
                    }
                    mysqli_close($conn);
                ?>
            </form>
        </div>
    </section>
    <?php
        include("footer.php");
    ?>
</body>
</html>