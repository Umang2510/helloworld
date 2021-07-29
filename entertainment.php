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
    <link rel="stylesheet" href="css/home.css" type="text/css">
    <title>Entertainment | HelloWolrd</title>
</head>
<body>
<div class='main-container'><?php
require_once 'secure_web.php';
require_once 'config.php';
$getpost = mysqli_query($cn, "SELECT * FROM article WHERE category = 'Entertainment'");
if(mysqli_affected_rows($cn)>0){
    while ($post = mysqli_fetch_assoc($getpost)){
        ?>

        <div class='post'>
            <img class='article-img' src='images/sign_up.jpg'>
            <div class='text'>
                <h2><?php echo $post['title'];?></h2>
                <h4><?php echo $post['description'];?></h4>
            </div>
            <div class='post-info' >
                <i class='fas fa-user'>Admin</i>
                <i class='fas fa-calendar-week'><?php echo $post['post_date'];?></i>
                <i class='fas fa-user-times'></i>
            </div>
        </div>
    <?php }
}else{
    echo "Not data";
}
?>
</div>
</body>
</html>