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
</head>

<body>
    
    <div class="layout">
        <div class="wrapper">
            <div class="menu">
                <img src="pic/logo.png" alt=""><br>
                <ul>
                    <li><a href="record.php">請假紀錄</a></li>
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
                        <span class="userid"><?php echo $_SESSION['user_name']." ".$_SESSION['role'];?></span>
                    </div>
                </nav>
                <div class="records">
                    <!-- 搜索框 -->
                    <div class="search-box" style="">
                        <input type="text" id="searchInput" placeholder="依課程名稱、教授姓名等搜尋">
                        <input type="date" id="searchDate">
                        <button onclick="searchRecords()"><i class="fa-solid fa-search"></i></button>
                    </div>

                    <?php 
                        $link=mysqli_connect('localhost','root');
                        mysqli_select_db($link,'leave');
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
                        courses.course_name, category.category_name, users.user_name, courses.course_class 
                        FROM applications 
                        INNER JOIN category USING(category_id) 
                        INNER JOIN courses USING(course_id) 
                        INNER JOIN users ON applications.user_id = users.user_id
                        WHERE applications.user_id = ".$_SESSION['user_id']." ".$status_condition."
                        ORDER BY applications.apply_time DESC";
                        $result=mysqli_query($link,$sql);
                        while($row=mysqli_fetch_assoc($result)){
                            $periods = str_replace('D', ' D', $row["periods"]);
                            $status_icon = '';
                            if($row["status"] == "已批准") {
                                $status_icon = '<i class="fa-solid fa-circle-check"></i>';
                            } elseif ($row["status"] == "已拒絕") {
                                $status_icon = '<i class="fa-solid fa-circle-xmark"></i>';
                            } else {
                                $status_icon = '<i class="fa-solid fa-circle-question"></i>';
                            }
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
                                        <li>'.$row["user_name"].' 教授</li>
                                    </div>
                                    
                                </div>
                                
                                <div class="recorddetails" style="display: none;">
                                    <h4 class="reason"><i class="fa-solid fa-comment"></i>'.$row["reason"].'</h4>
                                    <div class="doc">
                                        <a href="'.$row["doc_name"].'"target="_blank"><i class="fa-solid fa-folder"></i>'.$row["doc_name"].'</a>
                                    </div>
                                    <h5 class="applytime"><i class="fa-solid fa-circle-exclamation"></i>'.$row["apply_time"].' 提出申請</h5> 
                                    <a href="delete.php?application_id='.$row["application_id"].'"><button class="cancel" type="submit" name="cancel">取消申請</button></a>
                                    <a href="alter.php?application_id='.$row["application_id"].'"><button class="alter" type="submit" name="alter">修改申請</button></a>
                                </div>
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
