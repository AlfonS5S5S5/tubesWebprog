<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../css/Wishlist.css">
</head>
<body>
    <?php
        
        include_once __DIR__ . "/header.php";
        include_once __DIR__ . "/../../../BackEnd/connection.php";
        include_once __DIR__ . "/../../../BackEnd/Game/detailGame.php";

        if (isset($_POST['game_id'])) {
            $gameId = $_POST['game_id'];
            echo "<h1>Comments</h1>";
            showGameComment($gameId);
        } else {
            echo "<p>Error: Game ID not provided.</p>";
        }
    ?>
</body>
</html>