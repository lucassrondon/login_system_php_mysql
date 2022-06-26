<?php
session_start();
$_SESSION['logged'] = $_SESSION['logged'] ?? False;
$_SESSION['email'] = $_SESSION['email'] ?? False;
?>
