<?php
$link = mysqli_connect('localhost', 'root', '', 'leave');

if (!$link) {
    die("資料庫連接失敗：" . mysqli_connect_error());
}

// 獲取用戶提交的數據
$user_id = $_SESSION['user_id']; // 從 session 獲取用戶ID
$category_id = $_POST['category']; // 假別ID
$date = $_POST['date']; // 請假日期
$course_id = $_POST['course']; // 課程ID
$reason = $_POST['reason']; // 請假理由
$periods = $_POST['periods']; // 節次
$Period = "";

// 檢查是否選擇了節次
if (empty($periods)) {
    echo "<script>alert('請選擇節次後再送出申請！'); window.location.href = 'apply.php';</script>";
    exit; 
}

// 將選擇的節次合併成一個字串
foreach ($periods as $period) {
    $Period .= $period . ',';
}
$Period = rtrim($Period, ',');

// 獲取當前日期和時間
$current_date = date('Y-m-d');
$current_time = date('H:i:s');

// 查詢假別的規則
$query = "SELECT rule FROM leaverule WHERE course_id = '$course_id' AND category_id = '$category_id'";
$result = mysqli_query($link, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $rule = mysqli_fetch_assoc($result)['rule'];

    // 根據規則進行驗證
    if ($rule == '0') {
        // 0: 只能事前請假，若請假日期在當前日期或之前，禁止請假
        if ($date < $current_date) {
            echo "<script>alert('只能事前請假，請選擇未來的日期。'); window.location.href = 'apply.php';</script>";
            exit;
        } elseif ($date == $current_date) {
            // 若請假日期是今天，檢查節次的開始時間
            $period_query = "SELECT start_time FROM period_time WHERE period IN ('$Period')";
            $period_result = mysqli_query($link, $period_query);
            while ($row = mysqli_fetch_assoc($period_result)) {
                if ($row['start_time'] <= $current_time) {
                    echo "<script>alert('只能事前請假，請選擇未來的節次。'); window.location.href = 'apply.php';</script>";
                    exit;
                }
            }
        }
    }
}

// 處理文件上傳
$target_dir = "uploads/"; // 上傳文件目錄
$target_file = $target_dir . basename($_FILES["proof"]["name"]); // 合併文件目錄和文件名
if (!move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
    // 如果文件上傳失敗，返回錯誤
    echo "抱歉，上傳檔案時出現錯誤。";
    exit; 
}

// 將申請信息存入資料庫
$sql = "INSERT INTO applications (user_id, course_id, category_id, date, reason, doc_name, periods)
        VALUES ('$user_id', '$course_id', '$category_id', '$date', '$reason', '$target_file', '$Period')";
if (mysqli_query($link, $sql)) {
    // 獲取已批准請假的次數
    $approved_query = "SELECT COUNT(*) as approved_count FROM applications WHERE course_id = '$course_id' AND status = '已批准'";
    $approved_result = mysqli_query($link, $approved_query);
    $approved_count = mysqli_fetch_assoc($approved_result)['approved_count'];

    // 獲取用戶名
    $user_query = "SELECT user_name FROM users WHERE user_id = '$user_id'";
    $user_result = mysqli_query($link, $user_query);
    $user_name = mysqli_fetch_assoc($user_result)['user_name'];

    // 獲取課程名
    $course_query = "SELECT course_name FROM courses WHERE course_id = '$course_id'";
    $course_result = mysqli_query($link, $course_query);
    $course_name = mysqli_fetch_assoc($course_result)['course_name'];

    // 獲取假別名
    $category_query = "SELECT category_name FROM category WHERE category_id = '$category_id'";
    $category_result = mysqli_query($link, $category_query);
    $category_name = mysqli_fetch_assoc($category_result)['category_name'];

    // 獲取申請時間
    $apply_time_query = "SELECT apply_time FROM applications WHERE application_id = LAST_INSERT_ID()";
    $apply_time_result = mysqli_query($link, $apply_time_query);
    $apply_time = mysqli_fetch_assoc($apply_time_result)['apply_time'];

    // 獲取教授的電子信箱
    $prof_email_query = "SELECT GROUP_CONCAT(user_email) as emails FROM users WHERE user_id IN (SELECT user_id FROM courseteacher WHERE course_id = '$course_id') AND notify != 0";
    $prof_email_result = mysqli_query($link, $prof_email_query);
    $prof_emails = explode(',', mysqli_fetch_assoc($prof_email_result)['emails']);

    if (!empty($prof_emails)) {
        include('applyemail.php');
    }

    echo "<script>alert('申請已成功送出！您在該課程中已核准之請假次數：$approved_count'); window.location.href = 'record.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

mysqli_close($link);
?>