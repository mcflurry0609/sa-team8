<?php
    $link=mysqli_connect('localhost','root');
    mysqli_select_db($link,'leave');
    if (isset($_GET['course_id'])) {
        // Sanitize the input to prevent SQL injection
        $course_id = mysqli_real_escape_string($link, $_GET['course_id']);
    
        // Update the 'aon' field in the 'courses' table for the specified course ID
        $sql = "UPDATE courses SET aon = 2 WHERE course_id = '$course_id'";
        if(mysqli_query($link,$sql)){
            echo 
            '<script>
            alert("已關閉接受線上請假")
            
            location.href = "inclass.php"
            </script>';
        }
        else{
            echo 
            '<script>
            alert("執行失敗")
            location.href = inclass.php"
            </script>';
    
        }
    }else{
        echo 
        '<script>
        alert("執行失敗")
        location.href = inclass.php"
        </script>';

    }
?>
