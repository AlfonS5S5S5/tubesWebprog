<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="../../css/Profile.css">
</head>

<body>
    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../Member/Login.html");
        exit();
    }
    ?>


    <?php
    include_once 'header.php';
    ?>

    <form method="post" action="../../../BackEnd/Member/updateProfile.php" enctype="multipart/form-data">
        <h1>Profile</h1>
        <div class="profile-section">
            <label for="pfp">Profile Picture</label>
            <input type="file" id="pfp" name="pfp" accept="image/*">
        </div>
        <button type="submit" name="submit">Update Profile</button>
    </form>

    <?php
        include_once 'footer.html';
    ?>
</body>

</html>