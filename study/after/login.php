<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="" method="post">
            <input type="text" name="id" id="">
            <input type="password" name="pass" id="">
            <input type="button" onclick="login()" value="로그인">
    </form>

    <p id="result">asd</p>

    
</body>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>

    function login() {
        var input = {
        id : $('input[name=id]').val(),
        pass : $('input[name=pass]').val(),
    }
        $.ajax({

           url : "login_act.php",
           type:"POST",
           data : input,
        }).done(function(data){
            $("#result").text(data);
        });
    }
</script>
</html>