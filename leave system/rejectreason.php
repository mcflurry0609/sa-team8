<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>拒絕請假緣由</title>
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
            <h2>拒絕請假緣由</h2>
            <form class="form" method="post" action="review.php">
                <div class="formrow">
                <div class="reason">
                        <div class="title">
                            拒絕緣由 :
                        </div>
                        <div class="input">
                            <textarea class="inputbox rejecttextarea" placeholder="請填寫緣由" maxlength="50" name="rejectreason" required></textarea>
                        </div>
                        <button type="submit" class="person" id="submitBtn">確認</button>
                    </div>
</div>
</form>
</div>
</div>
</body>