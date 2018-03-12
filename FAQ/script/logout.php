<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: index.php");
    }
    session_unset();
    session_destroy();
    header("Location: ../index.php");
?>