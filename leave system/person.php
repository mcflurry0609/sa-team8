<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人頁面</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/person.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="layout">
        <div class="wrapper">
            <h2>個人頁面</h2>
            <form class="form" method="post" action="record.php">
                <div class="formrow">
                <div class="reason">
                        <div class="title">
                            姓名
                        </div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫姓名" maxlength="10" name="reason" disabled>魏一凡</textarea>
                        </div>
                        <br>
                        <br>
                        <div class="title">
                            學號
                        </div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫學號" maxlength="9" name="reason" disabled>410401428</textarea>
                        </div>
                        <br>
                        <br>
                        <div class="title">
                            職稱
                        </div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫職稱" maxlength="2" name="reason" disabled>學生</textarea>
                        </div>
                        <br>
                        <br>
                        <div class="title">
                            email
                        </div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫信箱" maxlength="20" name="reason" required>wyfbdm18@gmail.com</textarea>
                        </div>
                        <br>
                        <br>
                        <button type="submit" class="person" id="submitBtn">儲存</button>
                    </div>
</div>
</form>
</div>
</div>
</body>