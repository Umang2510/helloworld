<?php
    require_once 'secure_web.php';
    require_once 'config.php';
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
    <title>Delete Account | HelloWorld</title>
</head>
<body>
<div class="signup_login">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" >

        <label for="ID">ID <em>&#x2a;</em></label>
        <input id="ID" name="id" required="" pattern="[0-9].{0,}" type="text" title="Only numbers are allowed.Enter your unique ID generated at Sign up time." maxlength="10"/>

        <label for="password-field">PASSWORD <em>&#x2a;</em></label>
        <input id="password-field" required="" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" type="password" />
        <div class="pass">
            <input type="checkbox" id="pass" onclick="myFunction()"><h5><label for="pass" style="font-size: 10px; line-height: 10pt;">Show Password</label></h5>
        </div>
        <br>
        <br>

        <button id="submit" type="submit" name="delete">DELETE</button>
    </form>

</div>
<script src="JS/pass.js"></script>
</body>
</html>
<?php

if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    $password = md5($_POST['password']);
    $getinfo = mysqli_query($cn, "SELECT * FROM user_details WHERE id = $id  AND password = '{$password}'");
    if (mysqli_affected_rows($cn) > 0) {
        $get_img = mysqli_query($cn, "SELECT photo FROM user_details WHERE id = {$_SESSION['id']}");
        while ($img = mysqli_fetch_assoc($get_img)) {
            $folder = 'user_profile/';
            $del_img = $folder . $img['photo'];
            unlink($del_img);
        }
        $del_cmt = mysqli_query($cn, "DELETE FROM comment WHERE id = {$_SESSION['id']}");
        $del_post = mysqli_query($cn, "DELETE FROM article WHERE id = {$_SESSION['id']}");
        $del_pub = mysqli_query($cn, "DELETE FROM valid_pub WHERE id = {$_SESSION['id']}");
        $del_user = mysqli_query($cn, "DELETE FROM user_details WHERE id = {$_SESSION['id']}");


        session_unset();
        session_destroy();
        echo "<script>window.location = 'http://localhost/Helloworld/index.php';</script>";
    }
}
?>