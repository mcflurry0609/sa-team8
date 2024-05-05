
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>請假規則</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/css.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>

<body>
    
    <div class="layout">
        <div class="wrapper">
            <div class="menu">
                <img src="pic/logo.png" alt=""><br>
                <ul>
                    <li><a href="record.php">請假紀錄</a></li>
                    <li><a href="rules.php">請假規則</a></li>
                    <li><a href="logout.php" style="color: #bf1523;">登出</a></li>
                </ul>
            </div>
            <div>
                <nav class="topbar fixed-top">
                    <h2>請假規則</h2>
                    <div class="user">
                        <i class="fa-regular fa-user"></i>
                        <span class="userid"><?php echo $_SESSION['user_name']." ".$_SESSION['role'];?></span>
                    </div>
                </nav>
                <div class="records">
                    
                <?php
                    $link=mysqli_connect('localhost','root');
                    mysqli_select_db($link,'leave');
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT 
                                courses.course_name,
                                courses.course_class,
                                courses.aon,
                                courses.notice,
                                schedule.week,
                                schedule.weekday_id,
                                GROUP_CONCAT(DISTINCT users.user_name ORDER BY users.user_name SEPARATOR ', ') AS user_names,
                                GROUP_CONCAT(DISTINCT schedule.period ORDER BY schedule.period SEPARATOR ' ') AS sorted_periods
                            FROM 
                                enrollments
                            JOIN 
                                courses ON enrollments.course_id = courses.course_id
                            JOIN 
                                courseteacher ON courses.course_id = courseteacher.course_id
                            JOIN 
                                users ON courseteacher.user_id = users.user_id
                            LEFT JOIN 
                                schedule ON courses.course_id = schedule.course_id
                            WHERE 
                                enrollments.user_id = '$user_id'
                            GROUP BY 
                                courses.course_id
                            ORDER BY 
                                schedule.weekday_id, FIELD(schedule.period, 'D1', 'D2', 'D3', 'D4', 'D5', 'D6', 'D7')";
                    $result = mysqli_query($link, $query);

                    if (mysqli_num_rows($result) > 0) {
                        // 顯示每個課程的信息
                        while ($row = mysqli_fetch_assoc($result)) {
                            $course_name = $row['course_name'];
                            $course_class = $row['course_class'];
                            $aon = $row['aon'];
                            $week = $row['week'];
                            $weekday_id = $row['weekday_id'];
                            $periods = $row['sorted_periods']; // 注意這裡修改為 sorted_periods
                            $user_names = $row['user_names']; // 獲取多個教授的名字
                            $notice = $row['notice']; // 新增變量 notice
                            // 根據 aon 欄位的值決定顯示的狀態
                            $status = "";
                            $icon_class = "";
                            if ($aon == 0) {
                                $status = "尚未設定";
                                $icon_class = "fa-circle-question";
                            } elseif ($aon == 1) {
                                $status = "接受線上請假";
                                $icon_class = "fa-circle-check";
                            } elseif ($aon == 2) {
                                $status = "拒絕線上請假";
                                $icon_class = "fa-circle-xmark";
                            }
                            // 根據 week 和 weekday_id 動態生成課程時間信息
                            $week_text = "";
                            if ($week == 0) {
                                $week_text = "全週";
                            } elseif ($week == 1) {
                                $week_text = "單週";
                            } elseif ($week == 2) {
                                $week_text = "雙週";
                            }

                    // 根據 weekday_id 生成星期幾的文本
                    $weekday_text = ["未知", "週一", "週二", "週三", "週四", "週五", "週六", "週日"];
                    $weekday_text = isset($weekday_text[$weekday_id]) ? $weekday_text[$weekday_id] : "未知";
                    $details_html = "";
                    if ($aon == 1) {
                        // 如果 aon 為 1，顯示請假規則和修改鏈接
                        $details_html = '<div class="recorddetails" style="display: none;">
                                            <h4 class="rules">'.$notice.'</h4>
                                        </div>';
                    } elseif ($aon == 2) {
                        // 如果 aon 為 2，顯示相應的消息和修改鏈接
                        $details_html = '<div class="recorddetails" style="display: none;">
                                            <h4 class="rules">教授拒絕線上請假</h4>
                                        </div>';
                    } else {
                        // 如果 aon 不為 1 或 2，保持原有的按鈕
                        $details_html = '<div class="recorddetails" style="display: none;">
                                            <h4 class="rules">教授尚未設定請假規定</h4>
                                        </div>';
                    }
                    echo'<div class="recordcard">' .
                            '<div class="record">' .
                                '<div class="recordtitle">' .
                                    "<h3>$course_name<label for='' class='openclass'>&nbsp;&nbsp;$course_class</label></h3>" .
                                    "<h5>$status</h5>" .
                                    "<i class='fa-solid $icon_class'></i>" .
                                '</div>'.
                            '<div class="timeslot">'.
                                "<li class='days'>$week_text $weekday_text</li>" .
                                "<li class='session'>$periods</li>" . // 注意這裡修改為 $periods
                                "<li>$user_names 教授</li>" .
                            '</div>'.
                        '</div>'.
                            $details_html . // 注意這裡修改為 $details_html
                        '</div>';
                        }
                    } else {
                        // 如果沒有找到任何課程信息，顯示相應的消息
                        echo "<p>您尚未任教任何課程。</p>";
                    }
                ?>

                    

                    


                </div>
                <div class="apply">
                    <a href="apply.php" class="applybtn" style="color: #fdfdfd;">請假申請</a>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const record = document.querySelectorAll(".record");

            record.forEach(title => {
                title.addEventListener("click", function () {
                    const details = this.nextElementSibling;
                    details.style.display = details.style.display === "none" ? "block" : "none";
                   
                });
            });
        });

        function searchRecords() {
            // 获取输入框的值
            var searchInput = document.getElementById("searchInput").value.trim().toLowerCase();
            var searchDate = document.getElementById("searchDate").value;

            // 获取所有的請假紀錄
            var records = document.querySelectorAll(".recordcard");

            records.forEach(record => {
                // 获取紀錄中的課程名稱、學生名稱和學號
                var course = record.querySelector(".recordtitle h3").innerText.toLowerCase();
                var student = record.querySelector(".timeslot li:nth-child(3)").innerText.toLowerCase();
                var studentID = record.querySelector(".timeslot li:last-child").innerText.toLowerCase();
                var recordDate = record.querySelector(".timeslot li:first-child").innerText.split(' ')[0]; // 取得紀錄中的日期部分

                // 如果課程名稱、學生名稱或學號包含搜索的字符串，並且日期等於搜索的日期，則顯示該紀錄；否則隱藏
                if ((course.includes(searchInput) || student.includes(searchInput) || studentID.includes(searchInput)) && (searchDate === '' || recordDate === searchDate)) {
                    record.style.display = "block";
                } else {
                    record.style.display = "none";
                }
            });
        }


    </script>

</body>

</html>
