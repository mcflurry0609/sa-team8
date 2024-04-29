<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        session_start();
        $user_id=$_POST['id'];
        $password=$_POST['password'];

        $link=mysqli_connect('localhost','root');
        mysqli_select_db($link,'leave');
        $sql="select distinct * from users where user_id='$user_id' and password='$password'";
        //echo $sql;
        $result=mysqli_query($link,$sql);
        if($row=mysqli_fetch_assoc($result)){
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['user_name']=$row['user_name'];
            $_SESSION['role']=$row['role'];
            if ($row['role']=='學生'){
                $redirect_url = "record.php";
            }
            else if ($row['role']=='教授') {
                $redirect_url = "review.php";
            }else{
                
            }
            
            header("Location: $redirect_url");
            exit; 
        }else{
    ?>
        <script>
            alert('查無此帳號與密碼');
            history.back();
        </script>
    <?php
        }
    ?>

</body>
</html>
