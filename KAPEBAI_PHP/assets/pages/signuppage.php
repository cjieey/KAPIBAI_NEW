<?php
    include("dbconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel = "stylesheet" type = "text/css" href = "../css/register.css"> 
</head>
<body>
    <div class="box-container">
            <div class="title-div">
                <img class="logo" src="../img/coffee.jpg" alt="coffee">
                <h2 class="title">Kape Bai: Cashiering System</h2>
            </div>
            <div class="register-div">
                <h3 class="sub-title">CREATE YOUR ACCOUNT</h3>
                <form action="../pages/signup.php" method="post">
                    <div class="input-group">
                        <input type="text" id="firstname" name="firstname" placeholder="First name" required>
                        <input type="text" id="lastname" name="lastname" placeholder="Last name" required>
                    </div>
                    <div class="input-group">
                        <input type="text" id="age" name="age" name="firstname" placeholder="Age" required>
                    </div>
                    <div class="input-group">
                        <input type="address" id="address" name="address" placeholder="Address" required>
                    </div>
                    <div class="input-group">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <br>
                    <input class="signup-btn" type="submit" name="submit" value="Sign up">
                    <p>Already have an account? <a class="signin-btn" href="index.php">Sign in</a></p>
                </form>
            </div>
        </div>
</body>
</html>

