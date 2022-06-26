<?php include "session_start.php"?>
<?php include "check_if_logged.php"?>
<?php include "db_connection.php"?>
<?php include "functions.php"?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="form.css">
    <title>Main</title>
</head>
<body>

    <?php
        if ($__db_connect->connect_error){
            $_username = NULL;
        }
        else{
            $_email = $_SESSION['email'];
            $sql_get_data = "SELECT username FROM login_info WHERE email = '$_email'";
            $result = $__db_connect->query($sql_get_data);
            $row = $result->fetch_assoc();
            $_username = $row['username'];
        }
        
    ?>

    <?php
        $delete_message = "DELETE CURRENT INFO";
        if (isset($_GET["delete_info"])){
            if ($_GET["delete_info"] == '1'){
                $sql_delete = "DELETE FROM contact_info WHERE email = '$_email'";
                if (!($__db_connect->query($sql_delete))){
                    $delete_message = "FAILED TO DELETE, TRY AGAIN LATER.";
                }
            }
        }
    ?>

    <?php
        $sql_get_data = "SELECT * FROM contact_info WHERE email='$_email'";
        $result = $__db_connect->query($sql_get_data);
        $row = $result->fetch_assoc();
        $current_firstname = $row['firstname'];
        $current_lastname = $row['lastname'];
        $current_emailform = $row['emailform'];
        $current_phone = $row['phone'];
        
    ?>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["firstname"])){
            $firstname = clean_data($_POST["firstname"]);
            $lastname = clean_data($_POST["lastname"]);
            $emailform = clean_data($_POST["emailform"]);
            $phone = clean_data($_POST["phone"]);

            if ($__db_connect->connect_error){
                $error_box = "*Failed to connect to the server";
            }
            elseif (in_array('', array($firstname, $lastname, $emailform, $phone))){
                    $error_box = "*There can't be any empty fields";
            }
            else{
                $sql_get_data = "SELECT * FROM contact_info WHERE email='$_email'";

                if (!($result = $__db_connect->query($sql_get_data))){
                    $error_box = '*Failed to connect to the server';
                }
                else{
                    if ($result->fetch_assoc() != False){
                        $sql_get_data = "UPDATE contact_info SET firstname='$firstname', lastname='$lastname', phone='$phone', emailform ='$emailform' WHERE email='$_email'";
                        if ($__db_connect->query($sql_get_data)){
                            $valid_box = "The contact info was updated";
                            $current_firstname = $firstname;
                            $current_lastname = $lastname;
                            $current_emailform = $emailform;
                            $current_phone = $phone;

                            $firstname = NULL;
                            $lastname = NULL;
                            $emailform = NULL;
                            $phone = NULL;
                        }
                        else{
                            $error_box = "Failed to connect to the server";
                        }
                    }
                    else{
                        $sql_get_data = "INSERT INTO contact_info(email, firstname, lastname, phone, emailform) VALUE ('$_email', '$firstname', '$lastname', '$phone', '$emailform')";
                        if ($__db_connect->query($sql_get_data)){
                            $valid_box = "The contact info was updated";
                            $current_firstname = $firstname;
                            $current_lastname = $lastname;
                            $current_emailform = $emailform;
                            $current_phone = $phone;

                            $firstname = NULL;
                            $lastname = NULL;
                            $emailform = NULL;
                            $phone = NULL;
                            
                        }
                        else{
                            $error_box = "Failed to connect to the server";
                        }
                    }
                }
                
            }

        }

    ?>

    <p>Username: <?php echo $_username; ?></p>
    <a href="<?php echo $_SERVER["PHP_SELF"]."?logout=1"?>">Logout</a><br>
    
    <form action="main.php" method="post" class="submission-form">
        <h3>Form Update</h3>

        <label for="name">First Name</label>
        <input type="text" id="name" name="firstname" value="<?php echo $firstname;?>">

        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" name="lastname" value="<?php echo $lastname;?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="emailform" value="<?php echo $emailform;?>">

        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone;?>">

        <input type="submit" value="SEND" id="send_btn">
        <p class="error_box"><?php echo $error_box;?> </p>
        <p class="valid_box"><?php echo $valid_box;?> </p>

    </form>

    <div class="current_info">
        <h3>Current Info</h3>

        <h4>First Name:</h2>
        <p><?php echo $current_firstname; ?></p>

        <h4>Last Name:</h4>
        <p><?php echo $current_lastname; ?></p>

        <h4>Email:</h4>
        <p><?php echo $current_emailform; ?></p>

        <h4>Phone:</h4>
        <p><?php echo $current_phone; ?></p>

        <a href="main.php?delete_info=1"><?php echo $delete_message;?> </p></a>

    </div>



</body>
</html>
