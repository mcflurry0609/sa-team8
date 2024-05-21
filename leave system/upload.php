<?php
// 检查是否有文件上传
if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // 上传文件的目标文件夹

    // 如果目标文件夹不存在，则创建它
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = $_FILES['proof']['name']; // 获取上传的文件名
    $filePath = $uploadDir . $fileName; // 拼接文件路径

    // 移动上传的文件到目标文件夹
    if (move_uploaded_file($_FILES['proof']['tmp_name'], $filePath)) {
        // 文件上传成功，记录文件名到数据库中
        $docName = $fileName;
        // 连接数据库
        $link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');
        // 检查数据库连接是否成功
        if ($link->connect_error) {
            die("数据库连接失败：" . $link->connect_error);
        }
        // 准备SQL语句，将文件名插入到数据库中
        $sql = "UPDATE applications SET doc_name = '$docName' WHERE application_id = ?";

        // 使用预处理语句防止SQL注入攻击
        $stmt = $link->prepare($sql);
        // 绑定参数
        $stmt->bind_param('i', $applicationId); // 假设application_id是你要记录文件名的那条记录的ID
        // 设置参数值
        $applicationId = $_POST['application_id']; // 假设你通过POST方式传递了application_id
        // 执行SQL语句
        if ($stmt->execute()) {
            echo "文件上传成功，并成功记录到数据库中。";
        } else {
            echo "文件上传成功，但记录到数据库失败：" . $link->error;
        }
        // 关闭数据库连接
        $link->close();
    } else {
        // 文件上传失败
        echo "文件上传失败，请重试。";
    }
} else {
    // 没有文件上传或上传出错
    echo "没有文件上传或上传出错。";
}
?>
