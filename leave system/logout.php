<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $_SESSION['user_id']="";
        $_SESSION['user_name']="";
        $_SESSION['role']="";
        $redirect_url = "login.html";
        header("Location: $redirect_url");
        exit;
    ?>
</body>
</html>