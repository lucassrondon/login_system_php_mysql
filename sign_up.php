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
    <title>Sign Up</title>
</head>

<body>
    <?php
        if ($_SESSION["logged"] == True){
            header("Location: main.php");
        }
        elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
            $email = clean_data($_POST["email"]);
            $username = clean_data($_POST["username"]);
            $password = clean_data($_POST["password"]);

            if ($email == ""){
                $not_valid = "*Email can't be empty";
            }
            elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == False){
                $not_valid = "*The informed email isn't valid";
            }
            elseif (email_exists($__db_connect, $email)){
                $not_valid = "*The informed email is already being used";
            }
            elseif (strlen($username) < 6){
                $not_valid = "*The username must have at least 6 characters";
            }
            elseif (username_exists($__db_connect, $username)){
                $not_valid = "*The informed username is already being used";
            }
            elseif (strlen($password) < 8){
                $not_valid = "*The password must have at least 8 characters";
            }
            elseif ($__db_connect->connect_error == True){
                    $not_valid = "Failed to create user. Please, try again.";
            }
            else{
                $sql_insertion_setup = "INSERT INTO login_info(email, username, password) VALUE ('$email', '$username', '$password')";
                $email = NULL;
                $username = NULL;

                if ($__db_connect->query($sql_insertion_setup)){
                    $valid = "User created, you may Sign In.";
                }
                else{
                    $not_valid = "Failed to create user. Please, try again.";
                }
            }   
        }
        

    ?>

    <div class="form_box">

        <h3>SIGN UP</h3>

        <form action="sign_up.php" method="post">

            <p>Email</p>
            <input type="text" name="email" placeholder="Enter Email" value="<?php echo $email;?>">

            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username" value="<?php echo $username;?>">

            <p>Password</p>
            <input type="password" name="password" placeholder="password"><br>

            <div class="error_box"><?php echo $not_valid;?></div><br>
            <div class="valid_box"><?php echo $valid; ?></div><br>

            <input type="submit" name="submit" value="SIGN UP"><br><br>
            <a href="login.php" class="login_button">SIGN IN</a>
            

        </form>
    </div>
    
</body>
</html>
