<?php
require_once '../../../BackEnd/connection.php';
    
    $query = "SELECT * from game";
    $result = mysqli_query($conn, $query);
    
    while(mysqli_fetch_array($result)) {
            $xml = new SimpleXMLElement('<games/>');
            $data = "<games>";
            while ($row = mysqli_fetch_assoc($result)) {
                $data .= "<game>";
                $data .= "<game_id>" . $row['game_id'] . "</game_id>";
                $data .= "<game_name>" . $row['game_name'] . "</game_name>";
                $data .= "<game_genre>" . $row['game_genre'] . "</game_genre>";
                $data .= "<game_developer>" . $row['game_developer'] . "</game_developer>";
                $data .= "<game_release_date>" . $row['game_release_date'] . "</game_release_date>";
                $data .= "<game_price>" . $row['game_price'] . "</game_price>";
                $data .= "<game_supported_os>" . $row['game_supported_os'] . "</game_supported_os>";
                $data .= "<game_type>" . $row['game_type'] . "</game_type>";
                $data .= "<game_picture>" . $row['game_picture'] . "</game_picture>";
                $data .= "</game>";
            }
            $data .= "</games>";
            $x = new SimpleXMLElement($data);
                $x->asXML('games.xml');
    }
?>