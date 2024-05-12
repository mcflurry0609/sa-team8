
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>請假紀錄</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/css.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
    <?php

        // 切換身份
        if (isset($_POST['switch_role'])) {
            // 連接到資料庫
            $link=mysqli_connect('localhost','root');
            mysqli_select_db($link,'leave');

           

            // 獲取當前用戶的ID和角色
            $user_id = $_SESSION['user_id'];
            $current_role = $_SESSION['role'];

            // 根據當前身份決定新身份
            $new_role = $current_role == '學生' ? '教授' : '學生';

            // 更新資料庫中的用戶身份
            $sql = "UPDATE users SET role = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "si", $new_role, $user_id);
            mysqli_stmt_execute($stmt);

            // 檢查是否成功更新
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // 更新會話中的身份
                $_SESSION['role'] = $new_role;
                
                // 根據新身份重定向到相應的頁面
                $redirect_page = $new_role == '教授' ? 'review.php' : 'record.php';
                header('Location: ' . $redirect_page);
                exit;
            } else {
                // 處理錯誤情況
                echo "資料庫錯誤: " . mysqli_error($link);
            }

            
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
                    <li><a href="record.php">請假紀錄</a></li>
                    <li><a href="rules.php">請假規則</a></li>
                    <li><a href="logout.php" style="color: #bf1523;">登出</a></li>
                </ul>
            </div>
            <div>
                <nav class="topbar fixed-top">
                    <h2>請假紀錄</h2>
                    <div class="tabs">
                        <a href="?status="><button class="tab <?php if(!isset($_GET['status']) || $_GET['status'] == '') echo 'active'; ?>">全部</button></a>
                        <a href="?status=pending"><button class="tab <?php if(isset($_GET['status']) && $_GET['status'] == 'pending') echo 'active'; ?>">審核中</button></a>
                        <a href="?status=approved"><button class="tab <?php if(isset($_GET['status']) && $_GET['status'] == 'approved') echo 'active'; ?>">已批准</button></a>
                        <a href="?status=rejected"><button class="tab <?php if(isset($_GET['status']) && $_GET['status'] == 'rejected') echo 'active'; ?>">已拒絕</button></a>
                    </div>
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
                    <!-- 搜尋框 -->
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="依課程名稱、教授姓名等搜尋">
                        <input type="date" id="searchDate">
                        <button onclick="searchRecords()"><i class="fa-solid fa-search"></i></button>
                    </div>
                    <?php 
                        $link=mysqli_connect('localhost','root');
                        mysqli_select_db($link,'leave');
                        //篩選請假申請狀態
                        $status_condition = "";
                        if(isset($_GET['status'])){
                            $status = $_GET['status'];
                            if($status == 'pending'){
                                $status_condition = "AND applications.status = '審核中'";
                            } elseif($status == 'approved'){
                                $status_condition = "AND applications.status = '已批准'";
                            } elseif($status == 'rejected'){
                                $status_condition = "AND applications.status = '已拒絕'";
                            } else {
                                
                            }
                        }
                        $sql = "SELECT DISTINCT applications.application_id, applications.user_id, applications.course_id, applications.category_id, applications.date, applications.periods, applications.reason, applications.doc_name, applications.status, applications.apply_time, 
                                courses.course_name, category.category_name, users.user_name AS student_name, courses.course_class,
                                GROUP_CONCAT(teachers.user_name SEPARATOR ' ') AS teacher_names
                                FROM applications 
                                INNER JOIN category USING(category_id) 
                                INNER JOIN courses USING(course_id) 
                                INNER JOIN courseteacher ON applications.course_id = courseteacher.course_id
                                INNER JOIN users ON applications.user_id = users.user_id
                                INNER JOIN users AS teachers ON courseteacher.user_id = teachers.user_id
                                WHERE applications.user_id = ".$_SESSION['user_id']." ".$status_condition."
                                GROUP BY applications.application_id
                                ORDER BY applications.apply_time DESC";
                        $result=mysqli_query($link,$sql);
                        while($row=mysqli_fetch_assoc($result)){
                            $periods = str_replace('D', ' D', $row["periods"]);
                            $status_icon = ''; //根據申請狀態切換圖示跟狀態顯示
                            if($row["status"] == "已批准") {
                                $status_icon = '<i class="fa-solid fa-circle-check"></i>';
                            } elseif ($row["status"] == "已拒絕") {
                                $status_icon = '<i class="fa-solid fa-circle-xmark"></i>';
                            } else {
                                $status_icon = '<i class="fa-solid fa-circle-question"></i>';
                            }
                            $doc_name_display = str_replace('uploads/', '', $row["doc_name"]);
                            echo '<div class="recordcard">
                                <div class="record">
                                    <div class="recordtitle">
                                        <h3>'.$row["course_name"].'<label for="" class="openclass">&nbsp;&nbsp;'.$row["course_class"].'</label></h3>
                                        <h5>'.$row["status"].'</h5>
                                        '.$status_icon.'
                                    </div>
                                    <div class="timeslot">
                                        <li class="days">'.$row["date"]." ".$row["category_name"].'</li>
                                        <li class="session">'.$periods.'</li>
                                        <li>'.$row["teacher_names"] .''." 教授".'</li>
                                    </div>
                                    
                                </div>
                                
                                <div class="recorddetails" style="display: none;">
                                    <h4 class="reason"><i class="fa-solid fa-comment"></i>'.$row["reason"].'</h4>
                                    
                                    <div class="doc">
                                        <a href="'.$row["doc_name"].'" target="_blank"><i class="fa-solid fa-folder"></i>'.$doc_name_display.'</a>
                                    </div>
                                    <h5 class="applytime"><i class="fa-solid fa-circle-exclamation"></i>'.$row["apply_time"].' 提出申請</h5>';
                            // 只有當請假申請的狀態是審核中時，才顯示取消申請的連結
                            if ($row["status"] == "審核中") {
                                echo '<a href="update.php?application_id='.$row["application_id"].'"><button class="alter" type="submit" name="alter">修改申請</button></a>
                                <a href="delete.php?application_id='.$row["application_id"].'"><button class="cancel" type="submit" name="cancel">取消申請</button></a>';
                            }
                            echo '</div>
                            </div>';
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
            // 搜尋框
            var searchInput = document.getElementById("searchInput").value.trim().toLowerCase();
            var searchDate = document.getElementById("searchDate").value;

            // 尋找所有的請假紀錄
            var records = document.querySelectorAll(".recordcard");

            records.forEach(record => {
                // 尋找紀錄中的課程名稱、教授名稱
                var course = record.querySelector(".recordtitle h3").innerText.toLowerCase();
                var student = record.querySelector(".timeslot li:nth-child(3)").innerText.toLowerCase();
                var studentID = record.querySelector(".timeslot li:last-child").innerText.toLowerCase();
                var recordDate = record.querySelector(".timeslot li:first-child").innerText.split(' ')[0]; // 取得紀錄中的日期部分

                // 如果課程名稱、學生名稱或學號包含搜索的字串，並且日期等於搜索的日期，則顯示該紀錄；否則隱藏
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