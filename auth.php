<?php
    session_start();
    if(!isset($_SESSION["email"])) {
        header("Location: https://gismat.alwaysdata.net/back_end/crowdfunding/login.php");
        exit();
    }
?>