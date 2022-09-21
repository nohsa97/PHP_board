<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function getrandString(int $len,$elem = false):bool {
                if($len <=0)
                    return "";
                if($elem===false)
                 $elem = "abcdefg";

                 if(!preg_match('/\A[\x21-\x7e]+\z/',$elem)){
                    die("잘못됨");
                 }

                 $chars = preg_split("//",$elem,-1,PREG_SPLIT_NO_EMPTY);
                 $chars = array_unique($chars);
                 mt_srand((double)microtime()*10000000);

                 $str = "";
                 $maxIndex = count($chars)-1;
                 for($i=0;$i<$len;$i++){
                    $str .=$chars[mt_rand(0,$maxIndex)];
                 }

                 return $str;
        }

        echo getrandString(30);
    ?>
</body>
</html>