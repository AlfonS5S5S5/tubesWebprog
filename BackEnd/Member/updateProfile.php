<?php
    if (session_start() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . "/../connection.php";

    if (!isset($_POST['submit'])) {
        echo "Invalid form submit";
        header("Location: ../../FrontEnd/html/Member/Profile.php");
        exit();
    }

    if(!isset($_SESSION['user_id'])) {
        header("Location: ../../FrontEnd/html/Member/Login.html");
        exit();
    }

    if (!isset($_FILES['pfp']) ) {
        echo "Please select an image file.";
        exit();
    }

    $userID = $_SESSION['user_id'];
    $image = $_FILES['pfp'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    $dir = __DIR__ . "/../../Images/userProfile/";
    $fileName = $image["name"];
    $targetFile = $dir . $fileName;
    $path = "Images/userProfile/" . $fileName;

    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        $query = "UPDATE users SET user_profile_picture = '$path' WHERE user_id = $userID";
        if (mysqli_query($conn, $query)) {
            echo "successfully updated profile .";
            header("Location: ../../FrontEnd/html/Member/HomePage.php");
        } else {
            echo "failed to update profile: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload file.";
    }
    
    mysqli_close($conn);
?>