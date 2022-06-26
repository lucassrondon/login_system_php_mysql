<?php include "session_start.php"?>
<?php include "db_connection.php"?>
<?php include "functions.php"?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Login</title>
</head>

<body>
    <?php
        if ($_SESSION["logged"] == True){
            header("Location: main.php");
        }
        elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = clean_data($_POST["email"]);
            $password = clean_data($_POST["password"]);

            if (log_in($__db_connect, $email, $password)){
                $_SESSION["logged"] = True;
                $_SESSION["email"] = $email;
                header("Location: main.php");
            }
            else{
                $failed_to_login = "*Incorrect email or password";
            }

        }
    ?>

    <div class="form_box">

        <h3>SIGN IN</h3>

        <form action="login.php" method="post">

            <p>Email</p>
            <input type="text" name="email" placeholder="Enter Email">

            <p>Password</p>
            <input type="password" name="password" placeholder="password"><br>

            <div id="errorbox"><?php echo $failed_to_login;?></div><br>

            <input type="submit" name="" value="SIGN IN"><br><br>
            <a href="sign_up.php" class="login_button">NO ACCOUNT YET? SIGN UP</a>


        </form>
    </div>
    
</body>
</html>
