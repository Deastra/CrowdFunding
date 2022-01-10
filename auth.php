<?php
    session_start();
    if(!isset($_SESSION["email"])) {
        header("Location: login.php"); // Should be the link of the login page!!! (with https://link, not the local!!)
        exit();
    }
?>