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
                    <span class="userword"><a href="person.php"><?php echo $_SESSION['user_name']." ".$_SESSION['role'];?></a></span>
                </div>
                <?php
                    $current_user_id = $_SESSION['user_id'];

                    $link = mysqli_connect('localhost', 'root');
                    mysqli_select_db($link, 'leave');

                    // 檢查連接是否成功
                    if (!$link) {
                        die("連接資料庫失敗: " . mysqli_connect_error());
                    }

                    // 查詢當前使用者是否在courses表格的assistant欄位中
                    $query = "SELECT * FROM courses WHERE assistant = ?";
                    $stmt = mysqli_prepare($link, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $current_user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        // 當前使用者存在於assistant欄位中，顯示表單
                        echo '
                        <form method="post" action="">
                            <input type="hidden" name="current_page" value="' . basename($_SERVER['PHP_SELF']) . '">
                            <button type="submit" name="switch_role" class="switch">
                                <i class="fa-solid fa-repeat"></i>
                                <span class="userword">切換身分</span>
                            </button>
                        </form>';
                    }

                    // 釋放資源並關閉連接
                    mysqli_free_result($result);
                    mysqli_stmt_close($stmt);
                    mysqli_close($link);
                ?>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['switch_role'])) {
                        $current_page = $_POST['current_page'];

                        if ($current_page == 'record.php' || $current_page == 'rules.php') {
                            header('Location: review.php');
                        } elseif ($current_page == 'review.php' || $current_page == 'inclass.php') {
                            header('Location: record.php');
                        }
                        exit();
                    }
                ?>
            </nav>
            <div class="records">
            <?php
                $link=mysqli_connect('localhost','root');
                mysqli_select_db($link,'leave');
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT courses.course_id, courses.course_name, courses.course_class, courses.aon, courses.notice, schedule.week, schedule.weekday_id, 
                GROUP_CONCAT(DISTINCT schedule.period ORDER BY FIELD(schedule.period, 'D1', 'D2', 'D3', 'D4', 'DN', 'D5', 'D6', 'D7') SEPARATOR ' ') AS sorted_periods,
                GROUP_CONCAT(DISTINCT users.user_name SEPARATOR ' ') AS user_names
                FROM courses
                INNER JOIN schedule ON courses.course_id = schedule.course_id
                INNER JOIN courseteacher ON courses.course_id = courseteacher.course_id
                INNER JOIN users ON courseteacher.user_id = users.user_id
                WHERE courses.course_id IN (SELECT DISTINCT course_id FROM courseteacher WHERE user_id = '$user_id')
                GROUP BY courses.course_id
                ORDER BY schedule.weekday_id, FIELD(schedule.period, 'D1', 'D2', 'D3', 'D4',' DN', 'D5', 'D6', 'D7')";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $course_name = $row['course_name'];
                        $course_class = $row['course_class'];
                        $aon = $row['aon'];
                        $week = $row['week'];
                        $weekday_id = $row['weekday_id'];
                        $periods = $row['sorted_periods']; 
                        $user_names = $row['user_names'];
                        $notice = nl2br($row['notice']); 
                        $status = "";
                        $icon_class = "";
                        // 根據 aon 欄位的值顯示相關圖是跟狀態
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
                        // 根據 week 顯示上課的週次
                        $week_text = "";
                        if ($week == 0) {
                            $week_text = "全週";
                        } elseif ($week == 1) {
                            $week_text = "單週";
                        } elseif ($week == 2) {
                            $week_text = "雙週";
                        }

                        $weekday_text = ["未知", "週一", "週二", "週三", "週四", "週五", "週六", "週日"]; //$weekday_text[1]是"週一" $weekday_text[2]是"週二"
                        $weekday_text = isset($weekday_text[$weekday_id]) ? $weekday_text[$weekday_id] : "未知"; //如果$weekday_text[$weekday_id]存在 $weekday_text就設定成$weekday_text[$weekday_id]否則未知
                        $details_html = '';
                        if ($aon == 1) {
                            //開放線上請假 顯示修改按鈕
                            $details_html = '<div class="recorddetails" style="display: none;">
                                    <div class="wrapper3">
                                        <div class="word">
                                            <div>
                                                <h4 class="rules">' . $notice . '</h4>
                                                <h4 class="rules"><i class="fa-solid fa-triangle-exclamation"></i>必須課前請假：事假</h4>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <a href="rulechange.php?course_id=' . $row["course_id"] . '"><h2><i class="fa-solid fa-pen-to-square"></i></h2></a>
                                        </div>
                                    </div>
                                </div>';
                        } elseif ($aon == 2) {
                            // 不開放線上請假 顯示修改按鈕
                            $details_html = '<div class="recorddetails" style="display: none;">
                                    <div class="wrapper3">
                                        <div class="word">
                                            <h4 class="rules">未開放線上請假</h4>
                                        </div>
                                        <div class="item">
                                            <a href="rulechange.php?course_id=' . $row["course_id"] . '"><h2><i class="fa-solid fa-pen-to-square"></i></h2></a>
                                        </div>
                                    </div>
                                </div>';
                        } else {
                            // 如果aon不是1或2，保持原有的按鈕
                            $details_html = '<div class="recorddetails" style="display: none;">
                                    <div class="wrapper2">
                                        <div class="left">
                                            <a href="fillin.php?course_id=' . $row["course_id"] . '"><button class="online">接受線上請假</button></a>
                                        </div>
                                        <div class="right">
                                            <a href="deny.php?course_id=' . $row["course_id"] . '"><button class="noonline">拒絕線上請假</button></a>
                                        </div>
                                    </div>
                                </div>';
                        }

                        echo '<div class="recordcard">' .
                            '<div class="record">' .
                                '<div class="recordtitle">' .
                                    "<h3>$course_name<label for='' class='openclass'>&nbsp;&nbsp;$course_class</label></h3>" .
                                    "<h5>$status</h5>" .
                                    "<i class='fa-solid $icon_class'></i>" .
                                '</div>' .
                                '<div class="timeslot">' .
                                    "<li class='days'>$week_text $weekday_text</li>" . 
                                    "<li class='session'>$periods</li>" . 
                                    "<li>$user_names 教授</li>" . 
                                '</div>' .
                            '</div>' .
                            $details_html . 
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
        // 處理展開請假規則
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
