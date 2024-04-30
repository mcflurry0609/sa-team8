<?php
// 檢查是否有申請 ID 傳遞過來
if (isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    // 連接到資料庫
    $link = mysqli_connect('localhost', 'root');
    mysqli_select_db($link, 'leave');
    // 檢查連接是否成功
    if (!$link) {
        die("連接失敗：" . mysqli_connect_error());
    }

    // 查詢申請的狀態
    $status_query = "SELECT status FROM applications WHERE application_id = $application_id";
    $status_result = mysqli_query($link, $status_query);
    if (mysqli_num_rows($status_result) > 0) {
        $row = mysqli_fetch_assoc($status_result);
        $status = $row['status'];

        // 只有當狀態為「審核中」時才執行刪除操作
        if ($status == '審核中') {
            // 刪除申請
            $delete_query = "DELETE FROM applications WHERE application_id = $application_id";
            if (mysqli_query($link, $delete_query)) {
                echo "<script>alert('申請已取消成功！'); window.location.href = 'record.php';</script>";
            } else {
                echo "<script>alert('刪除申請時發生錯誤：" . mysqli_error($link) . "');</script>";
            }
        } else {
            echo "<script>alert('只有在審核中的申請才可以取消！'); window.location.href = 'record.php';</script>";
        }
    } else {
        echo "<script>alert('找不到該申請！'); window.location.href = 'record.php';</script>";
    }

    // 關閉資料庫連接
    mysqli_close($link);
} else {
    echo "<script>alert('缺少申請 ID 參數！'); window.location.href = 'record.php';</script>";
}
?>
