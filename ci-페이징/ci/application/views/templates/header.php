<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../static/css_new/style.css"> -->
</head>

<body style="background-color: #F2F2F2;">
    <header class="header text-center">
        <h1>UCERT</h1>
        
        <?
        
            session_start();
            if( isset($_SESSION['ID']))
            {
                echo '<h3>'.$_SESSION["ID"].'님 환영합니다.</h3>';
                echo '<a href="/login_con/logout"><button class="float-end btn btn-warning">로그아웃</button></a>';
            }
            else 
            {
                    echo "nono";
                  
            }
            
            
            
                
            // }
        ?>
        
    </header>
<!-- <a href="/login_con/logout"><button class="float-end btn btn-warning">로그아웃</button></a> -->