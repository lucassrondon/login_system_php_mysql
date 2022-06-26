<?php
    if (isset($_GET["logout"])){
        if ($_GET["logout"] == '1'){
            $_SESSION["logged"] = False;
            $_SESSION["email"] = False;
            header("Location: login.php");
        }
    }

    if ($_SESSION["logged"] == False){
        header("Location: login.php");
    }
?>
