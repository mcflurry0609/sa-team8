<?php
$link = mysqli_connect('localhost', 'root');
mysqli_select_db($link, 'leave');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // 檢查是否存在所需的POST數據
    if (isset($_POST['aon'])) {
        $aon = $_POST['aon'];

        // 如果 aon 是 2，則只更新 aon，否則更新 aon 和 notice
        if ($aon == 2) {
            // 更新aon欄位
            $update_aon_sql = "UPDATE courses SET aon = '$aon' WHERE course_id = '$course_id'";
            mysqli_query($link, $update_aon_sql);
            // 重定向到所需的頁面
            echo "<script>alert('已拒絕線上請假'); window.location.href = 'inclass.php';</script>";
        } else {
            if (isset($_POST['notice'])) {
                $notice = $_POST['notice'];
                // 更新courses表中的notice欄位
                $update_notice_sql = "UPDATE courses SET notice = '$notice', aon = '$aon' WHERE course_id = '$course_id'";
                mysqli_query($link, $update_notice_sql);
                // 重定向到所需的頁面
                echo "<script>alert('已開放接受線上請假'); window.location.href = 'inclass.php';</script>";
            }
        }
    }
}

// 如果未收到必需的POST數據，或者未提供課程ID，則重定向到填寫頁面
echo "<script>alert('沒有course_id！'); window.location.href = 'inclass.php';</script>";
?>
