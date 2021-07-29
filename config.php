<?php
    $host='localhost';
    $user='root';
    $password='';
    $dbname='helloworld';

    $cn= mysqli_connect($host,$user,$password) or die(" <script>alert('Connection Failed.')</script> ");
    if($cn)
    {
        $selectdb=mysqli_select_db($cn,$dbname) or die(" <script>alert('Database not Found.')</script> ");
    }

?>
