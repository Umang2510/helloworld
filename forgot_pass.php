<?php

session_start();
require_once 'config.php';
require_once 'send_mail.php';

$n = 6;
$nm = "";
$newps = "";
$id = "";
$OTP_forgot = "";
$e_mail = "";

function generateNumericOTP($n) {

    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }

    // Return result
    return $result;

}

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot password | HelloWorld</title>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
</head>
<body>
<div class="signup_login">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

        <label for="ID">ID <em>&#x2a;</em></label>
        <input id="ID" name="id" required="" pattern="[0-9].{0,}" type="text" title="Only numbers are allowed.Enter your unique ID generated at Sign up time." maxlength="10"/>

        <label for="password-field">NEW PASSWORD <em>&#x2a;</em></label>
        <input id="password-field" required="" name="n_password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" type="password" />
        <div class="pass">
            <input type="checkbox" id="pass" onclick="myFunction()"><h5><label for="pass" style="font-size: 10px; line-height: 10pt;">Show Password</label></h5>
        </div><br><br><br>

        <button  type="submit" name="forgot_submit">SUBMIT</button><br><br>
        </form>

        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            <label for="otp">Enter OTP <em>&#x2a;</em></label>
            <input id="otp" required="" name="otp_forgot" maxlength="6" pattern="[0-9]{6}" type="text" />
            <button  type="submit" name="forgot_submit_OTP">SUBMIT OTP</button>
        </form>
</div>
<script src="JS/pass.js"></script>
</body>
</html>
<?php

if(isset($_POST['forgot_submit'])){

    $getinfo = mysqli_query($cn, "SELECT email, usernm FROM user_details WHERE id = {$_POST['id']}");
    if(mysqli_affected_rows($cn)>0){
        $OTP_forgot = generateNumericOTP($n);
        $_SESSION['newps'] = md5($_POST['n_password']);
        $_SESSION['id_forgot'] = $_POST['id'];
        $id = $_POST['id'];

        while ($info = mysqli_fetch_assoc($getinfo)){
            $nm = $info['usernm'];
            $_SESSION['e_mail'] = $info['email'];
            $e_mail = $info['email'];

            $flag3 = 3;
            sendmail($info['email'], $OTP_forgot , $info['usernm'], $flag3);
            $alredy_data = mysqli_query($cn, "SELECT * FROM verification WHERE  email = '{$e_mail}' AND id = $id");
            if(mysqli_affected_rows($cn)>0){
                mysqli_query($cn, "DELETE FROM verification WHERE email = '{$e_mail}' AND id = $id");
                mysqli_query($cn,"INSERT INTO verification (email, id, otp) VALUES ('{$e_mail}', $id, $OTP_forgot) ");
            }
            else{
                mysqli_query($cn,"INSERT INTO verification (email, id, otp) VALUES ('{$e_mail}', $id, $OTP_forgot) ");
            }

        }
    }
    else{
        echo "<script>alert('User not found! Please. Try again.');  window.location = 'http://localhost/Helloworld/forgot_pass.php';</script>";
    }

}
elseif(isset($_POST['forgot_submit_OTP'])){
    $id = $_SESSION['id_forgot'];
    $e_mail = $_SESSION['e_mail'];
    $newps = $_SESSION['newps'];

    $get_otp = mysqli_query($cn, "SELECT * FROM verification WHERE id = {$id}");

    while ($db_otp = mysqli_fetch_assoc($get_otp)) {
               if($db_otp['otp'] == $_POST['otp_forgot']) {
                   $update = mysqli_query($cn, "UPDATE user_details SET password = '{$newps}' WHERE id = $id AND email = '{$db_otp['email']}'");
                   if ($update) {
                       echo "<script>alert('Password updated successfully'); window.location = 'index.php';</script>";

                   } else {
                       echo "<script>alert('Please. Try again.');  window.location = 'http://localhost/Helloworld/forgot_pass.php';</script>";
                   }
               }
               else{
                    echo "<script>alert('Enter valid OTP. Please. Try again.');  window.location = 'http://localhost/Helloworld/forgot_pass.php';</script>";
               }
           }
}
session_unset()

?>