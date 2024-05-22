<?php
    
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('請先登錄'); window.location.href = 'login.html';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // 連接數據庫
    $link = mysqli_connect('localhost', 'root', '', 'leave');
    if (!$link) {
        die("連接失敗：" . mysqli_connect_error());
    }

    // 檢查是否收到表單數據
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $notify = $_POST["notify"];
        $email = $_POST["email"];

        // 更新數據庫
        $sql = "UPDATE users SET notify='$notify', user_email='$email' WHERE user_id='$user_id'";
        if (mysqli_query($link, $sql)) {
            echo "<script>alert('更新成功'); ";
            // 根據用戶角色跳轉頁面
            if ($role == '教授') {
                echo "window.location.href = 'review.php';</script>";
            } else if ($role == '學生' || $role == '助教') {
                echo "window.location.href = 'record.php';</script>";
            }
        } else {
            echo "錯誤: " . $sql . "<br>" . mysqli_error($link);
        }
    }

    // 關閉數據庫連接
    mysqli_close($link);
?>
