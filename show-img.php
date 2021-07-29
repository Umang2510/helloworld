<?php
    require_once 'secure_web.php';
?>
<html>
<head>
    <title>
        <?php echo $_SESSION['usernm'];?>
    </title>
</head>
<body>
<?php
// Include the database configuration file
require_once 'Config.php';

// Get image data from database
$getimage = mysqli_query($cn, "SELECT photo FROM user_details WHERE id = {$_SESSION['id']}");
if(mysqli_affected_rows($cn) > 0) {
    while ($img = mysqli_fetch_assoc($getimage)) {
        if($img['photo'] != '') {
            echo "<center>";
            echo "<img src = 'user_profile/" . $img['photo'] . "' alt='img' height = '90%' width = '60%' >";
            echo "<center>";
        }else{
            echo "<center>";
            echo "<img src='images/user.png' alt='User' height = '80%' width = '50%' />";
            echo "<center>";

        }
    }
}
?>
</body>
</html>