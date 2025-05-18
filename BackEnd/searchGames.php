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
            echo "ID: " . $row['game_id'] .
                    ", Name: " . $row['game_name'] .
                    ", Image: " . $row['game_picture'] .
                    ", Price: " . $row['game_price'] . "\n";
        }
    }
}
?>