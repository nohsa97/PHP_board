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
<? include_once 'login_header.php';?>
    <? include_once '../template/include/dbConnection.php';
        $mysqlDB = mysqlConnect();
        if (!$mysqlDB) 
        {
            echo "DB Connect Failed";
            exit;
        }
    ?>
    

 
    <form class="loginForm" action="check.php" method="post">
        <label for="id">아이디</label>
        <input class="input" required style='margin-left: 27px;' type="text" name="id" id="id"><br>

        <label for="password">비밀번호</label>
        <input class="input" required type="password" name="password" id="password"><br>

        <label for="Name">이름</label>
        <input class="input" required style='margin-left: 43px;' type="text" name="Name" id="Name"><br>

        <label for="Phone">이메일</label>
        <input class="input"required  type="email" name="Email" id="Email"><br>
        
        <div>
        <input id="register" class="loginBtn" type="submit" value="회원가입">
        <input type="hidden" name="set" value="register">
        </div>
        
    </form>
</body>
<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
</script>
</html>