<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>拒絕請假緣由</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/notice.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="layout">
        <div class="wrapper">
            <h2>拒絕請假緣由</h2>
            <form class="form" method="post" action="rejectreason.php?id=<?php echo $_GET['id']; ?>">
                <div class="">
                    <div class="reject">
                        <div class="title">拒絕緣由：</div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫拒絕緣由" maxlength="30" name="rejectreason" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <a class="nosend" id="changeMindBtn" href="record.php" style="text-decoration-line: none;">改變心意</a>
                    <button type="submit" class="sendout" id="submitBtn">送出批准</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $link = mysqli_connect('localhost', 'root');
            mysqli_select_db($link, 'leave');
            
            if ($link->connect_error) {
                die("连接失败: " . $link->connect_error);
            }
            
            $application_id = $_GET['id'];
            $rejectreason = $link->real_escape_string($_POST['rejectreason']);
            
            // 更新applications表中的rejectreason欄位
            $update_query = "UPDATE applications SET rejectreason = '$rejectreason' WHERE application_id = $application_id";
            $update_result = mysqli_query($link, $update_query);
            
            if ($update_result) {
                // 重定向到updatestatus.php以更新狀態
                header("Location: updatestatus.php?id=$application_id&action=reject");
                exit();
            } else {
                echo "拒絕理由更新失敗，請重試";
            }
        }
    ?>
</body>
</html>
