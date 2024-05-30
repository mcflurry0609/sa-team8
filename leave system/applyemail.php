<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer; // 引入PHPMailer類別
use PHPMailer\PHPMailer\SMTP; // 引入SMTP類別
use PHPMailer\PHPMailer\Exception; // 引入Exception類別

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';


try {
    //Server settings
    $mail->isSMTP(); //用SMTP協定傳送電子郵件
    $mail->Host       = 'smtp.gmail.com'; //SMTP伺服器
    $mail->SMTPAuth   = true; //SMTP認證
    $mail->Username   = 'fjuonlineleavesystem@gmail.com'; //SMTP username 
    $mail->Password   = 'hkem icat vuus yskk'; //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //加密保護
    $mail->Port       = 465; //Port設定

    //Recipients
    $mail->setFrom('fjuonlineleavesystem@gmail.com', '輔仁大學線上請假系統通知'); // 寄件者
    foreach ($prof_emails as $prof_email) {
        $mail->addAddress($prof_email); // 收件者
    }

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = '學生請假申請通知';
    $mail->Body = "教授您好：<br>" .
              "學生 " . $user_name . "提交了一份新的請假申請。" . "<br><br>" .
              "請假申請內容：" . "<br>" .
              "請假學生：" . $user_name . " " . $user_id . "<br>" .
              "請假課程：" . $course_name . "<br>" .
              "請假日期：" . $date . "<br>" .
              "請假節次：" . $Period . "<br>" .
              "請假假別：" . $category_name . "<br>" .
              "請假申請時間：" . $apply_time;

    $mail->AltBody = "教授您好：<br>" .
                    "學生 " . $user_name . "提交了一份新的請假申請。" . "<br><br>" .
                    "請假申請內容：" . "<br>" .
                    "請假學生：" . $user_name . " " . $user_id . "<br>" .
                    "請假課程：" . $course_name . "<br>" .
                    "請假日期：" . $date . "<br>" .
                    "請假節次：" . $Period . "<br>" .
                    "請假假別：" . $category_name . "<br>" .
                    "請假申請時間：" . $apply_time;

    $mail->send();
} catch (Exception $e) {
}
?>
