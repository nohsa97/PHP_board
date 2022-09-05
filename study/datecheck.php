<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $date = [1,2,3,4,5,6];
    ?>


 
            <form action="actions.php" method="post">
            <select name="날짜" id="calendar">
                <?php
                for($i=0;$i<6;$i++)
                {
                    echo "<option value=\"year\">$date[$i]</option>";
                }
                 
                ?>
                
            </select>
    
        </form>
   
    
</body>
</html>