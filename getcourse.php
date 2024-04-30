<?php
// 连接到数据库
$link=mysqli_connect('localhost','root');
mysqli_select_db($link,'leave');

// 检查连接是否成功
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// 从POST请求中获取学生的ID和选择的日期
$user_id = $_SESSION['user_id']; // 这里假设你已经在apply.html中的表单中添加了一个名为'user_id'的隐藏字段，用来存储学生的ID
$date = $_POST['date']; // 这是选定的日期
$date1 = new DateTime('2024-02-26'); // 初始日期
$date2 = new DateTime($date); // 终止日期，假设 $date 是你要比较的日期
// 计算两个日期之间相差的天数
$interval = $date1->diff($date2);
$days = $interval->days;
// 将天数转换为周数
$weeks = floor($days / 7);
// 判断周数是奇数还是偶数


// 编写SQL查询，获取学生在所选日期有哪些课程
$sql = "SELECT DISTINCT c.course_id, c.course_name, c.notice, s.week
        FROM enrollments e
        INNER JOIN courses c ON e.course_id = c.course_id
        INNER JOIN schedule s ON c.course_id = s.course_id
        WHERE e.user_id = '$user_id'
       
        AND  DAYOFWEEK('$date')-1 =  s.weekday_id 
        ";
$result = $link->query($sql);

// 输出选项到HTML的<select>元素中
if ($result->num_rows > 0) {
    echo '<select class="inputbox" id="courseSelect" name="course" onchange="showPeriods(this.value)">';
    echo '<option value="">選擇欲請假的課堂</option>';
    while ($row = $result->fetch_assoc()) {
        if($row['week']==0){
            $week=0;
        }
        else{
            if ($weeks % 2 == 0) {
                $week=2;
            } else {
                $week=1;
            }}
        if($week!=$row['week']){
            continue;
        }
        echo '<option value="' . $row['course_id'] . '">' . $row['course_name'] . '</option>';
    }
    echo '</select>';
} else {
    echo '<select class="inputbox" id="courseSelect" name="course">';
    echo '<option value="">當天沒有課程</option>';
    echo '</select>';
}

// 关闭数据库连接
$link->close();
?>
