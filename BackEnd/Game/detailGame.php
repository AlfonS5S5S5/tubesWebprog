<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../connection.php';
    if (isset($_POST['submit_detail'])) {
        $gameID = $_POST['game_id'];
        $Wishlist = false;
        showDetailGame($gameID, $Wishlist);
    }

    function showDetailGame($gameID, $Wishlist)
    {
        global $conn;

        $query = "SELECT * FROM game WHERE game_id = '" . $gameID . "'";
        $result = mysqli_query($conn, $query);
        $found = false;

        $picture_path = isset($_POST['submit_detail']) ? "../../../Assets/" : "../../../Assets/";

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['game_id'] == $gameID) {
                echo "<div class='game-card'>";

                echo "<style>
                        .game-card img {
                            width: 300px;
                            height: 300px;
                            object-fit: cover;
                        }
                      </style>";
                echo "<img src='" . $picture_path . htmlspecialchars($row['game_picture']) . "' alt='" . htmlspecialchars($row['game_name']) . "' />";

                // Info
                echo "<div class='game-info'>";
                echo "<h2>" . htmlspecialchars($row['game_name']) . "</h2>";
                echo "<p class='genre'>Genre: " . htmlspecialchars($row['game_genre']) . "</p>";
                echo "<p>Developer: " . htmlspecialchars($row['game_developer']) . "</p>";
                echo "<p>Release Date: " . htmlspecialchars($row['game_release_date']) . "</p>";
                echo "<p>Supported OS: " . htmlspecialchars($row['game_supported_os']) . "</p>";
                echo "<p>Game Type: " . htmlspecialchars($row['game_type']) . "</p>";
                echo "<p>Price: Rp " . number_format($row['game_price'], 0, ',', '.') . "</p>";

                // Purchase/Play status
                echo "<div class='game-actions'>";
                if (isset($_SESSION['user_id'])) {
                    if (getPurchasedStatus($conn, $gameID, $_SESSION['user_id'])) {
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($gameID) . "'>";
                        echo "<button type='submit' class='purchase-buy-button'>Play Game</button>";
                        echo "</form>";
                    } else {
                        echo "<form method='post' action='../../../FrontEnd/html/Game/BuyGames.php'>";
                        echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($gameID) . "'>";
                        echo "<button type='submit' name='purchase' class='purchase-buy-button'>BUY GAME</button>";
                        echo "</form>";
                    }
                    if ($Wishlist) {
                        echo "<form method='post' action='../../../BackEnd/Member/removeWishlist.php'>";
                        echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($gameID) . "'>";
                        echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($_SESSION['user_id']) . "'>";
                        echo "<button type='submit' name='remove_wishlist' class='remove-wishlist-button'>Remove from Wishlist</button>";
                        echo "</form>";
                    }
                } else {
                    echo "<p><a href='../../../FrontEnd/html/Member/Login.html'>Login to purchase</a></p>";
                }
                echo "</div>"; // .game-actions

                echo "</div>"; // .game-info
                echo "</div>"; // .game-card

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


    function getGameComment($gameID)
    {
        global $conn;
        $query = "SELECT * FROM review WHERE game_id = '" . $gameID . "'";
        $result = mysqli_query($conn, $query);
        $comments = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }

        return $comments;
    }

    function showGameComment($gameID)
    {
        global $conn;

        $gameID = $_POST['game_id'] ?? null;

        if ($gameID) {
            $comments = getGameComment($gameID);
            echo "<table border='1'>";
            foreach ($comments as $comment) {
                $query = "SELECT user_name FROM users WHERE user_id = '" . $comment['user_id'] . "'";
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);

                echo "<tr>";
                echo "<td>";
                echo "<div class='comment'>";
                echo "<strong class='comment-author'>" . htmlspecialchars($user['user_name']) . ":</strong> ";
                echo "<span class='comment-text'>" . htmlspecialchars($comment['review_text']) . "</span>";
                echo "</div>";
                echo "</td>";

                // Buka form baru untuk setiap comment
                echo "<td>";
                echo "<form method='post' action='../../../BackEnd/Game/processReportComment.php'>";
                echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($comment['review_id']) . "'>";
                echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($gameID) . "'>";
                echo "<input type='submit' class='report_button' name='report_comment' value='Report Comment'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>

</html>