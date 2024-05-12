<?php
$link = mysqli_connect('localhost', 'root');
mysqli_select_db($link, 'leave');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) { //post請求而且post內包含course_id才會執行
    $course_id = $_POST['course_id'];

    
    if (isset($_POST['aon'])) { //有post傳遞aon才會執行
        $aon = $_POST['aon'];

        // 如果 aon 是 2，拒絕請假，則只更新 aon，否則接受請假，更新 aon 和 notice
        if ($aon == 2) {
            $update_aon_sql = "UPDATE courses SET aon = '$aon' WHERE course_id = '$course_id'";
            mysqli_query($link, $update_aon_sql);
            echo "<script>alert('已拒絕線上請假'); window.location.href = 'inclass.php';</script>";
        } else {
            if (isset($_POST['notice'])) {
                $notice = $_POST['notice'];
                $update_notice_sql = "UPDATE courses SET notice = '$notice', aon = '$aon' WHERE course_id = '$course_id'";
                mysqli_query($link, $update_notice_sql);
                echo "<script>alert('已開放接受線上請假'); window.location.href = 'inclass.php';</script>";
            }
        }
    }
}

echo "<script>alert('沒有course_id！'); window.location.href = 'inclass.php';</script>";
?>
