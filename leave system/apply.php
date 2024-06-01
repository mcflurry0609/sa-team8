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
                            <input type="file" name="proof" class="inputbox" accept=".pdf, .jpg, .png" style="background-color: #fdfdfd; height:27px;" required />
                    </div>
                </div>
                <div class="footer">
                    <a class="nosend" id="changeMindBtn" href="record.php" style="text-decoration-line: none;">改變心意</a>
                    <button type="submit" class="sendout" id="submitBtn">送出申請</button>
                </div>
            </form>
        </div>
    </div>

    <script>
            document.addEventListener("DOMContentLoaded", function() {
            
            const selectedDate = this.value;
            
            const dateInput = document.getElementById('dateInput');//取得日期
            dateInput.addEventListener('change', function() {           //監聽日期
                const selectedDate = this.value; //當前選擇的日期

                
                const xhr = new XMLHttpRequest(); //建立ajax request
                xhr.open('POST', 'getcourse.php', true); //方法post 目的地getcourse.php 設定為非同步請求
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //設定請求頭部，告訴伺服器請求體的內容類型，這裡是表單類型 選擇的日期。
                xhr.onreadystatechange = function() {       //請求的狀態改變就執行
                    if (xhr.readyState === XMLHttpRequest.DONE) {   //請求完成就執行
                        if (xhr.status === 200) {   //200是請求成功
                            //更新課程的下拉式選單
                            const courseSelect = document.getElementById('courseSelect');
                            courseSelect.innerHTML = xhr.responseText;
                        } else {
                            //錯誤時
                            console.error('無法獲得課程資訊');
                        }
                    }
                };
                xhr.send(`date=${selectedDate}`); //傳值選擇的日期
            });

            
            const courseSelect = document.getElementById('courseSelect'); //取得下拉式選單的課程
            courseSelect.addEventListener('change', function() {    //監聽下拉式選單，內容出現變化就執行
                
                const selectedCourseId = this.value; //取得當前選擇課程的id

                
                const xhr = new XMLHttpRequest(); //建立新的ajax請求
                xhr.open('POST', 'getperiod.php', true); // 方法post 目的地getperiod.php 設定為非同步請求
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //設定請求頭部，告訴伺服器請求體的內容類型，這裡是課程id
                xhr.onreadystatechange = function() {       //請求的狀態改變就執行
                    if (xhr.readyState === XMLHttpRequest.DONE) {   //請求完成就執行
                        if (xhr.status === 200) {   //200是請求成功
                            // 更新節次選擇
                            const periodsList = document.getElementById('periodsList');
                            periodsList.innerHTML = xhr.responseText;
                        } else {
                            //錯誤時
                            console.error('無法獲得節次資訊');
                        }
                    }
                };
                xhr.send(`course_id=${selectedCourseId}`);//傳值當前的課程id
            });
        });
    </script>
</body>

</html>