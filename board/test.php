<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
  
ul {
    display:none;
  animation-duration: 1s;
  animation-name: slidein;
}

a:hover {
    background-color:pink;
}

a:hover ul {
    display:relative !important;
  
}
@keyframes slidein {
  from {
    margin-left: 100%;
    width: 300%;
  }

  to {
    margin-left: 0%;
    width: 100%;
  }
}
    </style>
</head>
<body>
    <div class="dropdown">
        <a href="#">게시판
            <ul >
                <li>1</li>
                <li>2</li>
                <li>3</li>
            </ul>
        </a>
    </div>

</body>
</html>