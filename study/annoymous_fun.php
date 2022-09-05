<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $nature = array("tree","flower","domentiy","vie");
        $filter_5 = function ($text){
            return strlen($text) < 5 ;
        };

        $filtered_5 = array_filter($nature,$filter_5);
        var_dump($filtered_5);
    ?>
</body>
</html>