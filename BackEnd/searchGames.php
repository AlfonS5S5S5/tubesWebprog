<?php
require_once __DIR__ . "/connection.php";

if (isset($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']);
    
    $query = "SELECT game_id, game_name, game_picture, game_price
                FROM game
                WHERE game_name LIKE '%$search%'
                LIMIT 5";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['game_id'] . "|" . $row['game_name'] . "|" . $row['game_picture'] . "|" . $row['game_price'] . "\n";
        }
    }
}
?>