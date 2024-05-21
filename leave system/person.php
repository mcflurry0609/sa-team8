<!DOCTYPE html>
<html lang="en">

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
    <style>

    </style>
    <div class="layout">
        <div class="wrapper">
            <h2>個人頁面</h2>
            <form class="form" method="post" action="record.php">
                <div class="">
                    <div class="name formgap">
                        <div class="title">姓名</div>
                        <div class="input">
                            <input type="text" class="inputbox" name="user_name">
                        </div>
                    </div>
                    <div class="id formgap">
                        <div class="title">學號</div>
                        <div class="input">
                            <input type="text" class="inputbox" name="user_id">
                        </div>
                    </div>
                    <div class="role formgap">
                        <div class="title">身分</div>
                        <div class="input">
                            <input type="text" class="inputbox" name="role">
                        </div>
                    </div>
                    <div class="notify formgap">
                        <div class="title">是否希望收到通知</div>
                        <div class="check">
                            <input type="radio" name="" id="on"><label for="on">是</label>
                            <input type="radio" name="" id="off"><label for="off">否</label>
                        </div>
                    </div>
                    <div class="gmail formgap">
                        <div class="title">Gmail</div>
                        <div class="input">
                            <input type="email" class="inputbox" name="gmail">
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <!-- 返回按下去回上一頁 -->
                    <a class="nosend" id="changeMindBtn" href="//" style="text-decoration-line: none;">返回</a>
                    <button type="submit" class="sendout" id="submitBtn">儲存</button>
                </div>
            </form>
        </div>
    </div>
</body>