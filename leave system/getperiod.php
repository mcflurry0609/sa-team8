<?php

$link = mysqli_connect('localhost', 'root');
mysqli_select_db($link, 'leave');

$course_id = $_POST['course_id']; //接課程id的值


$sql = "SELECT s.period, c.aon 
        FROM schedule s
        JOIN courses c ON s.course_id = c.course_id
        WHERE s.course_id = '$course_id'";

$result = $link->query($sql);

$periods = array();


if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        // 檢查課程能不能線上請假
        if ($row['aon'] == 2) {
            echo "不可線上請假";
            break;
        } else {
            $periods = array_merge($periods, explode(',', $row["period"]));//可以請假就輸出節次
        }
    }
} else {
    echo "沒有節次資訊";//找不到period
}


$link->close();

?>

<!-- 把period輸出回前端 -->
<?php foreach ($periods as $period) : ?>
    <div class="sessions" id="periodsList">
        <input type="checkbox" name="periods[]" value="<?php echo $period; ?>">
        <label><?php echo $period; ?></label>
    </div>
<?php endforeach; ?>
