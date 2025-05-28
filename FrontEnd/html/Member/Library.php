<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/Library.css">
</head>

<body>
    <?php
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../FrontEnd/html/Member/Login.html");
        exit();
    }
    include_once 'header.php';
    include("../../../BackEnd/Member/LibraryMember.php");

    showLibrary();
    include_once 'footer.html';
    ?>
</body>

</html>