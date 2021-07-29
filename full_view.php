<?php
    require_once 'secure_web.php';
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
    <link rel="stylesheet" href="css/full_view.css" type="text/css">
    <title>HelloWolrd</title>
</head>
<body>
<div class="container">
<?php
        $getfullpost = mysqli_query($cn,"SELECT * FROM article WHERE a_id ={$_GET['a_id']}");
        if($getfullpost) {
            while ($post = mysqli_fetch_assoc($getfullpost)) {
                ?>
                <div class="title">
                <h2><?php echo $post['title']; ?></h2>
                </div>
                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($post['media']); ?>" />
                <div class="content">
                <h5><?php echo $post['description']; ?></h5>
                </div><br>
                <div class="Post-info">
                    <i class='fas fa-user'>
                <?php
                $getnm = mysqli_query($cn,"SELECT usernm FROM user_details JOIN article ON user_details.id = {$post['id']}");
                if($getnm){
                while($nm = mysqli_fetch_assoc($getnm)) {
                echo $nm['usernm'];
                break;
                }}?></i>
                    <i class='fas fa-calendar-week'><?php echo $post['post_date'];?></i>
                    <i class="fas fa-map-marker-alt"><?php echo $post['location'];?></i>
                </div>
                <br><br>
                <br>
                <div class="button">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post"><button type="submit" name="report"><i class="far fa-flag"></i>Report</button></form>
                    <button onclick="copyToClipboard()"><i class="fas fa-share-alt"></i>Share</button>
                </div>
                <?php
            }
        }else{
            echo mysqli_error($cn);
        }
?>
</div>
<hr>
<div class="signup_login">
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <textarea  name="cmt" required="" rows="3" placeholder="Write your comment..."></textarea>
        <br><br>
        <button id="submit" type="submit" name="post_cmt">Add comment</button>
    </form>
</div>
<?php
if(isset($_POST['post_cmt'])){
    $cmt = mysqli_real_escape_string($cn, $_POST['cmt']);
    $add_cmt = mysqli_query($cn, "INSERT INTO comment (text, a_id, u_id, c_date) VAlUES('{$cmt}',{$_GET['a_id']},{$_SESSION['id']},NOW())");
    }
?>
<div class="comment">
<?php
    $get_cmt = mysqli_query($cn, "SELECT * FROM comment WHERE a_id = {$_GET['a_id']}");
    if(mysqli_affected_rows($cn)>0){
        while ($disp_cmt = mysqli_fetch_assoc($get_cmt)){
            $getnm = mysqli_query($cn,"SELECT usernm FROM user_details JOIN comment ON user_details.id = {$disp_cmt['u_id']}");
            if($getnm){
                while($nm = mysqli_fetch_assoc($getnm)){
                    ?>
                    <div class="cmt_info">
                    <h2 class="user"><?php echo $nm['usernm']; ?></h2>&nbsp;<h3 class="date"><?php echo $disp_cmt['c_date'];?></h3>
                    </div>
                    <h3 class="cmt"><?php echo $disp_cmt['text']; ?></h3><hr>
               <?php
                break;}
            }

        }
    }
?>
    <?php
        if(isset($_POST['report'])){
            $add_report = mysqli_query($cn,"INSERT INTO report (u_id, a_id) VALUES ({$_SESSION['id']}, {$_GET['a_id']})");
            if($add_report){
                echo "<script>alert('Reported successfully.');</script>";
            }
            else{
                echo "<script>alert('Please try again!');</script>";
            }
        }
    ?>
</div>
<script>
    function copyToClipboard(text) {
        var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value = window.location.href;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);
        alert("URL Copied.");
    }
</script>
</body>
</html>
