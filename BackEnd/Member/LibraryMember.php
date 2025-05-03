<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once __DIR__ . '/../connection.php';

    require_once __DIR__ . "../../../BackEnd/Game/detailGame.php";

    function showLibrary()
    {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        echo "<header><h1>". htmlspecialchars($_SESSION['username']) ."'s Library <h1></header>";



        $query = "SELECT * FROM library AS l INNER JOIN game AS g WHERE l.game_id = g.game_id AND user_id = $_SESSION[user_id];";
        $result = mysqli_query($conn, $query);
        $find = false;
        $count = 0;


        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                showDetailGame($row['game_id']);
                echo "<hr>";
            }
        } else {
            //direct ke buy game
            echo "<p>No games found in your library. <br><a href=''>Buy Games</a></p>";
        }
    }

    ?>
</body>

</html>