<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';


try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'fjuonlineleavesystem@gmail.com';                     //SMTP username
    $mail->Password   = 'hkem icat vuus yskk';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('fjuonlineleavesystem@gmail.com', '輔仁大學線上請假系統通知');
    $mail->addAddress($prof_email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
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
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
