<?php
// 创建连接
$link = mysqli_connect('localhost', 'root');
mysqli_select_db($link, 'leave');

// 检查连接
if ($link->connect_error) {
    die("连接失败: " . $link->connect_error);
}

// 获取从前端发送过来的选定的课程ID
$course_id = $_POST['course_id']; // 注意此处改为正确的参数名

// 构建 SQL 查询语句
$sql = "SELECT period FROM schedule WHERE course_id = '$course_id'";

$result = $link->query($sql);

$periods = array();

if ($result->num_rows > 0) {
    // 输出每一行数据
    while ($row = $result->fetch_assoc()) {
        // 将每个课程的课时信息添加到数组中
        $periods = array_merge($periods, explode(',', $row["period"]));
    }
} else {
    echo "0 结果";
}

// 关闭连接
$link->close();

?>

<!-- 输出课时信息，以单选按钮或复选框的形式返回给前端 -->
<?php foreach ($periods as $period) : ?>
    <div class="sessions" id="periodsList">
        <input type="checkbox" name="periods[]" value="<?php echo $period; ?>">
        <label><?php echo $period; ?></label>
    </div>
<?php endforeach; ?>
