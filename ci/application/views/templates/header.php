<html lang="en">
    
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/public/css/style.css">
  <link rel="stylesheet" href="/public/css/bootstrap.css">
  <!-- <link rel="stylesheet" href="../static/css_new/style.css"> -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body style="background-color: #F2F2F2;">
  <header class="header text-center">
  <h1><span class="material-symbols-outlined">lock</span> UCERT </h1>
  <a href="/board"><button class="float-start btn btn-warning"> 메인으로 </button></a></h3>       
<? if (isset($_SESSION['ID'])) { ?>
  <h3> <?=$_SESSION["ID"]?>님 환영합니다.</h3>
  <button class="float-end btn btn-warning" onclick="logout()"> 로그아웃 </button>
  <button  class="float-end btn btn-warning">마이 페이지</button>
<? } else {?>
  <a href="/login"><button class="float-end btn btn-warning"> 로그인 </button></a></h3>
<? } ?>
  </header>
