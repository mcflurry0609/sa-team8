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
    <?php
        // 檢查是否有切換身份的請求
        if (isset($_POST['switch_role'])) {
            // 連接到資料庫
            $link = mysqli_connect('localhost', 'root', '', 'leave');

            // 檢查連接
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // 獲取當前用戶的ID和角色
            $user_id = $_SESSION['user_id'];
            $current_role = $_SESSION['role'];

            // 根據當前角色決定新角色
            $new_role = $current_role == '學生' ? '教授' : '學生';

            // 更新資料庫中的用戶角色
            $sql = "UPDATE users SET role = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "si", $new_role, $user_id);
            mysqli_stmt_execute($stmt);

            // 檢查是否成功更新
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // 更新會話中的角色
                $_SESSION['role'] = $new_role;
                
                // 根據新角色重定向到相應的頁面
                $redirect_page = $new_role == '教授' ? 'review.php' : 'record.php';
                header('Location: ' . $redirect_page);
                exit;
            } else {
                // 處理錯誤情況
                echo "Error updating record: " . mysqli_error($link);
            }

            // 關閉語句和連接
            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }
    ?>
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
                    <span class="userword"><?php echo $_SESSION['user_name']." ".$_SESSION['role'];?></span>
                </div>
                <form method="post" action="">
                    <button type="submit" name="switch_role" class="switch">
                        <i class="fa-solid fa-repeat"></i>
                        <span class="userword">切換身分</span>
                    </button>
                </form>
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
                        $notice = $row['notice']; 
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
                        $details_html = "";
                        if ($aon == 1) {
                            //開放線上請假 顯示修改按鈕
                            $details_html = '<div class="recorddetails" style="display: none;">
                                    <div class="wrapper3">
                                        <div class="word">
                                            <h4 class="rules">' . $notice . '</h4>
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