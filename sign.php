<<<<<<< HEAD
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include "./head.php"; ?>
    <link href="css/sign.css" rel="stylesheet">
<style>
    #main {
        margin:200px auto 0 auto ;
        padding:0; 
    }
    .join__inner{
        margin:0 auto;
        text-align:center;
    }
    .listStyle {
        list-style:none;
        padding:0;
    }
    .table-input {
        margin:0 auto;
    }
    .table-td {
        position: relative;
    }
    .table-td input{
        width: 350px;
        height : 50px;
        margin:5px;
    }
    .error-message {
        color: red;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }
    .table-padding {
        padding-left:10px;
    }
    .td-submit input{
        background-color:#81c408 !important;
        border:0;
        border-radius:4px;
    }
    .listStyle-ch2 {
        padding:5px 0;
    }
    .listStyle-but {
        font-size:12px;
        padding:5px;
        top: 25%;
        position: absolute;
        right: 15px;
        background-color: #81c408 !important;
        border: 0;
        border-radius: 4px;
    }
</style>
</head>
<body class="gray">
    <?php include "./header.php"; ?>

    <main id="main" class="container">
        <!-- intro__inner -->
        
        <div class="join__inner">
            <h2>회원가입</h2>
            <div class="join__form">
                <form action="./connect/sign_ok.php" name="join" method="post" onsubmit="return validateForm()">
                    <table class="table-input">
                        <tr>
                            <td class="table-td">
                                <input type="text" id="id" class="inputStyle table-padding" name="id" placeholder="아이디를 적어주세요!" required>                                
                                <button class="listStyle-but" type="button" id="check_button" onclick="checkid();">중복확인</button>
                                <input type="hidden" name="decide_id" id="decide_id">
                                </br>
                                <span class="error-message" id="idError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="text" id="name" class="inputStyle table-padding" name="name" placeholder="이름을 적어주세요!" required></br>
                                <span class="error-message" id="nameError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="password" id="password" class="inputStyle table-padding" name="password" placeholder="비밀번호를 적어주세요!" required></br>
                                <span class="error-message" id="passwordError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="password" id="repassword" class="inputStyle table-padding" name="repassword" placeholder="비밀번호를 한번 더 적어주세요!" required></br>
                                <span class="error-message" id="repasswordError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="text" id="cell" class="inputStyle table-padding" name="cell" placeholder="연락처를 적어주세요!" oninput="oninputPhone(this)" maxlength="13" required></br>
                                <span class="error-message" id="cellError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td td-submit"><input type="submit" id="td-submit" disabled=true></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
    <!-- //main -->
</body>
</html>
<script>

    function decide() {
        document.getElementById("idError").innerHTML = "<span style='color:blue;'>ID 중복 여부를 확인했습니다.</span>";
        document.getElementById("decide_id").value = document.getElementById("id").value;
        document.getElementById("id").disabled = true;
        document.getElementById("td-submit").disabled = false;
        document.getElementById("check_button").innerText  = "다른 ID로 변경"; // 버튼 텍스트 변경
        document.getElementById("check_button").setAttribute("onclick", "change()");
    }

    function change() {
        document.getElementById("idError").innerHTML = "<span style='color:red;'>ID 중복 여부를 확인해주세요.</span>";
        document.getElementById("id").disabled = false;
        document.getElementById("id").value = "";
        document.getElementById("td-submit").disabled = true;
        document.getElementById("check_button").innerText  = "중복확인"; // 버튼 텍스트 변경
        document.getElementById("check_button").setAttribute("onclick", "checkid()");
    }

    function oninputPhone(target) {
        target.value = target.value
            .replace(/[^0-9]/g, '')
            .replace(/(^02.{0}|^01.{1}|[0-9]{3,4})([0-9]{3,4})([0-9]{4})/g, "$1-$2-$3");
    }

    function checkid(){
        var userid = document.getElementById("id").value;
        if(userid){
            url = "check.php?id="+userid;
            window.open(url,"chkid","width=400,height=200");
        }else {
            alert("아이디를 입력하세요");
        }
    }

    function validateForm() {
        let isValid = true;

        // Clear previous error messages
        document.getElementById('idError').textContent = '';
        document.getElementById('nameError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('repasswordError').textContent = '';
        document.getElementById('cellError').textContent = '';

        // Validate ID
        const id = document.getElementById('id').value;
        if (id.length < 3) {
            document.getElementById('idError').textContent = '아이디는 3자 이상이어야 합니다.';
            isValid = false;
        }

        // Validate Name
        const name = document.getElementById('name').value;
        const namePattern = /^[가-힣]{2,4}$/;
        if (!namePattern.test(name)) {
            document.getElementById('nameError').textContent = '이름은 한글로 2자 이상 5자 미만이어야 합니다.';
            isValid = false;
        }

        // Validate Password
        const password = document.getElementById('password').value;
        if (password.length < 6) {
            document.getElementById('passwordError').textContent = '비밀번호는 6자 이상이어야 합니다.';
            isValid = false;
        }

        // Validate Repassword
        const repassword = document.getElementById('repassword').value;
        if (password !== repassword) {
            document.getElementById('repasswordError').textContent = '비밀번호가 일치하지 않습니다.';
            isValid = false;
        }

        // Validate Cell
        const cell = document.getElementById('cell').value;
        const cellPattern = /^\d{2,3}-\d{3,4}-\d{4}$/;
        if (!cellPattern.test(cell)) {
            document.getElementById('cellError').textContent = '올바른 연락처 형식이 아닙니다.';
            isValid = false;
        }

        return isValid;
    }
</script>
=======
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include "./head.php"; ?>
    <link href="css/sign.css" rel="stylesheet">
<style>
    #main {
        margin:200px auto 0 auto ;
        padding:0; 
    }
    .join__inner{
        margin:0 auto;
        text-align:center;
    }
    .listStyle {
        list-style:none;
        padding:0;
    }
    .table-input {
        margin:0 auto;
    }
    .table-td {
        position: relative;
    }
    .table-td input{
        width: 350px;
        height : 50px;
        margin:5px;
    }
    .error-message {
        color: red;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }
    .table-padding {
        padding-left:10px;
    }
    .td-submit input{
        background-color:#81c408 !important;
        border:0;
        border-radius:4px;
    }
    .listStyle-ch2 {
        padding:5px 0;
    }
    .listStyle-but {
        font-size:12px;
        padding:5px;
        top: 25%;
        position: absolute;
        right: 15px;
        background-color: #81c408 !important;
        border: 0;
        border-radius: 4px;
    }
