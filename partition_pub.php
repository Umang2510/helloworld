<?php
if($_SESSION['role'] == 1){
    session_unset();
    session_destroy();
    echo "<script>window.location = 'http://localhost/Helloworld/index.php';</script>";
}
?>