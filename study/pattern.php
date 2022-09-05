<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
        include "test.php";
    ?>
</head>
<body>
    <?php

        $pattern = '/\A(010|011)-?\d{4}-?\d{4}\z/';
        $tel = '010-2020-7854';
        if(preg_match($pattern,$tel)){
            echo "일치";
        }
        else echo "불일치";

        sesStart();
    ?>
</body>
</html>