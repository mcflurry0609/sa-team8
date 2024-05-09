<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>請假申請</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/apply.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        $application_id=$_GET["application_id"];
        $link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');
        $sql = "SELECT * from applications 
                INNER JOIN category USING(category_id) 
                INNER JOIN courses USING(course_id) where application_id='$application_id'";
        $result = mysqli_query($link,$sql);
        if($row=mysqli_fetch_assoc($result)){
            $category_name=$row["category_name"];
            $date = $row['date'];
            $course_name=$row["course_name"];
            $reason=$row["reason"];
            $row["doc_name"];

        }
    ?>
    <div class="layout">
        <div class="wrapper">
            <h2>修改申請</h2>
            <form class="form" enctype="multipart/form-data" action="updating.php" method="post">
                <input type="hidden" name="application_id" value="<?php echo $application_id?>">
                <div class="formrow">
                    <div class="category">
                        <div class="title">
                            申請假別
                            <div class="must">(必填)</div>
                        </div>
                        <div class="input">
                            <select class="inputbox" id="categorySelect" name="category" disabled style="color: black;">
                                <option value="<?php echo $category_name; ?>"><?php echo $category_name; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="date">
                        <div class="title">
                            請假日期
                            <div class="must">(必填)</div>
                        </div>
                        <div class="input">
                            <input type="date" class="inputbox" id="dateInput" name="date" readonly/>
                        </div>
                    </div>
                    <div class="class">
                        <div class="title">
                            請假課堂
                            <div class="must">(必填)</div>
                        </div>
                        <div class="input">
                            <select class="inputbox" id="courseSelect" name="course" disabled style="color: black;">
                                <option value="<?php echo $course_name; ?>"><?php echo $course_name; ?></option>
                            </select>
                        </div>
                        <div class="period" id="periodsList">
                        
                                <?php
                                // 连接数据库
                                $link=mysqli_connect('localhost','root');
                                mysqli_select_db($link,'leave');

                                // 检查连接是否成功
                                if ($link->connect_error) {
                                    die("连接失败: " . $link->connect_error);
                                }

                                // 获取课程的时段
                                $course_id = $row['course_id'];
                                $sql = "SELECT period FROM schedule WHERE course_id = '$course_id'";
                                $result = mysqli_query($link, $sql);
                            
                                // 输出时段的复选框
                                while ($period_row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="sessions" id="periodsList">
                                        <?php
                                    echo "<input type='checkbox' name='periods[]' value='" . $period_row['period'] . "'>" . $period_row['period'] . "<br>";
                                    ?>
                                    </div>
                                    <?php
                                }
                            
                                // 关闭数据库连接
                                mysqli_close($link);
                                ?>
                           
                            </div>
                    </div>
                    <div class="reason">
                        <div class="title">
                            請假緣由
                            <div class="must">(最多30字)</div>
                        </div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫請假原因" maxlength="30" name="reason" required><?php echo $reason; ?></textarea>
                        </div>
                    </div>
                    <div class="file">
                        <div class="title">
                            證明文件
                            <div class="must">(必填)</div>
                        </div>
                        <div class="" action="upload.php" method="post">
                            <input type="file" name="proof" class="inputbox" accept=".pdf, .jpg, .png" style="background-color: #fdfdfd;" required />
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <a class="nosend" id="changeMindBtn" href="record.php" style="text-decoration-line: none;">改變心意</a>
                    <button type="submit" class="sendout" id="submitBtn">送出申請</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        var defaultDate = new Date("<?php echo $date; ?>");
        document.getElementById("dateInput").valueAsDate = defaultDate;
    </script>
</body>
</html>