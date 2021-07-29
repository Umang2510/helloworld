<?php
require_once 'secure_web.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="News">
    <meta name="description" content="Update User information">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="manifest" href="site.webmanifest">
    <script src="https://kit.fontawesome.com/c7e7696453.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
    <title>Update user information | HelloWolrd</title>
</head>
<body>
<div class="signup_login">
    <form  action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >

        <label for="ID" >ID <em>&#x2a;</em></label>
        <input id="ID" name="ID" required="" type="text" />

        <label for="password-field">PASSWORD <em>&#x2a;</em></label>
        <input id="password-field" maxlength="12" required="" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" type="password" />
        <div class="pass">
            <input type="checkbox" id="pass" onclick="myFunction()"><h5><label for="pass" style="font-size: 10px; line-height: 10pt;">Show Password</label></h5>
        </div>
        <br><br><br>

        <h3 style="font-style: normal;">These information you can update</h3>
        <label for="Name" >NAME <em>&#x2a;</em></label>
        <input id="Name" name="name" required="" type="text" />

        <label for="Email">EMAIL <em>&#x2a;</em></label>
        <input id="Email" name="email" required="" type="email" />

        <label for="Phone">PHONE <em>&#x2a;</em></label>
        <input id="Phone" name="phone" required="" pattern="[0-9]{10}" title="Enter 10 Digit number and Only numbers are allowed." maxlength="10" type="tel" />


        <button id="submit" type="submit" name="update">Update</button>

    </form>
</div>
<script src="JS/pass.js"></script>
</body>
</html>

<?php
    if(isset($_POST['update'])) {
        $id = $_POST['ID'];
        $password = md5($_POST['password']);
        $getinfo = mysqli_query($cn, "SELECT * FROM user_details WHERE id = $id  AND password = '{$password}'");
        if (mysqli_affected_rows($cn) > 0) {
            while ($r = mysqli_fetch_assoc($getinfo)) {
                if ($r['id'] == $id && $r['password'] == $password) {
                    $getexist = mysqli_query($cn, "SELECT * FROM user_details WHERE email = '{$_POST['email']}' AND contact = {$_POST['phone']}");
                    if(mysqli_affected_rows($cn)>0){
                        echo "<script>alert('User with this email or phone is already exist.');</script>";
                    }else {
                        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                            $update = mysqli_query($cn, "UPDATE user_details SET contact = {$_POST['phone']}, email = '{$_POST['email']}', usernm = '{$_POST['name']}' WHERE id = {$_POST['ID']}");
                            if ($update) {
                                session_unset();
                                session_destroy();
                                echo "<script>alert('Information updated successfully.🤩');window.location = 'http://localhost/Helloworld/index.php';</script>";
                            } else {
                                echo "<script>alert('Looks like something goes wrong.Please try again.😥');</script>";
                            }
                        }else{
                            echo "<script>alert('Check your email Please.');</script>";
                        }
                    }
                }else{
                    echo "<script>alert('Password or ID does not match.🤔');</script>";
                }
            }
        }else{
            echo "<script>alert('User not found.🤔');</script>";
        }
    }

?>