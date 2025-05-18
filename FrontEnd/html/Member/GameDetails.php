<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../css/Wishlist.css">
</head>

<body>

    <div class="comment-section">
        <?php
        include_once __DIR__ . "/header.php";

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../../FrontEnd/html/Member/Login.html");
            exit();
        }
        
        include_once __DIR__ . "/../../../BackEnd/connection.php";
        include_once __DIR__ . "/../../../BackEnd/Game/detailGame.php";
        
        if (isset($_POST['game_id'])) {

            $gameId = $_POST['game_id'];
        
            include __DIR__ . "/comment.php";
        } else {
            echo "<p>Error: Game ID tidak ada.</p>";
        }
        
        if (isset($_POST['game_id'])) {
            $gameId = $_POST['game_id'];
            echo "<h1>Comments</h1>";
            echo "<style>
                h1{
                    color: #fff;
                    font-size: 30px;
                    margin-left: 65px;
                }
            </style>";
            showGameComment($gameId);
        } else {
            echo "<p>Error: Game ID tidak ada.</p>";
        }
        ?>

</body>

</html>