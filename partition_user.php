<?php
require_once 'config.php';
if($_SESSION['role'] == 0){
    session_unset();
    session_destroy();
    echo "<script>window.location = 'http://localhost/Helloworld/index.php';</script>";
}
?>