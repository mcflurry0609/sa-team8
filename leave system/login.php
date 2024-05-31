<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        session_start(); // 如果你還沒有啟動 session，這一行是必須的。

        $user_id = $_POST['id'];
        $password = $_POST['password'];

        $link = mysqli_connect('localhost', 'root');
        mysqli_select_db($link, 'leave');

        // 檢查帳號是否存在
        $sql_user = "SELECT * FROM users WHERE user_id='$user_id'";
        $result_user = mysqli_query($link, $sql_user);

        if ($row_user = mysqli_fetch_assoc($result_user)) {
            // 檢查密碼是否正確
            $sql_password = "SELECT * FROM users WHERE user_id='$user_id' AND password='$password'";
            $result_password = mysqli_query($link, $sql_password);

            if ($row_password = mysqli_fetch_assoc($result_password)) {
                $_SESSION['user_id'] = $row_password['user_id'];
                $_SESSION['user_name'] = $row_password['user_name'];
                $_SESSION['role'] = $row_password['role'];

                if ($row_password['role'] == '學生' || $row_password['role'] == '助教') {
                    $redirect_url = "record.php";
                } else if ($row_password['role'] == '教授') {
                    $redirect_url = "review.php";
                } else {
                    // 可以增加其他角色的處理邏輯
                    $redirect_url = "default.php"; // 假設有個預設頁面
                }

                header("Location: $redirect_url");
                exit;
            } else {
                // 密碼錯誤
                ?>
                <script>
                    alert('密碼錯誤');
                    history.back();
                </script>
                <?php
            }
        } else {
            // 帳號不存在
            ?>
            <script>
                alert('查無此帳號');
                history.back();
            </script>
            <?php
        }
    ?>
</body>
</html>
