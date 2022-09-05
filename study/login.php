<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>유써트 로그인</title>

    <!-- <script>
        function like(){
            location.href = "http://localhost/actions.php";
        }
    </script> -->
</head>
<body>
    <form action="actions.php" method="post">
        <p>
            <label for="id">아이디
                <input type="text" name="아이디" id="id">
            </label>
        </p>
        <p>
            <label for="pass">비밀번호
                <input type="password" name="비밀번호" id="pass">
            </label>
        </p>
        <input type="submit" value="로그인" >
        
        
    </form>
</body>
</html>