<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #1b2838;
            color: #c7d5e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .back {
            width: 100%;
            padding: 20px 30px;
            background-color: #171a21;
            box-shadow: inset 0 -1px 0 #2a475e;
        }

        .back-button {
            color: #66c0f4;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            border: 1px solid transparent;
            padding: 8px 18px;
            border-radius: 4px;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .back-button:hover {
            background-color: #2a475e;
            border-color: #66c0f4;
            color: #a5d6ff;
        }

        .report-container {
            background-color: #171a21;
            border: 1px solid #2a475e;
            border-radius: 6px;
            max-width: 420px;
            width: 100%;
            margin-top: 40px;
            padding: 30px 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
        }

        #reportLabel {
            display: block;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #c7d5e0;
        }
        #reportReason {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            background-color: #0e1621;
            border: 1px solid #2a475e;
            border-radius: 4px;
            color: #c7d5e0;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        #reportReason:hover,
        #reportReason:focus {
            border-color: #66c0f4;
            outline: none;
        }

        .submit-report {
            width: 100%;
            padding: 14px 0;
            margin-top: 25px;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            background-color: #66c0f4;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 0 #3b7ed0;
        }

        .submit-report:hover {
            background-color: #4a90d9;
            box-shadow: 0 4px 0 #2c5ea3;
        }
    </style>
</head>

<body>
    <div class="back">
        <a href="../../FrontEnd/html/Member/HomePage.php" class="back-button">Back</a>

    </div>
    <?php
    require_once('../connection.php');
    $commentId = $_POST['comment_id'];


    if ($commentId) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = $_SESSION['user_id'];

        $query = "DELETE FROM review WHERE review_id = '$commentId'";

        if (mysqli_query($conn, $query)) {

            echo "<script>alert('Berhasil delete comment!'); window.location.href = '../../FrontEnd/html/Member/HomePage.php';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal delete comment'); window.location.href = '../../FrontEnd/html/Member/HomePage.php';</script>";
            exit();
        }
    } else {
        echo "Game ID tidak ada.";
    }
    ?>


</body>

</html>