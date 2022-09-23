<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <? include_once 'login_header.php'?>
    <? include_once '../template/include/dbConnection.php'?>
    <?
        session_start();
        session_destroy();
    ?>

    <form class="loginForm" action="check.php" method="post">
        <div class="input_form">
            <label for="id">아이디</label>
            <input class="input" required style='margin-left: 27px;' type="search" name="id" id="id"><br>
            <label for="password">비밀번호</label>
            <input class="input" required type="password" name="password" id="password">
        </div>
        
        <input style="width:15%" class="loginBtn" type="submit" value="로그인">
        </div>
        <div>
            <input id="register" class="loginBtn" type="button" value="회원가입">
            <input id="findUser" class="loginBtn" type="button" value="ID/PW찾기">        
        </div>

        <input id="no_login" class="loginBtn" type="button" value="비회원">  

        <input type="hidden" name="set" value="login">
    </form>
</body>

<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    $("#register").click(function() 
    {
        location.href = "register.php";
    });
    
    $("#no_login").click(function() 
    {
        location.href = "../template/main/list.php?board_number=0";
    });
</script>
</html>