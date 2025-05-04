<?php
    function getProfilePicture($conn, $user_id) {
        $query = "SELECT user_profile_picture FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            return $row['user_profile_picture'];
        }
        return 0;
    }
    
    function getCurrentBalance($conn, $user_id) {
        $query = "SELECT user_wallet FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            return $row['user_wallet'];
        }
        return 0;
    }
    function getGames($conn) {
        $query = "SELECT game_id, game_name, game_price, game_picture, game_developer FROM game";
        $result = mysqli_query($conn, $query);
        $games = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['game_image'] = $row['game_picture'];
                $games[] = $row;

            }
        }
        return $games;
    }

    function updateUserSession($conn, $user_id) {
        $_SESSION['profile_picture'] = getProfilePicture($conn, $user_id);
        $_SESSION['balance'] = getCurrentBalance($conn, $user_id);
    }
?>