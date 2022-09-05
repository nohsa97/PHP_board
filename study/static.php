<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // function sta() {
        //     static $var = 0;
        //     $var++;
        //     return $var;
        // }
        // sta();sta();sta();
        // echo sta();
        // $arr1 = array(1,2,3,4);
        // $arr2 = array(100,2,3,4,5,6,7);
        // var_dump($arr1);
        // echo "<br>";
        // var_dump($arr2);
        // $arr3 = array($arr1,$arr2);
        // echo "<br>";
        // var_dump($arr3);
        // echo "<br>";
        // list($var4,) = $arr3;
        // var_dump($var4);
        
        function get($str="") {
            $lang = array("파이썬","C언어","자바");
            if($str==null){
                $result = " ";
            }
            else {
                $result = in_array($str,$lang);
                
            }
            return array($lang,$result);
        }

        list($var) = get();
        foreach($var as $in) {
            echo $in."<br>";
        }
        list(,$vars) = get("자바");
        if($vars == true)
        {
            echo "자바는 안에 있어요";
        }
        


       
        
    ?>
    
</body>
</html>