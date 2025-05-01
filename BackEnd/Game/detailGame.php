<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    function showDetailGame($gameID)
    {
        require_once __DIR__ . '/../connection.php';

        $query = "SELECT * FROM game WHERE game_id = '" . $gameID . "'";
        $result = mysqli_query($conn, $query);
        $found = false;

        $picture_path = "../../../Assets/";
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['game_id'] == $gameID) {
                echo "<h1>" . $row['game_name'] . "</h1>";
                echo "<img src='" . $picture_path . $row['game_picture'] . "' alt='" . $row['game_name'] . "' />";
                echo "<p>Genre : " . $row['game_genre'] . "</p>";
                echo "<p>Developer : " . $row['game_developer'] . "</p>";
                echo "<p>Release Date : " . $row['game_release_date'] . "</p>";
                echo "<p>Price: " . $row['game_price'] . "</p>";
                echo "<p>Supported OS :" . $row['game_supported_os'] . "</p>";
                echo "<p>Game type : $row[game_type]</p>";
                
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "<script>alert('Game not found'); window.location.href = '../home.html';</script>";
        }
    }

    ?>
</body>

</html>