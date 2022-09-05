<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $var = 0;
        switch($var) {
                case 'error' :
                    echo "실패";
                    break;
                case "true":
                    echo "string ture";
                    break;
                case true :
                    echo "trusse";
                    break;
                case false :
                    echo "fal";
                    break;
                default :
                    echo "no";
                    break;
        }
    ?>
</body>
</html>