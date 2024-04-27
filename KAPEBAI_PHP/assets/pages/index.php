
<?php
    include("dbconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css"> 
</head>
<body>  
    <div class="box-container">
        <div class="left-div">
            <h1 class="title">KAPE BAI</h1>
            <h2 class="sub-title">Cashiering System</h2>
            <img src="../img/coffee.jpg" alt="coffee logo" class="coffee-logo">
        </div>  
        <div class="right-div"> 
            <div class="small-box">
                <h2 class="login-title">Login</h2>
                <p>Log in to your account</p>
                <form name="form" action="../pages/login.php" method="POST">
                    <input type="text" id="username" name="username" placeholder="Username" required> 
                    <input type="password" id="password" name="password" placeholder="Password" required> 
                    <br>    
                    <label class="remember-me">
                        <input type="checkbox" id="remember-me" name="remember-me"> 
                        <span>Remember me</span>
                    </label>
                    <br>
                    <input class="login-btn" type="submit" id="btn" value="Log In" name="submit">
                    <button class="signup-btn"><a href="../pages/signuppage.php">Create an account</a></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
