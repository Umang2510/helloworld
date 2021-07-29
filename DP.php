<?php
include 'secure_web.php';
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
        <title>Profile Picture | HelloWolrd</title>
</head>
<body>
<div class="signup_login">
    <form  action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
        <label class="file" for="file" >Choose image for Profile picture</label>
        <input  type="file" accept="image/*" id="file" name="imgToUpload" />
        <div id="file-upload-filename"></div>
        <br>
        <br>
        <button id="submit" type="submit" name="Upload_image"><i style="padding-right:5px; " class="fas fa-cloud-upload-alt"></i>Upload</button>
    </form>
    <br><br><br><br>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <button id="submit" type="submit" name="remove_dp"><i style="padding-right:5px; "  class="fas fa-trash"></i>Remove Profile picture</button>
    </form>
</div>
<script src="JS/file_choose_nm.js"></script>
</body>
</html>
<?php
    require_once 'config.php';
    if(isset($_POST["Upload_image"])){
        if(!empty($_FILES["imgToUpload"]["name"])) {
            // Get file info
            $fileName = basename($_FILES["imgToUpload"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $size = $_FILES['imgToUpload']['size'];
            $folder = 'user_profile/';
            $rename = $_SESSION['id'] . '.' .$fileType;
            $tempname = $_FILES["imgToUpload"]["tmp_name"];

            if($size <= 5242880)
            {
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif', 'JPG', 'JPEG', 'PNG', 'GIF');
            if(in_array($fileType, $allowTypes)) {
                if(move_uploaded_file($tempname,$folder.$rename))
                {
                  $uploaded = mysqli_query($cn, "UPDATE user_details SET  photo = '{$rename}' WHERE id = {$_SESSION['id']}");
                  if($uploaded){
                      echo "<script>alert('File uploaded successfully🎉.'); window.location = 'http://localhost/Helloworld/home.php';</script>";
                  }else{
                      echo "<script>alert('File not uploaded! Please try again.😟'); window.location = 'http://localhost/Helloworld/DP.php';</script>";
                  }
                }else{
                    echo "<script>alert('File not uploaded! Please try again.😑'); window.location = 'http://localhost/Helloworld/DP.php';</script>";
                }
                }else{
                echo "<script>alert('Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.🤷‍♂️'); window.location = 'http://localhost/Helloworld/DP.php';</script>";
            }
            }else{
                echo "<script>alert('Sorry, only files with size 5MB or lesser are allowed to upload.😔'); window.location = 'http://localhost/Helloworld/DP.php';</script>";
            }
        }else{
            echo "<script>alert('Please select an image file to upload.🤷‍♀️'); window.location = 'http://localhost/Helloworld/DP.php';</script>";
        }
    }

    elseif(isset($_POST['remove_dp'])){
        $del = mysqli_query($cn, "UPDATE user_details SET photo = '' WHERE id = {$_SESSION['id']}");
        if($del){
            echo "<script>window.location = 'http://localhost/Helloworld/home.php';</script>";
        }
        else{
            echo "<script>alert('Please log out than try again.😕 ');window.location = 'http://localhost/Helloworld/DP.php';</script>";
        }
    }
?>
