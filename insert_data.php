<?php
session_start();
require_once 'config.php';
require_once 'send_mail.php';

if(isset($_POST['otp_submit'])) {
        if ($_POST['otp_tb'] == $_SESSION['OTP']) {
                    $add_user = mysqli_query($cn, "INSERT INTO user_details (contact, email, password, usernm, role) VALUES({$_SESSION['phone']},'{$_SESSION['email']}', '{$_SESSION['password']}', '{$_SESSION['usernm_signup']}', 0)");
                    if ($add_user) {
                        $getID = mysqli_query($cn, "SELECT id,usernm FROM user_details WHERE email = '{$_SESSION['email']}' AND contact = {$_SESSION['phone']}");
                        if($getID)
                        {
                            while ($info = mysqli_fetch_assoc($getID) ){
                                $flag2 = 2;
                                sendmail($_SESSION['email'], $_SESSION['OTP'] , $info['usernm'], $flag2, $info['id']);
                            }
                        }
                        echo "<script> window.location = 'index.php';</script>";
                    } else {
                        echo "<script>alert('Please try again.'); window.location = 'http://localhost/Helloworld/sign_up.php';</script>";
                    }
            } else {
                echo "<script> alert('Enter Valid OTP.'); window.location = 'http://localhost/Helloworld/sign_up.php';</script>";
        }
}
?>