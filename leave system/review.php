<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>請假審核</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/css.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php 
        session_start();
    ?>
    <div class="layout">
        <div class="wrapper">
            <div class="menu">
                <img src="pic/logo.png" alt=""><br>
                <ul>
                    <li><a href="review.php">請假審核</a></li>
                    <li><a href="logout.php" style="color: #bf1523;">登出</a></li>
                </ul>
            </div>
            <div>
                <nav class="topbar fixed-top">
                    <h2>請假審核</h2>
                    <div class="tabs">
                    <a href="?status="><button id="allBtn" class="tab <?php if(!isset($_GET['status']) || $_GET['status'] == '') echo 'active'; ?>">全部</button></a>
                    <a href="?status=pending"><button id="pendingBtn" class="tab <?php if(isset($_GET['status']) && $_GET['status'] == 'pending') echo 'active'; ?>">審核中</button></a>
                    <a href="?status=approved"><button id="approvedBtn" class="tab <?php if(isset($_GET['status']) && $_GET['status'] == 'approved') echo 'active'; ?>">已批准</button></a>
                    <a href="?status=rejected"><button id="rejectedBtn" class="tab <?php if(isset($_GET['status']) && $_GET['status'] == 'rejected') echo 'active'; ?>">已拒絕</button></a>


                    </div>
                    <div class="user">
                        <i class="fa-regular fa-user"></i>
                        <span class="userid"><?php echo $_SESSION['user_name']." ".$_SESSION['role'];?></span>
                    </div>
                </nav>
                <div class="records">
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
                    INNER JOIN courseteacher USING(course_id) 
                    INNER JOIN category USING(category_id) 
                    INNER JOIN schedule USING(course_id) 
                    INNER JOIN courses USING(course_id) 
                    INNER JOIN users ON applications.user_id = users.user_id
                    WHERE courseteacher.user_id = ".$_SESSION['user_id']." ".$status_condition;
                    $result=mysqli_query($link,$sql);
                    while($row=mysqli_fetch_assoc($result)){
                        $periods = str_replace('D', ' D', $row["periods"]);
                        $status_icon = '';
                        $status_icon = '';
                        if($row["status"] == "已批准") {
                            $status_icon = '<i class="fa-solid fa-circle-check"></i>';
                            $accept_btn_style = 'style="display: none;"';
                            $reject_btn_style = 'style="display: none;"';
                        } elseif ($row["status"] == "已拒絕") {
                            $status_icon = '<i class="fa-solid fa-circle-xmark"></i>';
                            $accept_btn_style = 'style="display: none;"';
                            $reject_btn_style = 'style="display: none;"';
                        } else {
                            $status_icon = '<i class="fa-solid fa-circle-question"></i>';
                            $accept_btn_style = '';
                            $reject_btn_style = '';
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
                                    <li>'.$row["user_name"].' 學生</li>
                                </div>
                            </div>
                            <div class="recorddetails" style="display: none;">
                                <h4 class="reason">'.$row["reason"].'</h4>
                                <div class="doc">
                                    <a href="uploads/'.$row["doc_name"].'"target="_blank"><i class="fa-solid fa-folder"></i>'.$row["doc_name"].'</a>
                                </div>
                                <h5 class="applytime">'.$row["apply_time"].' 提出申請</h5>
                                
                                <a href="updatestatus.php?id='.$row["application_id"].'&action=accept"'.$accept_btn_style.'><button class="accept" type="submit" name="accept">接受申請</button></a>
                                <a href="updatestatus.php?id='.$row["application_id"].'&action=reject"'.$reject_btn_style.'><button class="reject" type="submit" name="reject">拒絕申請</button></a>

                                
                            </div>
                        </div>';
                    }
                ?>
                
                    
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
    
    </script>

</body>

</html>