<?php
// 连接数据库
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// 创建连接
$link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');

// 检查连接
if ($link->connect_error) {
    die("连接失败: " . $link->connect_error);
}

// 获取从前端发送过来的选定的课程ID
$course_id = $_POST['course_id'];

// 构建 SQL 查询语句
$sql = "SELECT period FROM schedule WHERE course_id = '$course_id'";

$result = $link->query($sql);

$periods = array();

if ($result->num_rows > 0) {
    // 输出每一行数据
    while($row = $result->fetch_assoc()) {
        // 将每个课程的课时信息添加到数组中
        $period[] = $row["period"];
    }
} else {
    echo "0 结果";
}

// 关闭连接
$link->close();

// 输出课时信息，以空格隔开
echo implode(" ", $period);
?>
