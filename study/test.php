<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // $var = "sss";
        // $arr = (string)array(1,2,3,4);
        // $var2 = "12333";
        // $var3 = (int)$var;
        // echo $var3."<br>";
        // echo var_dump($var3)."<br>";
        // echo $arr;
        // define("TEST","미리정의된");
        // CONST RECIP = "프로그래밍";
        // echo "<pre>";
        // print_r(get_defined_constants(true));
        // echo "</pre>";
        // if(defined("RECIP")){
        //     echo RECIP;
        // }
        // else 
        //     echo "안댐";

        function sesStart() {     
            session_start();

            if(isset($_SESSION['views']))
            $_SESSION['views']=$_SESSION['views']+1;
            else
            $_SESSION['views']=1;
            echo "Views=". $_SESSION['views'];
    
            
        }

        sesStart();

    ?>
</body>
</html>