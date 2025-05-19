<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/Wishlist.css">

    <style>
        h1{
            text-align: center;
            margin-top: 20px;
            font-size: 2em;
            color:  #66c0f4;
        }
    </style>
</head>

<body>

    <?php
include_once __DIR__ . "/header.php";
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../../FrontEnd/html/Member/Login.html");
        exit();
    } else {
        
        echo "<h1>$_SESSION[username]'s Wishlist</h1>";
        require_once __DIR__ . "/../../../BackEnd/connection.php";
        include("../../../BackEnd/Game/detailGame.php");
        $query = "SELECT game.game_id, game.game_name, game.game_price, wishlist.wishlist_date_added
                FROM wishlist
                JOIN game ON wishlist.game_id = game.game_id
                WHERE wishlist.user_id = '" . $_SESSION['user_id'] . "'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                showDetailGame($row['game_id'], true);
               
            }
        } else {
            echo "<p>Error retrieving wishlist items.</p>";
        }
    }

    

    ?>
</body>

</html>