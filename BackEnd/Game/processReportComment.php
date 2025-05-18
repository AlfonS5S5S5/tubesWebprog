<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Background & body */
        body {
            background-color: #1b2838;
            /* warna dasar gelap khas Steam */
            color: #c7d5e0;
            /* warna font terang */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        /* Container Back Button */
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

        /* Report form container */
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

        /* Label */
        #reportLabel {
            display: block;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #c7d5e0;
        }

        /* Select dropdown */
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

        /* Submit button */
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

        /* Responsive */
        @media (max-width: 480px) {
            .report-container {
                margin: 20px 15px;
                padding: 20px 15px;
            }

            .back {
                padding: 15px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="back">
        <a href="../../FrontEnd/html/Member/HomePage.php" class="back-button">Back</a>

    </div>
    <?php
    require_once('../connection.php');

    $gameId = $_POST['game_id'];
    $commentId = $_POST['comment_id'];
    $userId = '';

    if ($commentId) {

        $queryUser = "SELECT user_id FROM review WHERE review_id = '$commentId'";
        $resultUser = mysqli_query($conn, $queryUser);
        if ($rowUser = mysqli_fetch_assoc($resultUser)) {
            $userId = $rowUser['user_id'];
        }
    }

    $reportReasons = [
        'Death threats',
        'Racist',
        'Bad Violence',
        'Hate speech'
    ];

    $query = "SELECT * FROM review WHERE game_id = '$gameId' AND user_id = '$userId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    echo "<div class='report-container'>";
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='user_id' value='$userId'>";
    echo "<input type='hidden' name='game_id' value='$gameId'>";
    echo "<input type='hidden' name='comment_id' value='$commentId'>";
    echo "<label for='Report' id='reportLabel'>Report Reason: </label>";
    echo "<select name ='reason' id='reportReason' onchange='this.form.submit()'>";

    $selectedReason = $_POST['reason'] ?? 'None';

    echo "<option value='None'" . ($selectedReason === 'None' ? ' selected' : '') . ">Select Reason</option>";
    foreach ($reportReasons as $reason) {
        $isSelected = $reason === $selectedReason ? 'selected' : '';
        echo "<option value='$reason' $isSelected>$reason</option>";
    }

    echo "</select><br>";
    echo "<input type='submit' class='submit-report'name='report_comment' value='Report Comment'>";
    echo "</form>";
    echo "</div>";
    if (isset($_POST['report_comment']) && isset($_POST['reason'])) {
        $reason = $_POST['reason'];
        if ($reason !== 'None') {
            reportComment($conn, $userId, $reason);
        } else {
            echo "<script>alert('Pilih alasaran report.');</script>";
        }
    }
    function reportComment($conn, $userId, $reason)
    {
        $query = "INSERT INTO block (user_id, block_reason,block_status) VALUES ('$userId', '$reason', 'PENDING')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Report Berhasil!');   window.location.href = '../../FrontEnd/html/Member/HomePage.php';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal report.');</script>";
        }
    }
    ?>


</body>

</html>