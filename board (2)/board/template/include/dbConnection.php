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
        public $number; //각각 번호 
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

 


    class board extends boardContent {

        public $visited;
        public $subject;
        
        public function __construct($input_number, $input_sub, $input_writer, $input_body, $input_pass, $input_visited, $input_per)
        {
            $this->number = $input_number;
            $this->subject = $input_sub;
            $this->writer = $input_writer;
            $this->body = $input_body;
            $this->password = $input_pass;
            $this->visited = $input_visited;
            $this->permission = $input_per;
        }
        //DATE는 일단 넣을때만 하기로. 
        public function insertFunc( $mysqlDB ) {
            $sql = "INSERT INTO board SET
                    number = NULL,
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

        public function delFunc($mysqlDB) {
            $sql = remove($mysqlDB, 'board', 'number', $this->number);
            mysqli_query( $mysqlDB, $sql ); //게시글 삭제
            $sql = remove($mysqlDB, 'comment', 'b_number', $this->number);
            mysqli_query( $mysqlDB, $sql );   
            $sql = remove($mysqlDB, 'reply', 'b_number', $this->number);
            mysqli_query( $mysqlDB, $sql );          
        }
        
        public function updateFunc($mysqlDB, $selectNum){
            $sql = "UPDATE board SET
                    number = $selectNum,
                    subject = '$this->subject',
                    writer = '$this->writer',
                    body = '$this->body',
                    date = NOW(),
                    password = '$this->password',
                    visited = $this->visited,
                    permission = $this->permission
                    WHERE number = $selectNum;
                ";
                mysqli_query( $mysqlDB, $sql );
                alerting("게시글 수정 완료");  
        }

    }




    class comment extends boardContent implements comment_content {
        public $b_number;
        //b넘버는 게시글넘버 인풋넘버가 널이면 새로 생성
        public function __construct($input_number, $input_b_number, $input_writer, $input_body, $input_pass, $input_per)
        {
            $this->number = $input_number;
            $this->b_number = $input_b_number;
            $this->writer = $input_writer;
            $this->body = $input_body;
            $this->password = $input_pass;
            $this->permission = $input_per;
        }

        public function insertFunc($mysqlDB)
        {
            $sql = "INSERT INTO comment SET
                    number = NULL,
                    b_number = $this->b_number,
                    writer = '$this->writer',
                    body = '$this->body',
                    password = '$this->password',
                    date = NOW(),
                    permission = $this->permission;
               ";
                
               mysqli_query( $mysqlDB, $sql );
        }
        public function delFunc($mysqlDB) {
            $sql = remove($mysqlDB, 'comment', 'number', $this->number);
            mysqli_query( $mysqlDB, $sql ); //게시글 삭제
            $sql = remove($mysqlDB, 'reply', 'c_number', $this->number);
            mysqli_query( $mysqlDB, $sql ); //  

        }

        public function updateFunc($mysqlDB, $newData)
        {
            $sql = "UPDATE comment SET body = '$newData' WHERE  number = $this->number ;";
            mysqli_query($mysqlDB, $sql);

        }
    }

    class reply extends boardContent implements comment_content 
    {
        public $c_number;
        public $b_number;

        public function __construct($input_number, $input_b_number, $input_c_number, $input_writer, $input_pass, $input_body, $input_per)
        {
            $this->number = $input_number;
            $this->b_number = $input_b_number;
            $this->c_number = $input_c_number;
            $this->writer = $input_writer;
            $this->password = $input_pass;
            $this->body = $input_body;
            $this->permission = $input_per;
        }

        public function insertFunc($mysqlDB)
        {
            $sql = "INSERT INTO reply SET
                    number = NULL,
                    b_number = $this->b_number,
                    c_number = $this->c_number,
                    writer = '$this->writer',
                    body = '$this->body',
                    password = '$this->password',
                    date = NOW(),
                    permission = $this->permission;
               ";     
               mysqli_query( $mysqlDB, $sql );
        }

        public function delFunc($mysqlDB)
        {
            $sql = "DELETE FROM reply WHERE number = $this->number";
            mysqli_query($mysqlDB, $sql);
        }

        public function updateFunc($mysqlDB, $newData)
        {
            $sql = "UPDATE reply SET body = '$newData' WHERE  number = $this->number ;";
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
            $sql = "SELECT * FROM $TABLE where $COL LIKE '%$OPTION%'  ORDER BY number DESC limit $start,10 ;";
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
        $sql = "UPDATE $TABLE SET visited = visited + 1 WHERE number = $number;"; // 조회수 증가
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
            $sql = "SELECT number,subject FROM $TABLE WHERE $COL < $VAR ORDER BY $COL DESC LIMIT 1";
            return $sql;
        }
        else return false;
    }
  
    
    function bottom_min( $mysqlDB, string $TABLE, string $COL, $VAR) 
    {
        if($mysqlDB) {
            $sql = "SELECT number,subject FROM $TABLE WHERE $COL > $VAR  ORDER BY $COL LIMIT 1";
            return $sql;
        }
        else return false;
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
