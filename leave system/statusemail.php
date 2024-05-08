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
    $mail->addAddress($user_email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = '請假申請狀態更新';
    $mail->Body = "您好：<br>" .
               "您的請假申請審核狀態已更新為 " . $new_status . "。<br><br>" .
               "請假申請內容：<br>" .
               "請假課程：" . $course_name . "<br>" .
               "請假日期：" . $date . "<br>" .
               "請假節次：" . $periods . "<br>" .
               "請假申請時間：" . $apply_time . "<br>" .
               "請假審核狀態：" . $new_status;
    $mail->AltBody = "您好：<br>" .
                "您的請假申請審核狀態已更新為「" . $new_status . "」。<br><br>" .
                "請假申請內容：<br>" .
                "請假課程：" . $course_name . "<br>" .
                "請假日期：" . $date . "<br>" .
                "請假節次：" . $periods . "<br>" .
                "請假申請時間：" . $apply_time . "<br>" .
                "請假審核狀態：" . $new_status;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
