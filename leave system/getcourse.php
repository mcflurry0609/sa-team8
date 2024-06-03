<?php

$link=mysqli_connect('localhost','root');
mysqli_select_db($link,'leave');

$user_id = $_SESSION['user_id']; 
$date = $_POST['date']; // 選擇的日期
$date1 = new DateTime('2024-02-26'); // 初始日期
$date2 = new DateTime($date); // 終止日期(選擇的日期)

$interval = $date1->diff($date2); // diff回傳的是 dateinterval物件
$days = $interval->days; // 要在這邊換成天數數字

$weeks = floor($days / 7);//判斷是單數週還是雙數週



$sql = "SELECT DISTINCT c.course_id, c.course_name, c.notice, s.week
        FROM enrollments e
        INNER JOIN courses c ON e.course_id = c.course_id
        INNER JOIN schedule s ON c.course_id = s.course_id
        WHERE e.user_id = '$user_id' AND  DAYOFWEEK('$date')-1 =  s.weekday_id ";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    echo '<option value="">選擇欲請假的課堂</option>';
    while ($row = $result->fetch_assoc()) {
        if($row['week']==0){
            $week=0; //全週課程
        }
        else{
            if ($weeks % 2 == 0) {
                $week=2; //雙週上課
            } else {
                $week=1; //單週上課
            }}
        if($week!=$row['week']){ //當前週數跟課程上課週不符合就處理下一筆
            continue;
        }
        echo '<option value="'.$row['course_id'].'">'.$row['course_name'].'</option>'; //生成下拉式選單選項
    }
    echo '</select>';
} else {
    echo '<select class="inputbox" id="courseSelect" name="course">';
    echo '<option value="">當天沒有課程</option>';
    echo '</select>';
}

$link->close();
?>
