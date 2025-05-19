<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    
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
        echo "<header><h1>" . htmlspecialchars($_SESSION['username']) . "'s Library <h1></header>";

        $query = "SELECT * FROM library AS l INNER JOIN game AS g WHERE l.game_id = g.game_id AND user_id = $_SESSION[user_id];";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $rows = [];
            $gameGenre = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
                if (!in_array($row['game_genre'], $gameGenre)) {
                    $gameGenre[] = $row['game_genre'];
                }
            }
            echo "<form method='POST' action=''>";
            echo "<label for='genre'>Sort by Genre: </label>";
            echo "<select name ='sortBy' id='genre' onchange='this.form.submit()'>";
            $selectedGenre = isset($_POST['sortBy']) ? $_POST['sortBy'] : 'All';

            echo "<option value='All'" . ($selectedGenre === 'All' ? 'selected' : '') . ">All Genre</option>";
            foreach ($gameGenre as $genre) {
                $isSelected = $genre === $selectedGenre ? 'selected' : '';
                echo "<option value='$genre' $isSelected>$genre</option>";
            }
            echo "</select>";
            echo "</form>";
            if (isset($_POST['sortBy']) && $_POST['sortBy'] !== 'All') {
                SortByGenre($conn, $_POST['sortBy']);
            } else {
                foreach ($rows as $row) {
                    showDetailGame($row['game_id'],false);
                    echo "<hr>";
                }
            }
        } else {
            //direct ke buy game
            echo "<p>No games found in your library. </p>";
        }
    }

    function SortByGenre($conn, $genre)
    {
        $query = "SELECT * FROM library AS l INNER JOIN game AS g WHERE l.game_id = g.game_id AND user_id = $_SESSION[user_id] AND g.game_genre = '$genre';";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                showDetailGame($row['game_id'],false);
                echo "<hr>";
            }
        } else {
        
            echo "<p>No games found in your library. </p>";
        }
    }
    ?>
</body>

</html>