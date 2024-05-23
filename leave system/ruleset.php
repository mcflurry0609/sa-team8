<?php
$link = mysqli_connect('localhost', 'root');
mysqli_select_db($link, 'leave');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) { // post請求而且post內包含course_id才會執行
    $course_id = $_POST['course_id'];

    if (isset($_POST['aon'])) { // 有post傳遞aon才會執行
        $aon = $_POST['aon'];

        // 如果 aon 是 2，拒絕請假，則只更新 aon，否則接受請假，更新 aon 和 notice
        if ($aon == 2) {
            $update_aon_sql = "UPDATE courses SET aon = '$aon' WHERE course_id = '$course_id'";
            mysqli_query($link, $update_aon_sql);
            echo "<script>alert('已拒絕線上請假'); window.location.href = 'inclass.php';</script>";
            exit();
        } else {
            if (isset($_POST['notice'])) {
                $notice = $_POST['notice'];
                $update_notice_sql = "UPDATE courses SET notice = '$notice', aon = '$aon' WHERE course_id = '$course_id'";
                mysqli_query($link, $update_notice_sql);
            }
        }
    }

    // 處理請假規則
    if (isset($_POST['rules']) && is_array($_POST['rules'])) {
        $rules = $_POST['rules'];

        foreach ($rules as $category_id => $rule) {
            // 檢查是否已存在該課堂與假別的規則
            $check_rule_sql = "SELECT * FROM leaverule WHERE course_id = '$course_id' AND category_id = '$category_id'";
            $result = mysqli_query($link, $check_rule_sql);

            if (mysqli_num_rows($result) > 0) {
                // 如果規則已存在，則更新規則
                $update_rule_sql = "UPDATE leaverule SET rule = '$rule' WHERE course_id = '$course_id' AND category_id = '$category_id'";
                mysqli_query($link, $update_rule_sql);
            } else {
                // 如果規則不存在，則插入新規則
                $insert_rule_sql = "INSERT INTO leaverule (course_id, category_id, rule) VALUES ('$course_id', '$category_id', '$rule')";
                mysqli_query($link, $insert_rule_sql);
            }
        }
        echo "<script>alert('已更新請假規則'); window.location.href = 'inclass.php';</script>";
        exit();
    }
}

echo "<script>alert('沒有course_id或aon！'); window.location.href = 'inclass.php';</script>";
?>
