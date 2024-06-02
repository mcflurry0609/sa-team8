<?php
    $link=mysqli_connect('localhost','root');
    mysqli_select_db($link,'leave');
    $application_id=$_POST["application_id"];
    $date=$_POST["date"];
    $reason=$_POST["reason"];
    $periods = $_POST["periods"];
    $Period = "";
    if (empty($periods)) {
        echo "<script>alert('請選擇節次後再送出申請！'); window.history.back();</script>";
        exit;
    }
    foreach ($periods as $period) {
        $Period .= $period;
    }
    
    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($_FILES["proof"]["name"]);
    if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) { //將上傳的檔案從臨時目錄移動到你指定的目錄。當一個檔案被上傳時，PHP 會將它存放在一個臨時目錄中，並將這個臨時檔案的路徑存放在 $_FILES['proof']['tmp_name'] 中。你需要使用 move_uploaded_file() 函數來將檔案從臨時目錄移動到你想要的位置
    } else {
        echo "抱歉，上傳檔案時出現錯誤。";
        exit; 
    }
        
    $sql="UPDATE applications SET reason= '$reason',periods= '$Period', doc_name= '{$target_file}' WHERE application_id='$application_id'";
    if(mysqli_query($link,$sql)){
        echo '<script>
            alert("請假申請已修改成功")
            location.href = "record.php"
            </script>';
    }else{
        echo'<script>
            alert("請假申請修改失敗請重試")
            location.href = update.php"
            </script>';
    }

    $link->close();
    
?>
