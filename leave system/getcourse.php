getcourse.php
<?php
// 连接到数据库
$link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');



// 检查连接是否成功
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// 从POST请求中获取学生的ID和选择的日期
$user_id = $_POST['user_id']; // 这里假设你已经在apply.html中的表单中添加了一个名为'user_id'的隐藏字段，用来存储学生的ID
$date = $_POST['date']; // 这是选定的日期

// 编写SQL查询，获取学生在所选日期有哪些课程
$sql = "SELECT DISTINCT c.course_id, c.course_name, c.notice, s.week
        FROM enrollments e
        INNER JOIN courses c ON e.course_id = c.course_id
        INNER JOIN schedule s ON c.course_id = s.course_id
        WHERE e.user_id = '$user_id'
        AND (
            (s.week = 0) OR 
            (s.week = 1 AND WEEK('$date', 1) % 2 = 1) OR 
            (s.week = 2 AND WEEK('$date', 1) % 2 = 0)
        )
        AND CASE 
            WHEN DAYOFWEEK('$date') = 1 THEN s.weekday_id = 7
            ELSE s.weekday_id = DAYOFWEEK('$date') - 1
        END";
$result = $link->query($sql);

// 输出选项到HTML的<select>元素中
if ($result->num_rows > 0) {
    echo '<option value="">選擇欲請假的課堂</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
    }
} else {
    echo '<option value="">當天沒有課程</option>';
}

// 关闭数据库连接
$link->close();
?>