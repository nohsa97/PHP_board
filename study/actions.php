<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
        $id = $_POST['아이디'];
        $pass = $_POST['비밀번호'];
    ?>

</head>
<body>
    <?php
        echo $id.$pass;
    ?>
</body>
</html>