<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>請假申請</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="pic/logoo.jpg" />
    <!-- CSS -->
    <link href="css/apply.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2261b58659.js" crossorigin="anonymous"></script>
</head>

<body>
    
    <div class="layout">
        <div class="wrapper">
            <h2>請假申請</h2>
            <form class="form" enctype="multipart/form-data" action="applying.php" method="post">
                <div class="formrow">
                    <div class="category">
                        <div class="title">
                            申請假別
                            <div class="must">(必填)</div>
                        </div>
                        <div class="input">
                            <select class="inputbox" id="categorySelect" name="category" required>
                                <option value="">選擇假別</option>
                                <option value="1">事假</option>
                                <option value="2">病假</option>
                                <option value="3">喪假</option>
                                <option value="4">生理假</option>
                                <option value="5">陪產假</option>
                                <option value="6">心理假</option>
                                <option value="7">哺育幼兒假</option>
                            </select>
                        </div>
                    </div>
                    <div class="date">
                        <div class="title">
                            請假日期
                            <div class="must">(必填)</div>
                        </div>
                        <div class="input">
                            <input type="date" class="inputbox" id="dateInput" name="date" required />
                        </div>
                    </div>
                    <div class="class">
                        <div class="title">
                            請假課堂
                            <div class="must">(必填)</div>
                        </div>
                        <div class="input">
                            <select class="inputbox" id="courseSelect" name="course" required>
                                <option value="">選擇欲請假的課堂</option>
                            </select>
                        </div>
                        <div class="period" id="periodsList">
                        </div>
                    </div>
                    <div class="reason">
                        <div class="title">
                            請假緣由
                            <div class="must">(最多30字)</div>
                        </div>
                        <div class="input">
                            <textarea class="inputbox textarea" placeholder="請填寫請假原因" maxlength="30" name="reason" required></textarea>
                        </div>
                    </div>
                    <div class="file">
                        <div class="title">
                            證明文件
                            <div class="must">(必填)</div>
                        </div>
                        <div class="" action="upload.php" method="post">
                            <input type="file" name="proof" class="inputbox" accept=".pdf, .jpg, .png" style="background-color: #fdfdfd;" required />
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <a class="nosend" id="changeMindBtn" src="record.php">改變心意</a>
                    <button type="submit" class="sendout" id="submitBtn">送出申請</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        //     document.addEventListener("DOMContentLoaded", function () {
        //         const selectedDate = this.value;
        //     // 监听日期选择框的变化
        //     const dateInput = document.getElementById('dateInput');
        //     dateInput.addEventListener('change', function() {
        //         // 获取选中的日期
        //         const selectedDate = this.value;



        //         // 发送AJAX请求到getcourse.php
        //         const xhr = new XMLHttpRequest();
        //         xhr.open('POST', 'getcourse.php', true);
        //         xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //         xhr.onreadystatechange = function() {
        //             if (xhr.readyState === XMLHttpRequest.DONE) {
        //                 if (xhr.status === 200) {
        //                     // 更新课程选择下拉菜单
        //                     const courseSelect = document.getElementById('courseSelect');
        //                     courseSelect.innerHTML = xhr.responseText;
        //                 } else {
        //                     // 处理错误情况
        //                     console.error('获取课程信息失败');
        //                 }
        //             }
        //         };
        //         xhr.send(`user_id=${userId}&date=${selectedDate}`);
        //     });

        //     // 监听课程选择下拉菜单的变化
        //     const courseSelect = document.getElementById('courseSelect');
        //     courseSelect.addEventListener('change', function() {
        //     // 获取选中的课程ID
        //     const selectedCourseId = this.value;

        //     // 发送 AJAX 请求到getperiod.php
        //     const xhr = new XMLHttpRequest();
        //     xhr.open('POST', 'getperiod.php', true);
        //     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //     xhr.onreadystatechange = function() {
        //     if (xhr.readyState === XMLHttpRequest.DONE) {
        //         if (xhr.status === 200) {
        //             // 更新课时信息选择框
        //             const periodsList = document.getElementById('periodsList');
        //             periodsList.innerHTML = xhr.responseText;
        //         } else {
        //             // 处理错误情况
        //             console.error('获取课时信息失败');
        //         }
        //     }
        //     };
        //     xhr.send(`course_id=${selectedCourseId}`);
        //     });




        //     // 获取按钮元素
        //     var changeMindBtn = document.getElementById("changeMindBtn");
        //     var submitBtn = document.getElementById("submitBtn");

        //     // 为按钮添加点击事件监听器
        //     changeMindBtn.addEventListener("click", function() {
        //         window.location.href = "record.php";
        //     });

        //     submitBtn.addEventListener("click", function() {
        //     // 在这里执行按钮被点击后的操作，比如提交表单
        //     // 例如：document.getElementById("myForm").submit();
        //     // 这里假设你有一个表单，并且表单的 id 是 "myForm"
        //     });

        // });

        document.addEventListener("DOMContentLoaded", function() {
            const userId = localStorage.getItem('user_id');
            const selectedDate = this.value;
            // 监听日期选择框的变化
            const dateInput = document.getElementById('dateInput');
            dateInput.addEventListener('change', function() {
                // 获取选中的日期
                const selectedDate = this.value;

                // 发送AJAX请求到getcourse.php
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'getcourse.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 更新课程选择下拉菜单
                            const courseSelect = document.getElementById('courseSelect');
                            courseSelect.innerHTML = xhr.responseText;
                        } else {
                            // 处理错误情况
                            console.error('获取课程信息失败');
                        }
                    }
                };
                xhr.send(`user_id=${userId}&date=${selectedDate}`);
            });

            // 监听课程选择下拉菜单的变化
            const courseSelect = document.getElementById('courseSelect');
            courseSelect.addEventListener('change', function() {
                // 获取选中的课程ID
                const selectedCourseId = this.value;

                // 发送 AJAX 请求到getperiod.php
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'getperiod.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // 更新课时信息选择框
                            const periodsList = document.getElementById('periodsList');
                            periodsList.innerHTML = xhr.responseText;
                        } else {
                            // 处理错误情况
                            console.error('获取课时信息失败');
                        }
                    }
                };
                xhr.send(`course_id=${selectedCourseId}`);
            });




            // 获取按钮元素
            var changeMindBtn = document.getElementById("changeMindBtn");
            var submitBtn = document.getElementById("submitBtn");

            // 为按钮添加点击事件监听器
            changeMindBtn.addEventListener("click", function() {
                window.location.href = "record.php";
            });

            submitBtn.addEventListener("click", function() {
                // 在这里执行按钮被点击后的操作，比如提交表单
                // 例如：document.getElementById("myForm").submit();
                // 这里假设你有一个表单，并且表单的 id 是 "myForm"
            });

        });
    </script>
</body>

</html>