<?php
    $application_id=$_POST["application_id"];
    $category_name=$_POST["category_name"];
    $date=$_POST["date"];
    $course_name=$_POST["course_name"];
    $reason=$_POST["reason"];
    $periods = $_POST["periods"];
    $Period = "";
    if (empty($periods)) {
        echo "<script>alert('請選擇節次後再送出申請！'); window.location.href = 'apply.php';</script>";
        exit; // 停止执行后续代码
    }
    foreach ($periods as $period) {
        $Period .= $period;
    }
    $link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');
        $target_dir = "uploads/"; // 上传文件的目录
        $target_file = $target_dir . basename($_FILES["proof"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $sql="UPDATE applications SET reason= '$reason',periods= '$Period' WHERE application_id='$application_id'";
        if(mysqli_query($link,$sql)){
            echo 
            '<script>
            alert("修改成功")
            location.href = "record.php"
            </script>';
        }
        else{
            echo 
            '<script>
            alert("修改失敗")
            location.href = update.php"
            </script>';
    
        }

        if ($uploadOk == 0) {
            echo "抱歉，文件未上传.";
        // 如果一切顺利，尝试上传文件
        } else {
            if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
                // 将数据插入到数据库
                $sql = "UPDATE applications SET reason= '$reason',periods= '$Period', doc_name= '$target_file' WHERE application_id='$application_id'";
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
    
?>
