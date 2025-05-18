<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/Comment.css">
</head>

<style>
    label {
        font-size: 20px;
        color: #fff;
    }

    .comment-form {
        background-color: #2a475e;
        width: 30%;
        padding: 20px;
        border-radius: 5px;
        margin: 65px;
        color: #fff;
    }

    textarea {
        width: 80%;
        height: 50px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    #addComment-button {
        padding: 10px 20px;
        background-color: #66c0f4;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        color: white;
    }

    #addComment-button:hover {
        background-color: #417a9b;
    }
</style>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="game_id" value="<?php echo $gameId; ?>">
        <div class="comment-form">
            <label for="comment">Add Comment:</label><br>
            <textarea id="comment" name="comment" required maxlength="300"></textarea><br>
            <input type="submit" value="Add Comment" name="addComment" id="addComment-button">
        </div>
    </form>
    <?php

    if (isset($_POST['addComment'])) {
        $comment = $_POST['comment'];
        $gameId = $_POST['game_id'];
        $userID = $_SESSION['user_id'];
        addComment($conn, $comment, $gameId, $userID);
    }
    function addComment($conn, $comment, $gameId, $userID)
    {   
        
        $query = "INSERT INTO review (user_id, game_id, review_text) VALUES ($userID,$gameId,'$comment')";
   
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Berhasil comment!');</script>";
        } else {
            echo "<script>alert('Gagal comment!');</script>";
        }
    }
    ?>
</body>

</html>