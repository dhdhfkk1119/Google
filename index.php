<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .header {
            position: absolute;
            top: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        .header a {
            text-decoration: none;
            color: var(--COEmY);
            margin: 0 10px;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .header .left {
            display: flex;
            padding:14px;
        }
        .header .right {
            display: flex;
            padding:14px;
            align-items: center;
        }
        .logo a{
            text-decoration:none;
            color: #4285F4;
        }
        .logo {
            font-size: 80px;
            font-weight: bold;
            color: #4285F4;
            margin-bottom: 20px;
        }
        .logo span:nth-child(2) { color: #EA4335; }
        .logo span:nth-child(3) { color: #FBBC05; }
        .logo span:nth-child(4) { color: #4285F4; }
        .logo span:nth-child(5) { color: #34A853; }
        .logo span:nth-child(6) { color: #EA4335; }
        .search-container {
            position: relative;
            width: 580px;
        }
        .search-box {
            width: 100%;
            padding: 13px 0;
            text-indent: 40px;
            font-size: 16px;
            border: 1px solid #dfe1e5;
            border-radius: 24px;
            outline: none;
            box-shadow: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* 그림자 추가 */
        }
        .search-icon, .keyboard-icon, .mic-icon , .photo-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        .search-icon {
            left: 10px;
            padding-left:5px;
            width: 14px;
            height: 14px;
        }
        .keyboard-icon {
            right: 95px;
            width: 24px;
            height: 24px;
        }
        .mic-icon {
            right: 50px;
            width: 30px;
            height: 30px;
            
        }
        .photo-icon {
            right: 10px;
            width: 30px;
            height: 30px;
        }
        .buttons {
            margin-top: 20px;
            margin-bottom : 160px;
        }
        .btn {
            color: #3c4043;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            background-color: #f8f9fa;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #f8f9fa;
            font-family: Arial, sans-serif;
            font-size:14px;
        }
        .btn:hover {
            border-color:rgb(202, 205, 206); /* 마우스 올리면 border 색상 변경 */
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #f2f2f2;
            font-size: 16px;
            display: flex;
            flex-direction: column;
        }
        .f-1 {
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;
            font-size:14px;
            color:var(--YLNNHc);
        }
        .footer-links {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
        }
        .f-2 {
            padding-left:30px;
        }
        .f-2 ul, .f-3 ul {
            display: flex;
            padding: 0;
            margin: 0;
            font-size:14px;
        }
        .f-2 a, .f-3 a {
            list-style: none;
            text-decoration:none;
            color:var(--YLNNHc);
        }
        .f-2 a:hover, .f-3 a:hover {
            text-decoration: underline;
        }
        .f-2 ul li, .f-3 ul li {
            list-style: none;
            margin-right: 30px;
        }
        .f-3 {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="left">
            <a href="https://about.google/?fg=1&utm_source=google-KR&utm_medium=referral&utm_campaign=hp-header">Google 정보</a>
            <a href="https://store.google.com/regionpicker?hl=en-US">스토어</a>
        </div>
        <div class="right">
            <a href="#">Gmail</a>
            <a href="#">이미지</a>
        </div>
    </div>
    <div class="logo">
        <a href="http://localhost/">
            <span>G</span><span>o</span><span>o</span><span>g</span><span>l</span><span>e</span>
        </a>
    </div>
    <div class="search-container">
        <img src="./image/search-icon.png" class="search-icon">
        <input type="text" class="search-box" placeholder="Google 검색 또는 URL 입력">
        <img src="./image/search-tia.png" class="keyboard-icon">
        <img src="./image/search-mic.png" class="mic-icon">
        <img src="./image/search-photo.png" class="photo-icon">
    </div>
    <div class="buttons">
        <button class="btn">Google 검색</button>
        <button class="btn">I'm Feeling Lucky</button>
    </div>
    <div class="footer">
        <div class="f-1">대한민국</div>
        <div class="footer-links">
            <div class="f-2">
                <ul>
                    <a href="https://ads.google.com/intl/ko_kr/home/?subid=ww-ww-et-g-awa-a-g_hpafoot1_1!o2&utm_source=google.com&utm_medium=referral&utm_campaign=google_hpafooter&fg=1"><li>광고</li></a>
                    <a href="https://www.google.com/business/?subid=ww-ww-et-g-awa-a-g_hpbfoot1_1!o2&utm_source=google.com&utm_medium=referral&utm_campaign=google_hpbfooter&fg=1"><li>비즈니스</li></a>
                    <a href="https://www.google.com/search/howsearchworks/?fg=1"><li>검색원리</li></a>
                </ul>
            </div>
            <div class="f-3">
                <ul>
                    <a href="https://policies.google.com/privacy?hl=ko&fg=1"><li>개인정보처리방침</li></a>
                    <a href="https://policies.google.com/terms?hl=ko&fg=1"><li>약관</li></a>
                    <a href=""><li>설정</li></a>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
