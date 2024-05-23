<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人頁面</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/apply.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        session_start();
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $role = $_SESSION['role'];

        $link = mysqli_connect('localhost', 'root', '', 'leave');
        if (!$link) {
            die("連接失敗：" . mysqli_connect_error());
        }

        $sql = "SELECT * FROM users WHERE user_id='$user_id'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);

        mysqli_close($link);
    ?>
    <div class="layout">
        <div class="wrapper">
            <h2>個人頁面</h2>
            <form class="form" method="post" action="update_person.php">
                <div class="">
                    <div class="name formgap">
                        <div class="title">姓名</div>
                        <div class="input">
                            <input type="text" class="inputbox" name="user_name" value="<?php echo $row['user_name']; ?>" readonly>
                        </div>
                    </div>
                    <div class="id formgap">
                        <div class="title">學號</div>
                        <div class="input">
                            <input type="text" class="inputbox" name="user_id" value="<?php echo $row['user_id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="role formgap">
                        <div class="title">身分</div>
                        <div class="input">
                            <input type="text" class="inputbox" name="role" value="<?php echo $row['role']; ?>" readonly>
                        </div>
                    </div>
                    <div class="notify formgap">
                        <div class="title">是否希望收到通知</div>
                        <div class="input">
                            <select class="check inputbox" name="notify" onchange="checkEmail(this)">
                                <option value="yes" <?php if ($row['notify'] == 1 ) echo 'selected'; ?>>是</option>
                                <option value="no" <?php if ($row['notify'] == 0 ) echo 'selected'; ?>>否</option>
                            </select>
                        </div>                       
                    </div>
                    <div class="email formgap">
                        <div class="title">Email</div>
                        <div class="input">
                            <input type="email" class="inputbox" name="email" value="<?php echo $row['user_email']; ?>" <?php if ($row['notify'] == 1) echo 'required'; ?>>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <a class="nosend" id="changeMindBtn" href="javascript:history.back()" style="text-decoration-line: none;">返回</a>
                    <button type="submit" class="sendout" id="submitBtn">儲存</button>
                </div>
            </form>
            <script>
                function checkEmail(selectObj) {
                    var emailInput = document.getElementsByName('email')[0];
                    if (selectObj.value === 'yes') {
                        emailInput.required = true;
                    } else {
                        emailInput.required = false;
                    }
                }
                document.addEventListener('DOMContentLoaded', function () {
                    checkEmail(document.getElementsByName('notify')[0]);
                });
            </script>
        </div>
    </div>
</body>

</html>

