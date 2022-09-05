<!-- <?php 
                    $comment = $_POST['comment']; // 댓글내용
                    $writer = $_POST['writer'];
                    $password = $_POST['password'];
       
                    
                   
                        $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
                        if ($mysqli->connect_errno)
                        {
                            echo 'mysql error';
                        }
                        else
                        {
                            $sql = "INSERT INTO comment SET
                            number = $_POST['number'],
                            comment_number = NULL,
                            comment
                            ";
                            
                        }

                       
                        mysqli_close($mysqlDB);
                    
                
                ?> -->