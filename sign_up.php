<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="News">
    <meta name="description" content="Sign up in HelloWorld.">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="manifest" href="site.webmanifest">
    <title>Sign Up | HelloWorld</title>
    <link rel="stylesheet" href="css/main_forms.css" type="text/css">
</head>
<body>
        <div class="signup_login">
        <form  action="verify_otp.php" method="post" enctype="multipart/form-data" >

            <label for="Name" >NAME <em>&#x2a;</em></label>
            <input id="Name" name="name" required="" type="text" />

            <label for="Email">EMAIL <em>&#x2a;</em></label>
            <input id="Email" name="email" required="" type="email" />

            <label for="Phone">PHONE <em>&#x2a;</em></label>
            <input id="Phone" name="phone" required="" pattern="[0-9]{10}" title="Enter 10 Digit number and Only numbers are allowed." maxlength="10" type="tel" />

            <label for="password-field">PASSWORD <em>&#x2a;</em></label>
            <input id="password-field" maxlength="12" required="" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" type="password" />
            <div class="pass">
                <input type="checkbox" id="pass" onclick="myFunction()"><h5><label for="pass" style="font-size: 10px; line-height: 10pt;">Show Password</label></h5>
            </div>
            <br>
            <br>
            <button id="submit" type="submit" name="signup_submit">SUBMIT</button>
            <br>
            <br>
        </form>
        </div>
        <h6 style="color:ghostwhite; margin-bottom: 1%;">
            Already have an Account? <a href="index.php" style="color: #DBA951; text-decoration: none;" >Log in</a>
        </h6>
        <script src="JS/pass.js"></script>
</body>
</html>
