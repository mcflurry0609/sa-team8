<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>規則修改</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/notice.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="layout">
        <div class="wrapper">
            <h2>規則修改</h2>
            <form class="form" enctype="multipart/form-data" action="ruleset.php" method="post">
                <?php
                $link = mysqli_connect('localhost', 'root');
                mysqli_select_db($link, 'leave');
                $course_id = $_GET['course_id'];
                $query = "SELECT aon, notice FROM courses WHERE course_id = '$course_id'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $aon = $row['aon'];
                    $notice = $row['notice'];
                    // 根據 aon 的值動態生成選項
                    $aon_option1 = '';
                    $aon_option2 = '';
                    if ($aon == 1) {
                        $aon_option1 = 'selected';
                    } elseif ($aon == 2) {
                        $aon_option2 = 'selected';
                    }                    
                    echo '
                        <input type="hidden" name="course_id" value="' . $course_id . '"> <!-- 將 course_id 作為隱藏字段傳遞 -->
                        <div class="formrow">
                            <div class="class">
                            <div class="title">
                                請假課堂
                                <div class="must">(必填)</div>
                            </div>
                            <div class="input">
                                <select class="inputbox" id="aon" name="aon" required>
                                    <option value="1" ' . $aon_option1 . '>接受線上請假</option>
                                    <option value="2" ' . $aon_option2 . '>拒絕線上請假</option>
                                </select>
                            </div>
                        </div>
                            <div class="reason">
                                <div class="title">
                                    請假規則
                                    <div class="must">(最多200字)</div>
                                </div>
                                <div class="input">
                                    <textarea class="inputbox textarea" placeholder="請填寫請假規則" maxlength="200" name="notice" required>' . $notice . '</textarea>
                                </div>
                            </div>
                        </div>
                    ';
                }
                ?>
                <div class="footer">
                    <a class="nosend" id="changeMindBtn" href="inclass.php">改變心意</a>
                    <button type="submit" class="sendout">確認修改</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
