<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
   <?php include "./head.php" ?>
   <style>
        #main {
            margin:200px auto 0 auto ;
            padding:0;       
        }
        .login__inner{
            margin:0 auto;
            text-align:center;
        }
        .login___form {
        }
        .listStyle {
            list-style:none;
            padding:0;
        }
        .table-input {
            margin:0 auto;
            
        }
        .table-td input{
            width: 350px;
            height : 50px;
            margin:5px;
            
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
   </style>
</head>
<body class="gray">
    <?php include "./header.php" ?>

    <main id="main" class="container">
        <div class="login__inner">
            <h2>로그인</h2>
            <div class="login___form btStyle bmStyle">
                <form action="./connect/login_ok.php" name="loginSave" method="post">
                    <table class="table-input">
                        <tr>
                            <td class="table-td"><input type="text" placeholder="아이디" name="id" class="table-padding"></td>
                        </tr>
                        <tr>
                            <td class="table-td"><input type="password" placeholder="비밀번호" name="password" class="table-padding"></td>
                        </tr>
                        <tr>
                            <td class="table-td td-submit"><input type="submit" vlaue="회원가입" placeholder="회원가입"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="login_footer">
                <ul class="listStyle">
                    <li class="listStyle-ch1">회원가입을 하지 않았다면 회원가입을 먼저 해주세요! <a href="sign.php">회원가입</a></li>
                    <li class="listStyle-ch2">아이디가 기억나지 않는다면! <a href="#">아이디 찾기</a></li>
                    <li class="listStyle-ch3">비밀번호가 기억나지 않는다면! <a href="#">비밀번호 찾기</a></li>
                </ul>
            </div>
        </div>
    </main>
    <!-- //main -->
</body>
</html>