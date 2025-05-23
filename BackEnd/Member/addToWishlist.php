<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
   // echo "<script>window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";
}

require_once __DIR__ . "/../connection.php";
// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION);
// echo "</pre>";

if (isset($_POST['game_id']) && isset($_SESSION['user_id'])) {
    $game_id = $_POST['game_id'];
    $user_id = $_SESSION['user_id'];
    $date = date("Y-m-d");

    // Cek jumlah wishlist saat ini
    $queryCount = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = '$user_id'";
    $resultCount = mysqli_query($conn, $queryCount);
    $countRow = mysqli_fetch_assoc($resultCount);

    if ($countRow['count'] < 5) {
        // Cek apakah game sudah ada di wishlist
        $querySelect = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND game_id = '$game_id'";
        $resultSelect = mysqli_query($conn, $querySelect);

        if (mysqli_num_rows($resultSelect) > 0) {
            echo "<script>alert('Game sudah ada di wishlist!');
                window.location.href = '../../FrontEnd/html/Member/HomePage.php';
            </script>";
        } else {
            $queryInsert = "INSERT INTO wishlist (user_id, game_id, wishlist_date_added) VALUES ('$user_id', '$game_id', '$date')";
            if (mysqli_query($conn, $queryInsert)) {
                echo "<script>alert('Game berhasil masuk ke wishlist!');
                    window.location.href = '../../FrontEnd/html/Member/Wishlist.php';
                </script>";
            } else {
                echo "<script>alert('Gagal menambahkan ke wishlist.');
                    window.location.href = '../../FrontEnd/html/Member/HomePage.php';
                </script>";
            }
        }
    } else {
        echo "<script>alert('Wishlist penuh. Maksimal 5 game.');
            window.location.href = '../../FrontEnd/html/Member/HomePage.php';
        </script>";
    }
} else {
    echo "<script>alert('Permintaan tidak valid.');
        window.location.href = '../../FrontEnd/html/Member/HomePage.php';
    </script>";
}
