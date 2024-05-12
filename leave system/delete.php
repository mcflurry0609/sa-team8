<?php

if (isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];
    $link = mysqli_connect('localhost', 'root');
    mysqli_select_db($link, 'leave');

    
    $status_query = "SELECT status FROM applications WHERE application_id = $application_id"; //找到該筆請假申請的狀態
    $status_result = mysqli_query($link, $status_query);  //存進statusresult
    if (mysqli_num_rows($status_result) > 0) { //行數大於0代表有資料，可以執行
        $row = mysqli_fetch_assoc($status_result); //存到row裡面
        $status = $row['status']; //從row取出status

        // 只有當狀態為「審核中」時才執行刪除操作，record.php有篩選過，但在這裡再次檢查是避免在刪除的過程中請假申請可能已經被審核或被拒絕，直接刪除會讓申請直接消失
        if ($status == '審核中') {
            
            $delete_query = "DELETE FROM applications WHERE application_id = $application_id";
            if (mysqli_query($link, $delete_query)) {
                echo "<script>alert('申請已成功取消！'); window.location.href = 'record.php';</script>";
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
    echo "<script>alert('缺少申請ID！'); window.location.href = 'record.php';</script>";
}
?>
