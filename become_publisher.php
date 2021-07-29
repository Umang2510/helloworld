<?php
require_once 'secure_web.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="News">
    <meta name="description" content="Become Publisher of Helloworld">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="manifest" href="site.webmanifest">
    <script src="https://kit.fontawesome.com/c7e7696453.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
    <title>Publisher | HelloWolrd</title>
</head>
<body>
<div class="signup_login">
    <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" >

        <label for="id" >ID <em>&#x2a;</em></label>
        <input id="id" name="id" required="" type="text" />

        <label for="password-field">PASSWORD <em>&#x2a;</em></label>
        <input id="password-field" maxlength="12" required="" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" type="password" />
        <div class="pass">
            <input type="checkbox" id="pass" onclick="myFunction()"><h5><label for="pass" style="font-size: 10px; line-height: 10pt;">Show Password</label></h5>
        </div>
        <br>
        <br>
        <br>
        <label for="accountno">Account NO <em>&#x2a;</em></label>
        <input id="accountno" name="accountno" required=""  type="text" />

        <label for="amount" >Amount <em>&#x2a;</em></label>
        <input id="amount" name="amount" value="1500"  readonly required="" type="text" />

        <button id="submit" type="submit" name="pay_submit">Pay Now</button>
        <br>
        <br>
    </form>
</div>
<h6 style="color:ghostwhite; margin-bottom: 1%; font-size: 15px; ">
    Or Pay Using <a href="#" style="color: #DBA951; text-decoration: none;" >Pronto India</a>
</h6>
<script src="JS/pass.js"></script>
</body>
</html>
<?php
    require_once 'config.php';

    if(isset($_POST['pay_submit']))
    {
        $id = $_POST['id'];
        $password = md5($_POST['password']);
        $getinfo = mysqli_query($cn,"SELECT * FROM user_details WHERE id = $id  AND password = '{$password}'");
        if(mysqli_affected_rows($cn)>0){
            while ($r = mysqli_fetch_assoc($getinfo)) {
                if ($r['id'] == $id && $r['password'] == $password) {
                    $alredy_pub = mysqli_query($cn, "SELECT * FROM vlid_pub WHERE id = '{$r['id']}'");
                    if (mysqli_affected_rows($cn) > 0) {
                        echo "<script>alert('Already Publisher')</script>";
                    } else{
                        $qry = mysqli_query($cn, "INSERT INTO valid_pub (id, amount, date, end_date) VALUES ({$id},{$_POST['amount']},CURRENT_TIMESTAMP() , ADDDATE(NOW(), 30))");
                        if ($qry) {
                            $update = mysqli_query($cn, "UPDATE user_details SET role = 1 WHERE id = $id");
                            if ($update) {
                                echo "<script>window.location = 'http://localhost/Helloworld/index.php';</script>";
                            } else {

                                echo "<script>alert('Please try again!.🤔');window.location = 'http://localhost/Helloworld/index.php';</script>";
                            }
                        } else {

                            echo "<script>alert('Please try again!.🤔');window.location = 'http://localhost/Helloworld/index.php';</script>";
                        }
                    }
                }
                else{
                        echo "<script>alert('ID and Password dose not match🤔! Please try again or reset password.'); window.location = 'http://localhost/Helloworld/become_pubisher.php';</script>";
                    }

            }
        }else{
            echo "<script>alert('User not found🤔! Please try again or sign up.'); window.location = 'http://localhost/Helloworld/index.php';</script>";
        }
    }
?>
