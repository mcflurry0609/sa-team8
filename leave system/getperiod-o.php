<?php
// 连接到数据库
$link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');



// 检查连接是否成功
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$course_id = $_POST['course_id'];

// SQL 查询，获取选定课程的所有上课时间
$sql = "SELECT DISTINCT period FROM schedule WHERE course_id = '$course_id'";
$result = $conn->query($sql);

// 将查询结果存储到数组中
$periods = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $periods[] = $row['period'];
    }
}

// 将结果以 JSON 格式返回给前端
echo json_encode($periods);

// 关闭数据库连接
$conn->close();

?>
