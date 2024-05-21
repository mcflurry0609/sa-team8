<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>拒絕請假緣由</title>
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
            <h2>拒絕請假緣由</h2>
            <form class="form" method="post" action="review.php">
                <div class="">
                    <div class="reject">
                        <div class="title">拒絕緣由：</div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫拒絕緣由" maxlength="30" name="rerejectreasonason" required></textarea>
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
</body>