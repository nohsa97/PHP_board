<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo "헌재일시";

        $now = new Datetime();
        echo $now->format(' Y년 m월 d일');
        $now = new Datetime();
        $now->add(DateInterval::createFromDateString('1Year'));
        echo $now->format('Y년m월');
    ?>

</body>
</html>