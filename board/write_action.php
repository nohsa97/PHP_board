           
                 <?php 

                    $subject = $_POST['subject']; // 게시글 제목
                    $body = $_POST['body']; // 게시글 내용
                    $writer = $_POST['writer'];
                    $password = $_POST['password'];
                  

                    if($subject=="" || $body ==""){ //비어있을 경우.
                       
                        echo " <script> alert(\"다시 작성해주세요\");
                        location.href= \"write.php\"; </script>";            
                    }  
                 
                    
                    else {
                        $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
                        if ($mysqli->connect_errno)
                        {
                            echo 'mysql error';
                        }
                        else
                        {
                            
            
                            $result =  mysqli_query($mysqlDB,$RESET);
                            // $sql = "insert into board values(NULL,'$subject','$writer','$body',NOW(),'$password',10)";
                            $sql = "INSERT INTO board SET
                                    number = NULL,
                                    subject = '$subject',
                                    writer = '$writer',
                                    body = '$body',
                                    date = NOW(),
                                    password = '$password',
                                    visited = 10
                                    ";
                            // echo $sql;
                            // exit;  테스트할때 유용한 코드  exit와 $sql 바로출력. 굿.
                            $result = mysqli_query($mysqlDB,$sql);  
                            
                        }

                       
                        mysqli_close($mysqlDB);
                    }
                   
                ?>

                <script>
                    alert("게시글 작성 완료");
                    location.href= "list.php";
                </script>
<!-- insert into board values (NULL,"테스트2","노홍석2","테스트용 바디2","2022-09-05 10:58:00", "12343", 10); -->