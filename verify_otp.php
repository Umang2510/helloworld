<?php
session_start();
require_once 'config.php';
require_once 'send_mail.php';

$n = 6;
$OTP = "";

if(isset($_POST['signup_submit'])) {

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {

        $_SESSION['usernm_signup'] = mysqli_real_escape_string($cn, $_POST['name']);
        $_SESSION['email'] = mysqli_real_escape_string($cn, $_POST['email']);
        $_SESSION['password'] = md5($_POST['password']);
        $_SESSION['phone'] = $_POST['phone'];

        $check = mysqli_query($cn, "SELECT * FROM user_details WHERE email = '{$_SESSION['email']}' OR contact = {$_SESSION['phone']}");
        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('User with this Email or Phone number is already exixst.'); window.location = 'http://localhost/Helloworld/sign_up.php';</script>";
        }
        else{
            $OTP = generateNumericOTP($n);
            $flag = 1;
            sendmail($_SESSION['email'], $OTP, $_SESSION['usernm_signup'], $flag);
            $_SESSION['OTP'] = $OTP;
        }
    }
    else{
        echo "<script>alert('Check your email Please.');</script>";
    }
}
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
        <link rel="manifest" href="site.webmanifest">
        <link rel="stylesheet" href="css/main_forms.css" type="text/css">
        <title>Verification | HelloWorld</title>
    </head>
    <body>
    <div class="signup_login">
        <form  action="insert_data.php" method="post" enctype="multipart/form-data" >
            <label for="otp">Enter OTP <em>&#x2a;</em></label>
            <input id="otp" required="" name="otp_tb" maxlength="6" pattern="[0-9]{6}" type="text" />

            <button id="submit" type="submit" name="otp_submit">Verify Account</button>
        </form>
    </div>
    <br>
    <h6 style="color:ghostwhite; margin-bottom: 1%;">
        Already have an Account? <a href="index.php" style="color: #DBA951; text-decoration: none;" >Log in</a>
    </h6>
    </body>
    </html>


<?php

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