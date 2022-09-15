<?
    function mysqlConnect()
    {
        $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
        if ($mysqli->connect_errno)
        {
            return false;
        }

        return $mysqlDB;
    }

    function selectSQL($mysqlDB, string $TABLE) {  // 테이블 출력
        if($mysqlDB) {
            $sql = "SELECT * FROM $TABLE";
            return $sql;
        }
        else return false;
    }

    function selectSQL_option($mysqlDB, string $TABLE, $COL, $OPTION,$start,bool $COUNT) { //마지막 var에서 1의경우 그냥 비슷한거 가져와서 출력. 2의경우 갯수 출력.
        if($mysqlDB && $COUNT==false) {
            $sql = "SELECT * FROM $TABLE where $COL LIKE '%$OPTION%'  ORDER BY number DESC limit $start,10 ;";
            return $sql;
        }
        else if($mysqlDB && $COUNT==true) {
            $sql = "SELECT COUNT(*) FROM $TABLE where $COL LIKE '%$OPTION%'  ORDER BY number DESC limit 0,10 ;";
           
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            $NUMBER = $row['COUNT(*)'];
             return $NUMBER;
            
        }
        else return false;
    }

    

    function selectSQL_reverse($mysqlDB, string $TABLE,string $COL,int $start, int $limit,bool $COUNT) {  //테이블 역순 출력  위와 동일.
        if($mysqlDB && $COUNT==false) {
                $sql = "SELECT * FROM $TABLE ORDER BY $COL DESC limit $start,$limit";
                return $sql;       
        }
        else if($mysqlDB && $COUNT==true) {
                $sql = "SELECT COUNT(*) FROM $TABLE ORDER BY $COL DESC limit $start,$limit";
                return $sql;
        }
        else return false;
    }


    
    function getCount_table($mysqlDB, string $TABLE) {  // 테이블 크기 조회 
        $sql = "SELECT COUNT(*) FROM $TABLE";
        $result = mysqli_query($mysqlDB,$sql);
        $row=mysqli_fetch_assoc($result);
        $NUMBER = $row['COUNT(*)'];
        return $NUMBER;
    }


    function FindSQL($mysqlDB, string $TABLE,string $COL,$value) {  
        if($mysqlDB) {
            $sql = "SELECT * FROM $TABLE where $COL = $value ";
            return $sql;
        }
        else return false;
    }

    function visitedUpdate($mysqlDB,string $TABLE, int $number) {
        $sql = "UPDATE $TABLE SET visited=visited+1 WHERE number=$number;"; // 조회수 증가
        mysqli_query($mysqlDB,$sql);
    }

    function dataUpdate($mysqlDB,string $TABLE,$selCOL,string $newData,$COL, int $number) {
        if($mysqlDB) {
            $sql = "UPDATE $TABLE SET $selCOL='$newData' WHERE $COL=$number;";
            return $sql;
        }
        else return false;
    }

    
    function remove($mysqlDB,string $TABLE,string $COL, $VAR) { // 댓글 삭제 한번에 날림
        if($mysqlDB) {
            $sql = "DELETE FROM $TABLE WHERE $COL=$VAR";
            return $sql;
        }
        else return false;
    }


    // 게시물 아래 footer에 넣을 함수들
    function bottom_max($mysqlDB,string $TABLE,string $COL, $VAR) {
        if($mysqlDB) {
            $sql = "SELECT number,subject FROM $TABLE WHERE $COL < $VAR ORDER BY $COL DESC LIMIT 1";
            return $sql;
        }
        else return false;
    }
  
    
    function bottom_min($mysqlDB,string $TABLE,string $COL, $VAR) {
        if($mysqlDB) {
            $sql = "SELECT number,subject FROM $TABLE WHERE $COL > $VAR  ORDER BY $COL LIMIT 1";
            return $sql;
        }
        else return false;
    }



    //간단한 자바스크립트 함수

    function alerting(string $input) {
        echo "
             <script>
                alert('$input');
            </script>   
        ";
        
    }
    
    function location(string $href){
        echo 
        "<script>
            location.href = '$href';
        </script>";
    }
    
