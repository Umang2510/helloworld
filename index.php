<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="News">
    <meta name="description" content="Log in HelloWorld.">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="manifest" href="site.webmanifest">
    <title>Log in | HelloWorld</title>
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
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

        <button id="submit" type="submit" name="login_submit">Log in</button>
    </form>

</div>
<h5><a href="forgot_pass.php"  style="color: #DBA951;">Forgot Password?</a></h5>

<h5 style="color: ghostwhite;">
    Not registered yet? <a href="sign_up.php" style="color: #DBA951; text-decoration: none;" >Sign Up for free.</a>
</h5>
<br><br>
<h5 style="color: ghostwhite;">
    <a href="ADMIN/index.php" style="color: #DBA951; text-decoration: none;" >Admin login here</a>
</h5>
<script src="JS/pass.js"></script>
</body>
</html>
<?php
    require_once 'config.php';
    if(isset($_POST['login_submit'])){
        $id = $_POST['id'];
        $password = md5($_POST['password']);
        $getinfo = mysqli_query($cn,"SELECT * FROM user_details WHERE id = $id  AND password = '{$password}'");
        if(mysqli_affected_rows($cn)>0){
            while ($r = mysqli_fetch_assoc($getinfo)){
                if($r['id'] == $id && $r['password'] == $password) {
                    $_SESSION['id'] = $r['id'];
                    $_SESSION['usernm'] = $r['usernm'];
                    $_SESSION['role'] = $r['role'];
                    mysqli_query($cn, "DELETE FROM verification WHERE id = {$r['id']}");
                    if($r['role'] == 1){
                        $add_cur_date = mysqli_query($cn,"UPDATE valid_pub SET cur_date = CURRENT_TIMESTAMP() WHERE id = '{$_SESSION['id']}'");
                        $getdate = mysqli_query($cn, "SELECT end_date, cur_date FROM valid_pub WHERE id = '{$_SESSION['id']}'");
                        if(mysqli_affected_rows($cn)>0){
                            while ($check = mysqli_fetch_assoc($getdate)){
                                $cur_date = strtotime($check['cur_date']);
                                $end_date = strtotime($check['end_date']);
                                if($cur_date > $end_date){
                                    $not_pub = mysqli_query($cn, "UPDATE user_details SET role = 0 WHERE id = '{$_SESSION['id']}'");
                                    $del_vlid_pub = mysqli_query($cn, "DELETE FROM valid_pub WHERE id = '{$_SESSION['id']}' ");
                                    echo "<script>alert('Your one month subscription is over!');window.location = 'http://localhost/Helloworld/become_publisher.php';</script>";
                                }
                                else{
                                    echo "<script>window.location = 'http://localhost/Helloworld/Publisher/home.php';</script>";
                                }
                            }
                        }
                }
                    else {
                        echo "<script>window.location = 'http://localhost/Helloworld/home.php';</script>";
                    }
                }
                else{
                    echo "<script>alert('ID and Password dose not match🤔! Please try again or reset password.'); window.location = 'http://localhost/Helloworld/index.php';</script>";
                }
            }
        }else{
            echo "<script>alert('User not found🤔! Please try again or sign up.'); window.location = 'http://localhost/Helloworld/index.php';</script>";
        }
    }
?>