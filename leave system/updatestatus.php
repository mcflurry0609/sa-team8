<?php

if(isset($_GET['id']) && isset($_GET['action'])) {
    
    $application_id = $_GET['id'];
    $action = $_GET['action']; 

    $link = mysqli_connect('localhost', 'root');
    mysqli_select_db($link, 'leave');

    if($action === 'accept') {
        $new_status = '已批准';
    } elseif ($action === 'reject') {
        $new_status = '已拒絕';
    } else {
        echo "批准失敗，請重新批准";
        header("Location: review.php");
        exit();
    }

    $update_query = "UPDATE applications SET status = '$new_status' WHERE application_id = $application_id";
    $update_result = mysqli_query($link, $update_query);

    // Get the user_id, date, course_id, periods, and apply_time from the applications table
    $app_query = "SELECT user_id, date, course_id, periods, apply_time FROM applications WHERE application_id = $application_id";
    $app_result = mysqli_query($link, $app_query);
    $app_data = mysqli_fetch_assoc($app_result);
    $user_id = $app_data['user_id'];
    $date = $app_data['date'];
    $course_id = $app_data['course_id'];
    $periods = $app_data['periods'];
    $apply_time = $app_data['apply_time'];

    // Get the course_name from the courses table
    $course_query = "SELECT course_name FROM courses WHERE course_id = '$course_id'";
    $course_result = mysqli_query($link, $course_query);
    $course_name = mysqli_fetch_assoc($course_result)['course_name'];

    // Get the user_email and notify from the users table
    $email_notify_query = "SELECT user_email, notify FROM users WHERE user_id = '$user_id'";
    $email_notify_result = mysqli_query($link, $email_notify_query);
    $email_notify_data = mysqli_fetch_assoc($email_notify_result);
    $user_email = $email_notify_data['user_email'];
    $notify = $email_notify_data['notify'];

    if ($notify == 1) {
        // Include the statusemail.php file to send the email
        include('statusemail.php');
    }

    if($update_result) {
        header("Location: review.php");
        exit();
    } else {
        echo "批准失敗，請重新批准";
        header("Location: review.php");
        exit();
    }

} else {
    echo "批准失敗，請重新批准";
    header("Location: review.php");
    exit();
}
?>
