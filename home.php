<?php
require_once 'secure_web.php';
require_once 'partition_pub.php';
require_once 'config.php';
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
    <link rel="stylesheet" href="css/home.css" type="text/css">
    <title>HelloWolrd</title>
</head>
<body>
    <header>
        <div class="wrapper">
            <nav>
                <input type="checkbox" id="show-search">
                <input type="checkbox" id="show-menu">
                <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
                <div class="content">
                    <div class="logo"><a href="http://localhost/Helloworld/home.php"><img style="float: left;" src="images/helloWorld_white.png" alt="HelloWorld" height="10%" width="10%"><div class="logo_text"> HelloWorld</div></a></div>
                    <ul class="links">
                        <li style="margin-right: 2%;">
                            <a href="#" class="desktop-link"><i class="fas fa-user"></i></a>
                            <input type="checkbox" id="show-services">
                            <label for="show-services">User</label>
                            <ul>
                                <li>
                                    <a href="show-img.php">
                                        <?php
                                        // Include the database configuration file
                                        require_once 'config.php';

                                        // Get image data from database
                                        $getimage = mysqli_query($cn, "SELECT photo FROM user_details WHERE id = {$_SESSION['id']}");
                                        if(mysqli_affected_rows($cn) > 0) {
                                            while ($img = mysqli_fetch_assoc($getimage)) {
                                               if($img['photo'] != '') {
                                                   echo "<img src = 'user_profile/" . $img['photo'] . "' alt='img' height = '50px' width = '50px' style = 'border-radius : 50%;'>";
                                               }else{
                                                   echo "<img src='images/user.png' alt='User' height='50px' width='50px' style='border-radius: 50%;' />";

                                               }
                                            }
                                        }?><?php echo "<br>"; echo $_SESSION['usernm'] ." "."ID:". $_SESSION['id']; ?>
                                    </a>
                                </li>
                                <li><a href="update_info.php">Update info</a></li>
                                <li><a href="DP.php">Profile Picture</a></li>
                                <li><a href="DP.php">Remove Profile picture</a></li>
                                <li><a href="log_out.php">Log out</a></li>
                                <li><a href="delete_user.php">Delete Account</a> </li>

                            </ul>
                        </li>
                        <li><a href="home.php">Home</a></li>

                        <li>
                            <a href="#" class="desktop-link">Category</a>
                            <input type="checkbox" id="show-features">
                            <label for="show-features">Category</label>
                            <ul>
                                <li><a href="science&technology.php">Science & Technology</a></li>
                                <li><a href="entertainment.php">Entertainment</a></li>
                                <li><a href="sports.php">Sports</a></li>
                                <li><a href="lifestyle.php">Lifestyle</a></li>
                                <li><a href="politics.php">Politics</a></li>
                                <li><a href="business.php">Business</a></li>
                                <li><a href="food.php">Food</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="desktop-link">Translate</a>
                            <input type="checkbox" id="show-items">
                            <label for="show-items">Translate</label>
                            <ul><li><a href="#"><div id="google_translate_element"></div></a></li></ul>
                        </li>
                        <li>
                            <a href="become_publisher.php" >Publisher</a>
                        </li>
                    </ul>
                </div>
                <label for="show-search" class="search-icon"><i class="fas fa-search"></i></label>
                <form action="search.php" class="search-box" method="get">
                    <input type="text" placeholder="Type title..." name = "search" required>
                    <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
                </form>
            </nav>
        </div>
    </header>
    <div class='main-container'>

        <?php
        $getpost = mysqli_query($cn, "SELECT * FROM article");
        if(mysqli_affected_rows($cn)>0){
            while ($post = mysqli_fetch_assoc($getpost)){
                ?>

                <div class='post'>
                    <a href="full_view.php?a_id=<?php echo $post['a_id'];?>">
                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($post['media']); ?>" />
                        <div class='text'>
                            <h2><?php echo $post['title'];?></h2>
                            <h4><?php echo $post['description'];?></h4>
                        </div>
                        <div class='post-info' >
                            <i class='fas fa-user'>
                                <?php
                                $getnm = mysqli_query($cn,"SELECT usernm FROM user_details JOIN article ON user_details.id = {$post['id']}");
                                if($getnm){
                                    while($nm = mysqli_fetch_assoc($getnm)) {
                                        echo $nm['usernm'];
                                        break;
                                    }}
                                ?>
                            </i>
                            <i class='fas fa-calendar-week'><?php echo $post['post_date'];?></i>
                            <i class="fas fa-map-marker-alt"><?php echo $post['location'];?></i>
                        </div>
                    </a>
                </div>

            <?php }
        }else{
            echo "Not data";
        }
        ?>

    </div>
    <footer>
        <i class="fab fa-blogger-b"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-instagram"></i>
        <i class="fab fa-facebook-f"></i>
        <i><a href="feedback.php">Feedback</a></i>

    </footer>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>