</style>
</head>
<body class="gray">
    <?php include "./header.php"; ?>

    <main id="main" class="container">
        <!-- intro__inner -->
        
        <div class="join__inner">
            <h2>회원가입</h2>
            <div class="join__form">
                <form action="./connect/sign_ok.php" name="join" method="post" onsubmit="return validateForm()">
                    <table class="table-input">
                        <tr>
                            <td class="table-td">
                                <input type="text" id="id" class="inputStyle table-padding" name="id" placeholder="아이디를 적어주세요!" required>                                
                                <button class="listStyle-but" type="button" id="check_button" onclick="checkid();">중복확인</button>
                                <input type="hidden" name="decide_id" id="decide_id">
                                </br>
                                <span class="error-message" id="idError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="text" id="name" class="inputStyle table-padding" name="name" placeholder="이름을 적어주세요!" required></br>
                                <span class="error-message" id="nameError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="password" id="password" class="inputStyle table-padding" name="password" placeholder="비밀번호를 적어주세요!" required></br>
                                <span class="error-message" id="passwordError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="password" id="repassword" class="inputStyle table-padding" name="repassword" placeholder="비밀번호를 한번 더 적어주세요!" required></br>
                                <span class="error-message" id="repasswordError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td">
                                <input type="text" id="cell" class="inputStyle table-padding" name="cell" placeholder="연락처를 적어주세요!" oninput="oninputPhone(this)" maxlength="13" required></br>
                                <span class="error-message" id="cellError"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table-td td-submit"><input type="submit" id="td-submit" disabled=true></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>
    <!-- //main -->
</body>
</html>
<script>

    function decide() {
        document.getElementById("idError").innerHTML = "<span style='color:blue;'>ID 중복 여부를 확인했습니다.</span>";
        document.getElementById("decide_id").value = document.getElementById("id").value;
        document.getElementById("id").disabled = true;
        document.getElementById("td-submit").disabled = false;
        document.getElementById("check_button").innerText  = "다른 ID로 변경"; // 버튼 텍스트 변경
        document.getElementById("check_button").setAttribute("onclick", "change()");
    }

    function change() {
        document.getElementById("idError").innerHTML = "<span style='color:red;'>ID 중복 여부를 확인해주세요.</span>";
        document.getElementById("id").disabled = false;
        document.getElementById("id").value = "";
        document.getElementById("td-submit").disabled = true;
        document.getElementById("check_button").innerText  = "중복확인"; // 버튼 텍스트 변경
        document.getElementById("check_button").setAttribute("onclick", "checkid()");
    }

    function oninputPhone(target) {
        target.value = target.value
            .replace(/[^0-9]/g, '')
            .replace(/(^02.{0}|^01.{1}|[0-9]{3,4})([0-9]{3,4})([0-9]{4})/g, "$1-$2-$3");
    }

    function checkid(){
        var userid = document.getElementById("id").value;
        if(userid){
            url = "check.php?id="+userid;
            window.open(url,"chkid","width=400,height=200");
        }else {
            alert("아이디를 입력하세요");
        }
    }

    function validateForm() {
        let isValid = true;

        // Clear previous error messages
        document.getElementById('idError').textContent = '';
        document.getElementById('nameError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('repasswordError').textContent = '';
        document.getElementById('cellError').textContent = '';

        // Validate ID
        const id = document.getElementById('id').value;
        if (id.length < 3) {
            document.getElementById('idError').textContent = '아이디는 3자 이상이어야 합니다.';
            isValid = false;
        }

        // Validate Name
        const name = document.getElementById('name').value;
        const namePattern = /^[가-힣]{2,4}$/;
        if (!namePattern.test(name)) {
            document.getElementById('nameError').textContent = '이름은 한글로 2자 이상 5자 미만이어야 합니다.';
            isValid = false;
        }

        // Validate Password
        const password = document.getElementById('password').value;
        if (password.length < 6) {
            document.getElementById('passwordError').textContent = '비밀번호는 6자 이상이어야 합니다.';
            isValid = false;
        }

        // Validate Repassword
        const repassword = document.getElementById('repassword').value;
        if (password !== repassword) {
            document.getElementById('repasswordError').textContent = '비밀번호가 일치하지 않습니다.';
            isValid = false;
        }

        // Validate Cell
        const cell = document.getElementById('cell').value;
        const cellPattern = /^\d{2,3}-\d{3,4}-\d{4}$/;
        if (!cellPattern.test(cell)) {
            document.getElementById('cellError').textContent = '올바른 연락처 형식이 아닙니다.';
            isValid = false;
        }

        return isValid;
    }
</script>
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
