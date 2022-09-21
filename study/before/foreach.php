<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        
    <?php
        // $ss = 6;
        // for($var=0;$var<5;$var++){
        //     echo $var."<br>";
        // }
        // do{
        //     echo $ss."<br>";
        //     $ss--;
        // } while($ss>10)
        $arr = array("apple" => 1000, "orange" =>2000);
        foreach($arr as $key => $var){
            echo "$key 은 $var 가격 ";
        }
        var_dump($arr);
    ?>

</body>
</html>