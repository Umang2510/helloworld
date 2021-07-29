<?php
    require_once 'config.php';
    session_start();
    if(!isset($_SESSION['id']) && !isset($_SESSION['password'])){
        echo "<script>window.location = 'http://localhost/Helloworld/index.php';</script>";
    }
?>