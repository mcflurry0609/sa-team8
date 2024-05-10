<?php

$link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');


if ($link->connect_error) {
    die("資料庫連接失敗: " . $link->connect_error);
}



    
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category'];
    $date = $_POST['date'];
    $course_id = $_POST['course'];
    $reason = $_POST['reason'];
    $periods = $_POST['periods'];
    $Period = "";
    if (empty($periods)) {      //節次是空的不可以送出申請
        echo "<script>alert('請選擇節次後再送出申請！'); window.location.href = 'apply.php';</script>";
        exit; 
    }
    foreach ($periods as $period) {
        $Period .= $period;     //把選取的節次合併紀錄在資料庫
    }

    $target_dir = "uploads/"; //路徑
    $target_file = $target_dir . basename($_FILES["proof"]["name"]); //檔案名合併路徑
   
        
            
            $sql = "INSERT INTO applications (user_id, course_id, category_id, date, reason, doc_name,periods)
            VALUES ('{$_SESSION['user_id']}', '$course_id', '$category_id', '$date', '$reason', '{$target_file}', '$Period')";
            if ($link->query($sql) === TRUE) {
                $approved_query = "SELECT COUNT(*) as approved_count FROM applications WHERE course_id = '$course_id' AND status = '已批准'";
                $approved_result = mysqli_query($link, $approved_query);
                $approved_count = mysqli_fetch_assoc($approved_result)['approved_count'];
                
                $user_query = "SELECT user_name FROM users WHERE user_id = '{$_SESSION['user_id']}'";
                $user_result = mysqli_query($link, $user_query);
                $user_name = mysqli_fetch_assoc($user_result)['user_name'];

                $course_query = "SELECT course_name FROM courses WHERE course_id = '$course_id'";
                $course_result = mysqli_query($link, $course_query);
                $course_name = mysqli_fetch_assoc($course_result)['course_name'];

                $category_query = "SELECT category_name FROM category WHERE category_id = '$category_id'";
                $category_result = mysqli_query($link, $category_query);
                $category_name = mysqli_fetch_assoc($category_result)['category_name'];

                $apply_time_query = "SELECT apply_time FROM applications WHERE application_id = LAST_INSERT_ID()";
                $apply_time_result = mysqli_query($link, $apply_time_query);
                $apply_time = mysqli_fetch_assoc($apply_time_result)['apply_time'];

                $prof_email_query = "SELECT user_email FROM users WHERE user_id = (SELECT user_id FROM courseteacher WHERE course_id = '$course_id')";
                $prof_email_result = mysqli_query($link, $prof_email_query);
                $prof_email = mysqli_fetch_assoc($prof_email_result)['user_email'];

                include('applyemail.php');

                echo "<script>alert('申請已成功送出！您在該課程中已核准之請假次數：$approved_count'); window.location.href = 'record.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $link->error;
            }
        


    $link->close();

?>
