<?     
        include_once "./include/dbConnection.php";
        $mysqlDB = mysqlConnect();
        if(!$mysqlDB) {
            echo "<script>alert('DB연결 실패');</script>";
            exit;
        }
                        $sql = selectSQL($mysqlDB,'board'); // dbConnection에 존재하는 함수.
                        $result = mysqli_query($mysqlDB,$sql);
                        if($result){
                            $listnum = 1;
                            // while($row=mysqli_fetch_assoc($result)) {  //게시글 보내면서 게시글 번호를 전달하기 
                            //     echo "
                            //         <tr class='content'>
                            //             <td class='board_number'>",$listnum,"</td>
                            //             <td class='board_subject'>","<a href='content.php?number=",$row['number'],"'>",$row['subject'],"</a>","</td> 
                            //             <td class='board_writer'>",$row['writer'],"</td>
                            //             <td class='board_writeDate'>",$row['date'],"</dh>
                            //         </tr>                                  
                            //         ";
                            //         $listnum++;
                            // }
                            $sql2 = "SELECT COUNT(*) FROM board";
                            $result2 = mysqli_query($mysqlDB,$sql2);
                            $row=mysqli_fetch_assoc($result2);
                            $NUMBER = $row['COUNT(*)'];
                            $row=mysqli_fetch_assoc($result);
                            print_r($row);
                            echo "<br>";
                            print_r($NUMBER);

                            // $sql3 = "SELECT MAX(number) FROM board";
                            // $result2 = mysqli_query($mysqlDB,$sql3);
                            // $row=mysqli_fetch_assoc($result2);
                            // $NUMBER = $row['MAX(number)']; 최대값 찾기. 
                        }  
                    mysqli_close($mysqlDB);
    ?>