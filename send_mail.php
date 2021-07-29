<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'config.php';


  function sendmail($email, $otp, $usernm, $f, $id = null)
  {
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'Place your own email';
      $mail->Password = 'Place Your email password';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('Place your own email', 'HelloWorld India');
      $mail->addAddress($email);

      $mail->isHTML(true);
      switch ($f) {
          case 1:
              $mail->Subject = 'HelloWorld registration account verification';
              $mail->Body = '<p>Namaste! Bonjour! Ciao! Willkommen! Hello!🙏' . ' ' . $usernm . ' ' . 'We\'re soo thrilled you decided to join Hello World! Hats off on making an excellent decision! <br> You are now officially in a loop to stay updated with the world events <br> Here\'s your OTP to join us:' . ' <b><h1 style="font-size: 50px; font-weight: 1000;">' . $otp . '</h1> </b>
                            If you did NOT initiate this, we highly recommend you to contact support.</p>';
              $mail->send();
              break;

          case 2:
              $mail->Subject = 'HelloWorld unique ID';
              $mail->Body = '<p>Hello!' . ' ' . $usernm . ' ' . 'Please remember this unique ID for further usage. Thank you❤ for being part of HelloWorld. Your unique ID for HelloWorld account is <b><h1 style="font-size: 30px; font-weight: 800;">' . $id . '</h1> </b></p>';
              $mail->send();
              break;

          case 3:
              $mail->Subject = 'Forgot Password | HelloWorld';
              $mail->Body = '<p>' . ' ' . $usernm . ' ' . 'Oopsies!! <br> Looks like someone derped🙄 <br> Don\'t worry we got you covered... <br> Here\'s your OTP to change the Password: ' . ' <b><h1 style="font-size: 50px; font-weight: 1000;">' . $otp . '</h1> </b>
                            If you did NOT initiate this, we highly recommend you to contact support.</p>';
              $mail->send();
              break;

          default:
              $mail->Subject = 'Please Try again | HelloWorld';
              $mail->Body = '<p>' . $usernm . '<br>Oopsies!!<br> Looks like somthing went wrong😫😔 <br> Don\'t worry Please try again... <br></p>';
              $mail->send();
      }
  }
?>
