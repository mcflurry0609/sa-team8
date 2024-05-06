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
                    <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>"> <!-- 將 course_id 作為隱藏字段傳遞 -->
                    <div class="formrow">
                        <div class="class">
                            <div class="title">
                                請假課堂
                                <div class="must">(必填)</div>
                            </div>
                            <div class="input">
                                <select class="inputbox" id="aon" name="aon" required>
                                    <option value="">選擇是否接受學生線上請假</option>
                                    <option value="1">接受線上請假</option>
                                    <option value="2">拒絕線上請假</option>
                                </select>
                            </div>
                        </div>
                        <div class="reason">
                            <div class="title">
                                請假規則
                                <div class="must">(最多200字)</div>
                            </div>
                            <div class="input">
                                <textarea class="inputbox textarea" placeholder="請填寫請假規則" maxlength="200" name="notice" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <a class="nosend" id="changeMindBtn" href="inclass.php">改變心意</a>
                        <button type="submit" class="sendout">確認修改</button>
                    </div>
                </form>
        </div>
    </div>
</body>
</html>
