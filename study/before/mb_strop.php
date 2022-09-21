<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
       $test= "test";
        require_once("requied_once.php");
        if(mb_strpos($var,$test)===false){
            echo "$var 은 test를 포함합니다.";
        } 
        else 
            echo " 놉1";

        // if(mb_strpos($var2,"test")){
        //         echo "$var 은 test를 포함합니다.";
        //     } 
        //     else 
        //         echo " 놉2";
    ?>
</body>
</html>