<?php
session_start();

if(isset($_GET['id']) && isset($_GET['action'])) {
    
    $application_id = $_GET['id'];
    $action = $_GET['action']; 

    
    $link=mysqli_connect('localhost','root');
    mysqli_select_db($link,'leave');

    
    if($action === 'accept') {
        $new_status = '已批准';
    } elseif ($action === 'reject') {
        $new_status = '已拒絕';
    } else {
        echo "批准失敗，請重新批准";
        header("Location: review.php");
    }

    
    $update_query = "UPDATE applications SET status = '$new_status' 
                    WHERE application_id = $application_id";
    $update_result = mysqli_query($link, $update_query);

    
    if($update_result) {
        if($action === 'reject') {
            header("Location: rejectreason.php");
            exit(); 
        }
        else{
            header("Location: review.php");
            exit();
        }
    } else {
        echo "批准失敗，請重新批准";
        header("Location: review.php");
    }

} else {
    echo "批准失敗，請重新批准";
    header("Location: review.php");
}
?>
