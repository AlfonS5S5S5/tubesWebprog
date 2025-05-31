<?php
    $conn = mysqli_connect("localhost", "root", "", "steamweb");

    if(!$conn) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }


    mysqli_query($conn, "DELETE FROM wishlist");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari wishlist table: " . mysqli_error($conn) . "</p>";
    }

    mysqli_query($conn, "DELETE FROM review");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari review table: " . mysqli_error($conn) . "</p>";
    }

    mysqli_query($conn, "DELETE FROM library");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari library table: " . mysqli_error($conn) . "</p>";
    }

    mysqli_query($conn, "DELETE FROM topup");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari topup table: " . mysqli_error($conn) . "</p>";
    }

    mysqli_query($conn, "DELETE FROM block");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari block table: " . mysqli_error($conn) . "</p>";
    }

    mysqli_query($conn, "DELETE FROM game");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari game table: " . mysqli_error($conn) . "</p>";
    }

    mysqli_query($conn, "DELETE FROM users");
    if(mysqli_error($conn)) {
        echo "<p>gagal delete data dari users table: " . mysqli_error($conn) . "</p>";
    }

    echo "<h3>data sudah berhasil di hapus dari table</h3>";

    $sqlUsers = "INSERT INTO users (user_id, user_name, user_password, user_wallet, user_block_status, user_profile_picture, user_role) VALUES
        (1, 'member1', '32250170a0dca92d53ec9624f336ca24', 50000, 'UNBLOCKED', NULL, 'MEMBER'),
        (2, 'admin1', '25e4ee4e9229397b6b17776bfceaf8e7', NULL, 'UNBLOCKED', NULL, 'ADMIN'),
        (3, 'member2', '73a054cc528f91ca1bbdda3589b6a22d', 20000, 'BLOCKED', NULL, 'MEMBER'),
        (4, 'admin2', '8b478e5c89442c1e054b49e2c3814e9e', 0, 'UNBLOCKED', NULL, 'ADMIN'),
        (5, 'alfonsGaming', 'da26f30d97cd676a721b33cde6c3e1ce', 1327270, 'UNBLOCKED', NULL, 'MEMBER'),
        (6, 'alfons', '8b6bc5d8046c8466359d3ac43ce362ab', 25000, 'UNBLOCKED', NULL, 'MEMBER')";

    $result = mysqli_query($conn, $sqlUsers);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke users table</p>";
    } else {
        echo "<p>gagal masukan data ke users table: " . mysqli_error($conn) . "</p>";
    }

    $sqlGames = "INSERT INTO game (game_id, game_name, game_genre, game_developer, game_release_date, game_price, game_supported_os, game_type, game_picture) VALUES
        (1, 'Apex Legends', 'Shooter', 'EA', '2023-11-20', 60000, 'Windows 10', 'Multiplayer', 'apex.jpg'),
        (2, 'Counter Strike', 'Shooter', 'Valve', '2022-07-15', 30000, 'Windows 11', 'Multiplayer', 'cs.png'),
        (3, 'F1 24', 'Racing', 'EA', '2024-01-05', 15000, 'Windows 11', 'Singleplayer', 'f1.jpeg'),
        (4, 'Dota 2', 'MOBA', 'Valve', '2013-07-09', 20000, 'Windows 10', 'Multiplayer', 'dota2.jpg'),
        (5, 'Cyberpunk 2077', 'RPG', 'CD Projekt', '2020-12-10', 75000, 'Windows 10', 'Singleplayer', 'cyberpunk2077.jpg'),
        (6, 'Baldur\'s Gate 3', 'RPG', 'Larian Studios', '2023-08-03', 89000, 'Windows 10', 'Singleplayer', 'bg3.jpg'),
        (7, 'Stardew Valley', 'Simulation', 'ConcernedApe', '2016-02-26', 12000, 'Windows 10', 'Singleplayer', 'stardew.jpg'),
        (8, 'The Witcher 3', 'RPG', 'CD Projekt', '2015-05-18', 60000, 'Windows 10', 'Singleplayer', 'witcher3.jpg'),
        (9, 'Terraria', 'Adventure', 'Re-Logic', '2011-05-16', 10000, 'Windows 10', 'Multiplayer', 'terraria.jpg'),
        (10, 'Elden Ring', 'Action', 'FromSoftware', '2022-02-25', 75000, 'Windows 11', 'Singleplayer', 'eldenring.jpg'),
        (11, 'Left 4 Dead 2', 'Shooter', 'Valve', '2009-11-17', 20000, 'Windows 10', 'Multiplayer', 'l4d2.jpg'),
        (12, 'Sea of Thieves', 'Adventure', 'Rare', '2018-03-20', 65000, 'Windows 10', 'Multiplayer', 'seaofthieves.jpg'),
        (13, 'Hades', 'Roguelike', 'Supergiant Games', '2020-09-17', 25000, 'Windows 10', 'Singleplayer', 'hades.jpg'),
        (14, 'Phasmophobia', 'Horror', 'Kinetic Games', '2020-09-18', 40000, 'Windows 10', 'Multiplayer', 'phasmophobia.jpg'),
        (15, 'It Takes Two', 'Adventure', 'Hazelight Studios', '2021-03-26', 55000, 'Windows 11', 'Multiplayer', 'ittakestwo.jpg'),
        (16, 'Among Us', 'Party', 'Innersloth', '2018-11-16', 10000, 'Windows 10', 'Multiplayer', 'amongus.jpg')";

    $result = mysqli_query($conn, $sqlGames);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke game table</p>";
    } else {
        echo "<p>gagal masukan data ke game table: " . mysqli_error($conn) . "</p>";
    }

    $sqlBlock = "INSERT INTO block (block_id, user_id, block_reason, block_status) VALUES
        (2, 1, 'Racist', 'ACCEPTED')";

    $result = mysqli_query($conn, $sqlBlock);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke block table</p>";
    } else {
        echo "<p>gagal masukan data ke block table: " . mysqli_error($conn) . "</p>";
    }

    $sqlTopup = "INSERT INTO topup (topup_id, topup_date, user_id, topup_quantity) VALUES
        (1, '2024-04-01', 1, 50000),
        (2, '2024-04-02', 3, 20000),
        (3, '2024-04-03', 5, 150000)";

    $result = mysqli_query($conn, $sqlTopup);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke topup table</p>";
    } else {
        echo "<p>gagal masukan data ke topup table: " . mysqli_error($conn) . "</p>";
    }

    $sqlLibrary = "INSERT INTO library (user_id, game_id, library_status, library_buy_game_price) VALUES
        (1, 1, 'INSTALLED', 60000),
        (1, 4, 'INSTALLED', 0),
        (1, 7, 'NOT INSTALLED', 12000),
        (3, 2, 'INSTALLED', 30000),
        (3, 5, 'NOT INSTALLED', 75000),
        (3, 9, 'INSTALLED', 10000),
        (5, 1, 'NOT INSTALLED', 60000),
        (5, 2, 'NOT INSTALLED', 30000),
        (5, 3, 'NOT INSTALLED', 15000),
        (5, 4, 'NOT INSTALLED', 0),
        (5, 6, 'NOT INSTALLED', 89000),
        (5, 7, 'INSTALLED', 89000),
        (5, 12, 'INSTALLED', 65000),
        (6, 1, 'NOT INSTALLED', 60000),
        (6, 2, 'NOT INSTALLED', 30000),
        (6, 3, 'NOT INSTALLED', 15000),
        (6, 4, 'NOT INSTALLED', 0),
        (6, 8, 'NOT INSTALLED', 60000)";

    $result = mysqli_query($conn, $sqlLibrary);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke library table</p>";
    } else {
        echo "<p>gagal masukan data ke library table: " . mysqli_error($conn) . "</p>";
    }

    $sqlReview = "INSERT INTO review (review_id, user_id, game_id, review_text) VALUES
        (1, 1, 1, 'Ugly game, not recommended, black man developer'),
        (2, 1, 4, 'Classic MOBA, never gets old.'),
        (3, 3, 2, 'Best tactical shooter out there.'),
        (4, 3, 9, 'Fun and creative, great to play with friends.'),
        (5, 5, 6, 'One of the best RPGs I\'\'ve ever played.'),
        (6, 5, 12, 'Great pirate adventure with amazing co-op gameplay.'),
        (9, 3, 2, 'game nya jelek')";

    $result = mysqli_query($conn, $sqlReview);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke review table</p>";
    } else {
        echo "<p>gagal masukan data ke review table: " . mysqli_error($conn) . "</p>";
    }

    $sqlWishlist = "INSERT INTO wishlist (user_id, game_id, wishlist_date_added) VALUES
        (1, 2, '2025-04-10'),
        (1, 5, '2025-04-11'),
        (1, 8, '2025-04-12'),
        (1, 10, '2025-04-13'),
        (1, 13, '2025-04-14'),
        (3, 4, '2025-04-11'),
        (3, 7, '2025-04-12'),
        (5, 5, '2025-04-11'),
        (5, 8, '2025-05-27'),
        (5, 10, '2025-04-13'),
        (5, 15, '2025-04-14'),
        (6, 2, '2025-05-18'),
        (6, 6, '2025-05-18')";

    $result = mysqli_query($conn, $sqlWishlist);
    if($result) {
        echo "<p>data dummy berhasil di masukan ke wishlist table</p>";
    } else {
        echo "<p>gagal masukan data ke wishlist table: " . mysqli_error($conn) . "</p>";
    }

    echo "<h2>semua dummy berhasil di insert ke tiap table!</h2>";

    mysqli_close($conn);
?>