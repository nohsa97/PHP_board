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

    function selectSQL($mysqlDB, string $TABLE) {  
        if($mysqlDB) {
            $sql = "select * FROM $TABLE";
            return $sql;
        }
        else return false;
    }

    function FindSQL($mysqlDB, string $TABLE) {  
        if($mysqlDB) {
            $sql = "select * FROM $TABLE";
            return $sql;
        }
        else return false;
    }

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
    

    // function insertSQL() {
    //     $mysqlDB = mysqlConnect(string $DB,string $COL);
    //     $sql =  "
    //         INSERT INTO $DB SET
    //     ";
        
    //     // $mysqlDB = mysqlConnect();
    //     // $sql = "
    //     // INSERT INTO comment SET
    //     // comment_number = NULL,
    //     // number = $number,
    //     // comment = '$comment',
    //     // writer = '$writer',
    //     // password = '$password',
    //     // date = NOW(),
    //     // re_comment =NULL;
    //     // ";
    
    //     // $result = mysqli_query($mysqlDB,$sql);
    // }