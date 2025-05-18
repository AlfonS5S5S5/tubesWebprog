<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="../../css/Profile.css">
</head>

<body>


    <?php
    include_once __DIR__ . "/../Member/header.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../FrontEnd/html/Member/Login.html");
        exit();
    }
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