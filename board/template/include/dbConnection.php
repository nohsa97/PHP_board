<?
    function mysqlConnect()
    {
        $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
        if ( $mysqlDB -> connect_errno )
        {
            return false;
        }

        return $mysqlDB;
    }


    abstract class boardContent {
        public $writer;
        public $password;
        public $body;
        public $permission;

        abstract public function insertFunc($mysqlDB);
        abstract public function delFunc($mysqlDB);
    }

    interface comment_content {
        public function insertFunc($mysqlDB);
        public function delFunc($mysqlDB);
        public function updateFunc($mysqlDB, $newData);
    }

 


    class board extends boardContent 
    {
        public $b_seq;
        public $visited;
        public $subject;
        
        public function __construct()
        {
            $this->b_seq;
            $this->subject;
            $this->writer;
            $this->body;
            $this->password;
            $this->visited;
            $this->permission;
        }

        public function getBoard($mysqlDB , $b_seq) 
        {
            $sql = FindSQL($mysqlDB, 'board', 'b_seq', $b_seq);
            $result = mysqli_query($mysqlDB, $sql);
            $row = mysqli_fetch_assoc($result);

            $this->b_seq = $row['b_seq'];
            $this->subject = $row['subject'];
            $this->writer = $row['writer'];
            $this->body = $row['body'];
            $this->password = $row['password'];
            $this->visited = $row['visited'];
            $this->permission = $row['permission'];

            return $this;
        }
        
        public function insertFunc( $mysqlDB ) 
        {
            $sql = "INSERT INTO board SET
                    b_seq = NULL,
                    subject = '$this->subject',
                    writer = '$this->writer',
                    body = '$this->body',
                    date = NOW(),
                    password = '$this->password',
                    visited = 0,
                    permission = $this->permission;
               ";
               mysqli_query( $mysqlDB, $sql );
               alerting( "게시글 작성 완료" );
               
        }

        public function delFunc($mysqlDB) 
        {
            $sql = remove($mysqlDB, 'board', 'b_seq', $this->b_seq);
            mysqli_query( $mysqlDB, $sql ); //게시글 삭제
            $sql = remove($mysqlDB, 'comment_test', 'b_seq', $this->b_seq);
            mysqli_query( $mysqlDB, $sql );      
        }
        
        public function updateFunc($mysqlDB, $b_seq)
        {
            $sql = "UPDATE board SET
                    b_seq = $b_seq,
                    subject = '$this->subject',
                    writer = '$this->writer',
                    body = '$this->body',
                    date = NOW(),
                    password = '$this->password',
                    visited = $this->visited,
                    permission = $this->permission
                    WHERE b_seq = $b_seq;
                ";
                mysqli_query( $mysqlDB, $sql );
                alerting("게시글 수정 완료");  
        }

        public function comment_list($mysqlDB, $seq) 
        {                            
            $sql = "SELECT B.b_seq, C.b_seq, C.c_seq, C.body, C.writer, C.c_depth, C.permission, C.sort, C.parent_seq 
            FROM board as B
            JOIN comment_test as C
            WHERE B.b_seq = C.b_seq AND B.b_seq = $seq ORDER BY C.parent_seq DESC, C.sort;";

            return mysqli_query($mysqlDB, $sql);
        }

    }

    class comment_TEST extends boardContent implements comment_content {
        public $c_seq;
        public $b_seq;
        public $parent_seq;
        public $sort;
        public $c_depth;
        //b넘버는 게시글넘버 인풋넘버가 널이면 새로 생성
        public function __construct()
        {
            $this->c_seq;
            $this->b_seq;
            $this->parent_seq;
            $this->sort;
            $this->c_depth;
            $this->writer;
            $this->body;
            $this->password;
            $this->permission;
        }

        public function getComment($mysqlDB , $c_seq) 
        {
            $sql = FindSQL($mysqlDB, 'comment_test', 'c_seq', $c_seq);
            $result = mysqli_query($mysqlDB, $sql);
            $row = mysqli_fetch_assoc($result);

            $this->c_seq = $row['c_seq'];
            $this->b_seq = $row['b_seq'];
            $this->parent_seq = $row['parent_seq'];
            $this->sort = $row['sort'];
            $this->c_depth = $row['c_depth'];
            $this->writer = $row['writer'];
            $this->body = $row['body'];
            $this->password = $row['password'];
            $this->permission = $row['permission'];

            return $this;
        }

        public function insertFunc($mysqlDB)
        {
            if($this->parent_seq == 0) //원댓글일때
            {
                $sql = "INSERT INTO comment_test SET
                    c_seq = NULL,
                    b_seq = $this->b_seq,
                    parent_seq = $this->parent_seq,
                    sort = $this->sort,
                    c_depth = $this->c_depth,
                    writer = '$this->writer',
                    body = '$this->body',
                    password = '$this->password',
                    date = NOW(),
                    permission = $this->permission;
               ";
               mysqli_query( $mysqlDB, $sql );
               $sql = "UPDATE comment_test SET parent_seq = (select last_insert_id()) WHERE c_seq = (select last_insert_id());";
               mysqli_query( $mysqlDB, $sql );
            }
            else 
            {
                $sql = "INSERT INTO comment_test SET
                c_seq = NULL,
                b_seq = $this->b_seq,
                parent_seq = $this->parent_seq,
                sort = $this->sort,
                c_depth = $this->c_depth,
                writer = '$this->writer',
                body = '$this->body',
                password = '$this->password',
                date = NOW(),
                permission = $this->permission;
                ";
               mysqli_query( $mysqlDB, $sql );
            }
    
        }

        public function delFunc($mysqlDB) 
        {
            // if($this->c_depth == 0)
            // {
                $sql = remove($mysqlDB, 'comment_TEST', 'c_seq', $this->c_seq);
            // }
            // else 
            // {
            //     $sql = "delete from comment_test where parent_seq=$this->parent_seq AND sort=$this->sort AND c_depth >= $this->c_depth";
            // }
            mysqli_query( $mysqlDB, $sql ); //게시글 삭제

        }

    


        public function updateFunc($mysqlDB, $newData)
        {
            $sql = "UPDATE comment_TEST SET body = '$newData' WHERE  c_seq = $this->seq ;";
            mysqli_query($mysqlDB, $sql);
        }
    }










    function selectSQL( $mysqlDB, $TABLE ) 
    {  // 테이블 출력
        if( $mysqlDB ) {
            $sql = "SELECT * FROM $TABLE";
            return $sql;
        }
        else return false;
    }

    function selectSQL_option( $mysqlDB, string $TABLE, $COL, $OPTION, $start, bool $COUNT ) 
    { //마지막 매개변수는 숫자를 가져올지 sql을 가져올지
        if( $mysqlDB && $COUNT == false ) {
            $sql = "SELECT * FROM $TABLE where $COL LIKE '%$OPTION%'  ORDER BY b_seq DESC limit $start,10 ;";
            return $sql;
        }
        else if( $mysqlDB && $COUNT == true ) {
            $sql = "SELECT COUNT(*) FROM $TABLE where $COL LIKE '%$OPTION%';";
           
            $result = mysqli_query( $mysqlDB, $sql );
            $row = mysqli_fetch_assoc( $result );
            $NUMBER = $row['COUNT(*)'];
            return $NUMBER;
            
        }
        else return false;
    }

    

    function selectSQL_reverse( $mysqlDB, string $TABLE, string $COL, int $start, int $limit, bool $COUNT ) 
    {  //테이블 역순 출력  위와 동일.
        if( $mysqlDB && $COUNT == false ) {
                $sql = "SELECT * FROM $TABLE ORDER BY $COL DESC limit $start , $limit";
                return $sql;       
        }
        else if( $mysqlDB && $COUNT == true ) {
                $sql = "SELECT COUNT(*) FROM $TABLE ORDER BY $COL DESC limit $start, $limit";
                return $sql;
        }
        else return false;
    }


    
    function getCount_table($mysqlDB, string $TABLE) 
    {  // 테이블 크기 조회 
        $sql = "SELECT COUNT(*) FROM $TABLE";
        $result = mysqli_query( $mysqlDB, $sql );
        $row = mysqli_fetch_assoc( $result );
        $NUMBER = $row['COUNT(*)'];
        return $NUMBER;
    }

    function getMAX_table_col($mysqlDB, string $TABLE, $COL) 
    {  // 테이블 크기 조회 
        $sql = "SELECT MAX($COL) FROM $TABLE";
        $result = mysqli_query( $mysqlDB, $sql );
        $row = mysqli_fetch_assoc( $result );
        $NUMBER = $row['MAX('.$COL.')'];
        return $NUMBER;
    }

    function getCount_table_option($mysqlDB, string $TABLE, $COL, $OPTION) 
    {  // 테이블 크기 조회 
        $sql = "SELECT COUNT(*) FROM $TABLE WHERE $COL = $OPTION";
        $result = mysqli_query( $mysqlDB, $sql );
        $row = mysqli_fetch_assoc( $result );
        $NUMBER = $row['COUNT(*)'];
        return $NUMBER;
    }


    function FindSQL( $mysqlDB, string $TABLE, string $COL, $value ) {  
        if( $mysqlDB ) {
            $sql = "SELECT * FROM $TABLE where $COL = $value ";
            if( is_string( $value ) ){
                $sql = "SELECT * FROM $TABLE where $COL = '$value' ";
            }
            return $sql;
        }
        else return false;
    }

    
    function login( $mysqlDB, $TABLE, $COL1,$VAL1,$COL2, $VAL2 ) 
    {  
        if( $mysqlDB ) {
            $sql = "SELECT * FROM $TABLE WHERE $COL1 = '$VAL1' AND $COL2 = '$VAL2' ";
            return $sql;
        }
        else return false;
    }

    function visitedUpdate( $mysqlDB, string $TABLE, int $number ) 
    {
        $sql = "UPDATE $TABLE SET visited = visited + 1 WHERE seq = $number;"; // 조회수 증가
        mysqli_query( $mysqlDB , $sql );
    }

    function dataUpdate( $mysqlDB, string $TABLE, $selCOL, string $newData, $COL, int $number ) 
    {
        if($mysqlDB) {
            $sql = "UPDATE $TABLE SET $selCOL='$newData' WHERE $COL=$number;";
            return $sql;
        }
        else return false;
    }

    
    function remove( $mysqlDB, string $TABLE, string $COL, $VAR) 
    { // 댓글 삭제 한번에 날림
        if( $mysqlDB ) {
            $sql = "DELETE FROM $TABLE WHERE $COL = $VAR";
            return $sql;
        }
        else return false;
    }



    // 게시물 아래 footer에 넣을 함수들
    function bottom_max( $mysqlDB, string $TABLE, string $COL, $VAR) 
    {
        if( $mysqlDB ) {
            $sql = "SELECT b_seq,subject FROM $TABLE WHERE $COL < $VAR ORDER BY $COL DESC LIMIT 1";
            return $sql;
        }
        else return false;
    }
  
    
    function bottom_min( $mysqlDB, string $TABLE, string $COL, $VAR) 
    {
        if($mysqlDB) {
            $sql = "SELECT b_seq,subject FROM $TABLE WHERE $COL > $VAR  ORDER BY $COL LIMIT 1";
            return $sql;
        }
        else return false;
    }

    function bottom_func ($mysqlDB, $TABLE, $COL, $VAL, $MODE) { //db, 테이블, 컬럼, 값, 모드 = (0= min, 1= max) 실질적인 실행부분
        if($MODE == 0) {
            $sql = bottom_min( $mysqlDB, $TABLE, $COL, $VAL );

            return mysqli_query( $mysqlDB, $sql );
        }
        else {
            $sql = bottom_max( $mysqlDB, $TABLE, $COL, $VAL );
            return mysqli_query( $mysqlDB, $sql );
        }
       
    }



    //로그인 관련

    function register( $mysqlDB, $userID, $userPassword, $userName, $userEmail ) 
    {
        if($mysqlDB) {
            $sql = "INSERT INTO user SET
            AFK = null,
            ID = '$userID',
            Password = '$userPassword',
            Name = '$userName',
            Email = '$userEmail';";
            return $sql;
        }
        else return false;
    }



    //간단한 자바스크립트 함수

    function alerting( string $input ) 
    {
        echo "
             <script>
                alert( '$input' );
            </script>   
        ";
        
    }
    
    function location( string $href )
    {
        echo 
        "<script>
            location.href = '$href';
        </script>";
    }



    
    ?>



