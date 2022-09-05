<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function config() {
            $num = func_num_args(); //  인수 크기 .
            $argu  = func_get_args();
            $config = array();

            foreach($argu as $arg){
                $config[$arg[0]]=$arg[1];
            }
            echo $num."인수의 수 <br>";
            var_dump($config);
        }

        $config1 = array("설정1" , 100);
        
        $config2 = array("설정2" , 200);
        
        $config3 = array("설정3" , 300);

        config($config1,$config2,$config3)
    ?>
</body>
</html>