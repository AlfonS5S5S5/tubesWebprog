<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

require_once __DIR__ . "/../../../BackEnd/connection.php";

$sql = "SELECT * FROM game";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete Games</title>
    <link rel="stylesheet" type="text/css" href="../../css/deleteGame.css">
</head>

<style>
    .container {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    h1 {
        font-size: 40px;
        color: #66c0f4;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    #search {
        width: 100%;
        max-width: 500px;
        padding: 14px 18px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        background-color: #2a475e;
        color: #c7d5e0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
        transition: all 0.3s ease;
        text-align: center;

    }

    #search::placeholder {
        color: #7f9db9;
    }

    #search:focus {
        background-color: #1c3a4f;
        outline: 2px solid #66c0f4;
    }
</style>

<body>
    <div class="container">
        <h1>DELETE GAMES</h1>
        <input type="text" id="search" placeholder="Search games" onkeyup="filterGames(this.value)">
    </div>

    <script>
        function filterGames(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("showSearched").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "../../../BackEnd/Admin/searchGame.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <div id="showSearched"></div>

    <a href="admin.php" class="back-btn">Back to Dashboard</a>
    <script>
        filterGames("");
    </script>
</body>

</html>