<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $i = 1;
        while($i<10){
            echo "i는  ".$i. "\t";
            $j=1;
            while($j<5){
                echo "j는 ".$j."  ";
                echo "i*j는 ".$i*$j."  ";
                if($i*$j>15)
                    break 2;
                
                $j++;
            }
            $i++;
            echo "<br>";
        }
    ?>
</body>
</html>