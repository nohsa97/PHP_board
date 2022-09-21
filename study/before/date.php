<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $var = date('H');
        echo $var;
        // var_dump($var);
        if((int)$var === 11)
            echo "정각";
    ?>

</body>
</html>