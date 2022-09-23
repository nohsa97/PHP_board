<?
    class UserINFO 
    {
        public $userID;
        public $userPassword;
        public $userName;
        public $userPhone;

        public function __construct($inputID,$inputPass,$inputName,$inputEmail){
            $this -> ID = $inputID;
            $this -> Password = $inputPass;
            $this -> Name = $inputName;
            $this -> Email = $inputEmail;
        }
    }
?>


<?
    include_once '../template/include/dbConnection.php';
    session_start();
    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) 
    {
        echo "DB Connect Failed";
        exit;
    }
    
    $set = $_POST['set'];
    $input = new UserINFO( $_POST['id'], $_POST['password'], $_POST['Name'], $_POST['Email'] );

    if($set=="register")
    {
         //아이디확인
        $sql = FindSQL( $mysqlDB, 'user', 'ID', $input->ID );
        $result = mysqli_query( $mysqlDB, $sql) ;
        $row1 = mysqli_fetch_assoc( $result );
        //이메일확인
        $sql = FindSQL( $mysqlDB, 'user', 'Email', $input->Email );
        $result = mysqli_query( $mysqlDB, $sql );
        $row2 = mysqli_fetch_assoc( $result );

        if($row1 ||  $row2) {
            alerting("이미 존재하는 ID/Email 입니다.");
            echo "<script> history.back();   </script>";
        }
        else {
            $sql = register( $mysqlDB, $input->ID, $input->Password, $input->Name, $input->Email );
            mysqli_query( $mysqlDB, $sql );
            
            alerting("회원가입 완료");
            location("login.php");
        }

    }



    if( $set == "login" ) 
    {
        $sql = login( $mysqlDB, 'user', 'ID', $_POST['id'], 'Password', $_POST['password'] );
        $result = mysqli_query( $mysqlDB, $sql );
        $row = mysqli_fetch_assoc( $result ); 
        if( $row ) 
        {
                $_SESSION['userID'] = $_POST['id'];
                $_SESSION['userPass'] = $_POST['password'];
                alerting("로그인 완료");
                location("../template/main/list.php?board_number=0");
        }
        
        else 
        {
            alerting("잘못된 ID/PW입니다.");
            echo "<script> history.back();   </script>";
        }

    }
  