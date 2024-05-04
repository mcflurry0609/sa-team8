<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>任課課程</title>
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
                    <li><a href="review.php">請假審核</a></li>
                    <li><a href="inclass.php">任課課程</a></li>
                    <li><a href="logout.php" style="color: #bf1523;">登出</a></li>
                </ul>
            </div>
       
                <nav class="topbar fixed-top">
                    <h2>任課課程</h2>
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
                $query = "SELECT courses.course_id, courses.course_name, courses.course_class, courses.aon, courses.notice, schedule.week, schedule.weekday_id, GROUP_CONCAT(schedule.period SEPARATOR ' ') AS periods, users.user_name
                FROM courseteacher
                INNER JOIN courses ON courseteacher.course_id = courses.course_id
                INNER JOIN schedule ON courseteacher.course_id = schedule.course_id
                INNER JOIN users ON courseteacher.user_id = users.user_id
                WHERE courseteacher.user_id = '$user_id'
                GROUP BY courses.course_id";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    // 顯示每個課程的信息
                    while ($row = mysqli_fetch_assoc($result)) {
                        $course_name = $row['course_name'];
                        $course_class = $row['course_class'];
                        $aon = $row['aon'];
                        $week = $row['week'];
                        $weekday_id = $row['weekday_id'];
                        $periods = $row['periods'];
                        $periods_array = explode(" ", $periods);
                        sort($periods_array);
                        $sorted_periods = implode(" ", $periods_array);
                        $user_name = $row['user_name'];
                        $notice = $row['notice']; // 新增變量 notice
                        // 根據aon欄位的值決定顯示的狀態
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
                        // 根據week和weekday_id動態生成課程時間信息
                        $week_text = "";
                        if ($week == 0) {
                            $week_text = "全週";
                        } elseif ($week == 1) {
                            $week_text = "單週";
                        } elseif ($week == 2) {
                            $week_text = "雙週";
                        }

                        // 根據weekday_id生成星期幾的文本
                        $weekday_text = ["未知", "週一", "週二", "週三", "週四", "週五", "週六", "週日"];
                        $weekday_text = isset($weekday_text[$weekday_id]) ? $weekday_text[$weekday_id] : "未知";

                        // 根據aon值來動態生成課程詳細信息部分
                        $details_html = "";
                        if ($aon == 1) {
                            // 如果aon為1，顯示請假規則和修改鏈接
                            $details_html = '
                                <div class="recorddetails" style="display: none;">
                                    <div class="wrapper3">
                                        <div class="word">
                                            <h4 class="rules">' . $notice . '</h4>
                                        </div>
                                        <div class="item">
                                            <a href="rulechange.php?course_id=' . $row["course_id"] . '"><h2><i class="fa-solid fa-pen-to-square"></i></h2></a>
                                        </div>
                                    </div>
                                </div>
                            ';
                        } elseif ($aon == 2) {
                            // 如果aon為2，顯示相應的消息和修改鏈接
                            $details_html = '
                                <div class="recorddetails" style="display: none;">
                                    <div class="wrapper3">
                                        <div class="word">
                                            <h4 class="rules">未開放線上請假</h4>
                                        </div>
                                        <div class="item">
                                            <a href="rulechange.php?course_id=' . $row["course_id"] . '"><h2><i class="fa-solid fa-pen-to-square"></i></h2></a>
                                        </div>
                                    </div>
                                </div>
                            ';
                        } else {
                            // 如果aon不為1或2，保持原有的按鈕
                            $details_html = '
                                <div class="recorddetails" style="display: none;">
                                    <div class="wrapper2">
                                        <div class="left">
                                            <a href="fillin.php?course_id=' . $row["course_id"] . '"><button class="online">接受線上請假</button></a>
                                        </div>
                                        <div class="right">
                                            <a href="deny.php?course_id=' . $row["course_id"] . '"><button class="noonline">拒絕線上請假</button></a>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }

                        echo '<div class="recordcard">' .
                            '<div class="record">' .
                                '<div class="recordtitle">' .
                                    "<h3>$course_name<label for='' class='openclass'>&nbsp;&nbsp;$course_class</label></h3>" .
                                    "<h5>$status</h5>" .
                                    "<i class='fa-solid $icon_class'></i>" .
                                '</div>' .
                                '<div class="timeslot">' .
                                    "<li class='days'>$week_text $weekday_text</li>" . // 動態生成課程時間部分
                                    "<li class='session'>$sorted_periods</li>" . // 這部分可以替換為實際的課程時間
                                    "<li>$user_name 教授</li>" . // 這部分可以替換為實際的教師名稱
                                '</div>' .
                            '</div>' .
                            $details_html . // 插入動態生成的詳細信息部分
                        '</div>';
                    }
                } else {
                    // 如果沒有找到任何課程信息，顯示相應的消息
                    echo "<p>您尚未任教任何課程。</p>";
                }
                ?>


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

    </script>

</body>

</html>