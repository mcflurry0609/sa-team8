<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>規則修改</title>
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
            <h2>規則修改</h2>
            <form class="form" enctype="multipart/form-data" action="ruleset.php" method="post">
                <?php
                $link = mysqli_connect('localhost', 'root');
                mysqli_select_db($link, 'leave');
                $course_id = $_GET['course_id'];
                $query = "SELECT aon, notice FROM courses WHERE course_id = '$course_id'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $aon = $row['aon'];
                    $notice = $row['notice'];
                    $aon_option1 = '';
                    $aon_option2 = '';
                    // 根據之前的aon顯示選項
                    if ($aon == 1) {
                        $aon_option1 = 'selected';
                    } elseif ($aon == 2) {
                        $aon_option2 = 'selected';
                    }                    
                    echo '<input type="hidden" name="course_id" value="' . $course_id . '"> <!-- 將 course_id 作為隱藏字段傳遞 -->
                        <div class="">
                            <div class="online formgap">
                                <div class="title">
                                    請假課堂
                                    <div class="must">(必填)</div>
                                </div>
                                <div class="input">
                                    <select class="inputbox" id="aon" name="aon" required>
                                        <option value="1" ' . $aon_option1 . '>接受線上請假</option>
                                        <option value="2" ' . $aon_option2 . '>拒絕線上請假</option>
                                    </select>
                                </div>
                            </div>
                            <div class="notice formgap">
                                <div class="title">
                                    請假規則
                                    <div class="must">(最多200字)</div>
                                </div>
                                <div class="input">
                                    <textarea class="inputbox textarea" placeholder="請填寫請假規則" maxlength="200" name="notice" required>' . $notice . '</textarea>
                                </div>
                            </div>
                        </div>';

                    // 假別選項
                    $leave_options = array(
                        array("事假", "1"),
                        array("病假", "2"),
                        array("喪假", "3"),
                        array("生理假", "4"),
                        array("陪產假", "5"),
                        array("心理假", "6"),
                        array("哺育幼兒假", "7")
                    );

                    echo '<div class="beforehand">';

                    // 獲取該課堂的請假規則
                    $rule_query = "SELECT category_id, rule FROM leaverule WHERE course_id = '$course_id'";
                    $rule_result = mysqli_query($link, $rule_query);
                    $rules = array();
                    while ($rule_row = mysqli_fetch_assoc($rule_result)) {
                        $rules[$rule_row['category_id']] = $rule_row['rule'];
                    }

                    // 動態生成每個假別的選項
                    foreach ($leave_options as $option) {
                        [$category_name, $category_id] = $option;
                        $rule_value_0 = '';
                        $rule_value_1 = '';

                        // 根據之前的規則顯示選項
                        if (isset($rules[$category_id])) {
                            if ($rules[$category_id] == 0) {
                                $rule_value_0 = 'selected';
                            } elseif ($rules[$category_id] == 1) {
                                $rule_value_1 = 'selected';
                            }
                        }

                        echo '<div class="' . $category_id . '">
                                <div class="title">' . $category_name . '：</div>
                                <div class="input">
                                    <select class="inputbox" id="categorySelect" name="rules[' . $category_id . ']" required>
                                        <option value="">請選擇</option>
                                        <option value="0" ' . $rule_value_0 . '>必須課前請假</option>
                                        <option value="1" ' . $rule_value_1 . '>無限制</option>
                                    </select>
                                </div>
                              </div>';
                    }
                    echo '</div>';
                }
                ?>

                <div class="footer">
                    <a class="nosend" id="changeMindBtn" href="inclass.php" style="text-decoration-line: none;">改變心意</a>
                    <button type="submit" class="sendout">確認修改</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
