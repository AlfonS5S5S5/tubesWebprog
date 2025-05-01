<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>Game Detail</header>
    <link rel="stylesheet" type="text/css" href="../../css/game.css">
    <div class="game-detail">
        <?php
            include("../../../BackEnd/Game/detailGame.php");
            showDetailGame(9);
        ?>
    </div>
</body>
</html>