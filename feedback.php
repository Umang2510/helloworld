<?php
require_once "secure_web.php";
require_once "config.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="News">
    <meta name="description" content="HelloWorld news Website.">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="manifest" href="site.webmanifest">
    <script src="https://kit.fontawesome.com/c7e7696453.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
    <title>Feedback | HelloWolrd</title>
</head>
<body>
<div class="signup_login">
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

        <textarea  name="feedback" required="" rows="3" placeholder="Write your comment..."></textarea>
        <br><br>
        <button  type="submit" name="feedback_submit">SUBMIT</button><br><br>
    </form>
</body>
</html>
<?php
    if(isset($_POST['feedback_submit'])){
        $name = "";
        $text = mysqli_real_escape_string($cn,$_POST['feedback']);
        $getnm = mysqli_query($cn,"SELECT usernm FROM user_details WHERE id = {$_SESSION['id']}");
        if(mysqli_affected_rows($cn)>0){
            while ($nm = mysqli_fetch_assoc($getnm)){
                $name = $nm['usernm'];
            }
        }
        $add = mysqli_query($cn,"INSERT INTO feedback (id, name, text) VALUES ({$_SESSION['id']}, '{$name}', '{$text}')");
        if($add){
            echo "<script>alert('Feedback submitted');</script>";
        }
        else{
            echo "<script>alert('Please! Try again.')</script>";
        }
    }
?>