<?php
// 连接数据库

$link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');

// 检查连接是否成功
if ($link->connect_error) {
    die("连接失败: " . $link->connect_error);
}

// 处理 POST 请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    session_start();
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category'];
    $date = $_POST['date'];
    $course_id = $_POST['course'];
    $reason = $_POST['reason'];
    $periods = $_POST['periods'];
$Period = "";
foreach ($periods as $period){
    $Period.=$period;
}


    // 处理上传的文件
    $target_dir = "uploads/"; // 上传文件的目录
    $target_file = $target_dir . basename($_FILES["proof"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // 如果文件上传时出现问题
    if ($uploadOk == 0) {
        echo "抱歉，文件未上传.";
    // 如果一切顺利，尝试上传文件
    } else {
        if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
            // 将数据插入到数据库
            $sql = "INSERT INTO applications (user_id, course_id, category_id, date, reason, doc_name,periods)
            VALUES ('{$_SESSION['user_id']}', '$course_id', '$category_id', '$date', '$reason', '{$target_file}', '$Period')";
            if ($link->query($sql) === TRUE) {
                echo "<script>alert('申請已成功送出！'); window.location.href = 'record.php';</script>";

            } else {
                echo "Error: " . $sql . "<br>" . $link->error;
            }
        } else {
            echo "抱歉，文件上传失败.";
        }
    }

    // 关闭数据库连接
    $link->close();
}
?>
