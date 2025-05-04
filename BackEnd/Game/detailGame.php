<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href='HomePage.html'>
        <button>
            Back
        </button>
    </a>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../connection.php';
    if(isset($_POST['submit_detail'])){
        $gameID = $_POST['game_id'];
        showDetailGame($gameID);
    } 
    function showDetailGame($gameID)
    {
        global $conn;

        $query = "SELECT * FROM game WHERE game_id = '" . $gameID . "'";    
        $result = mysqli_query($conn, $query);
        $found = false;

        $picture_path = isset($_POST['submit_detail']) ? "../../Assets/":"../../../Assets/";
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
                //if user have a session
                if (isset($_SESSION['user_id'])) {
                    if (getPurchasedStatus($conn, $gameID, $_SESSION['user_id'])) {
                        echo "<a href=''><button>Play Game</button></a>";
                    } else {
                        echo "<p>Status : <b>BUY GAME</b></p>";
                        echo "<form method='post' action='purchaseGame.php'>";
                        echo "<input type='submit' name='purchase' value='BUY GAME' style='width:100px;'>";
                        echo "</form>";
                    } 
                }
                else {
                    echo "login";
                }
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "<script>alert('Game not found'); window.location.href = '../home.html';</script>";
        }
    }

    function getPurchasedStatus($conn, $gameID, $userID)
    {

        $queryLibrary = "SELECT * FROM library WHERE game_id = '" . $gameID . "' AND user_id = '" . $userID . "'";
        $resultLibrary = mysqli_query($conn, $queryLibrary);
        while ($row = mysqli_fetch_assoc($resultLibrary)) {
            if ($row['game_id'] == $gameID && $row['user_id'] == $userID) {
                return true;
            }
        }
        return false;
    }
    ?>

</body>

</html>