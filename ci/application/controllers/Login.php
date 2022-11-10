<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Login extends CI_Controller
  {

    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array("url", "JS"));
      $this->load->model('user_model');
    }

    public function _remap($method)
    {
      if (!strpos($method, "_func"))  //함수만 쓸것 - 뷰를 안나타낼거면 헤더와 푸터가 필요없다.
      {
       $this->load->view('/templates/header');  
      }

      if (method_exists($this, $method)) 
      {
       $this->{"{$method}"}();
      }

      if (!strpos($method, "_func"))
      {
       $this->load->view('/templates/footer');         
      }
    }

    public function index() //페이지 로드
    {

      if (isset($this->session->ID)) //로그인 되어있을 시. 바로 리스트 페이지 이동 
      {
        redirect("/board");
      }

      $this->load->view('/templates/login/login');
    }

    public function findPw_page()
    {
      $this->load->view('/templates/login/findPW');   
    }

    public function newPw_page()
    {
      $this->load->view('/templates/login/newPW');   
    }



    public function login_func()
    {
      $input_ID   = $this->input->post('inputID');
      $input_pass = $this->input->post('inputPass');
      $input_pass = hash("sha256", $input_pass);
      $user_seq   = $this->user_model->get_user(array('ID' => $input_ID));

      if (isset($user_seq)) 
      {
        $row = $this->user_model->get_user(array('ID' => $input_ID, 'Password' => $input_pass.(string) $user_seq['user_seq']));

        if (isset($row)) // 값이 존재한다면
        {
          $_SESSION['ID'] = $input_ID;
          echo "success";
        }

        else
        {

          echo 'NoDB';
        }
      }

      else
      {

        echo 'NoDB';
      }
    }

    public function logout_func()
    {
      session_destroy();
      alert("로그아웃 하셨습니다.");
      location_href("../login");
    }

    public function find_ID()
    {
      if ($this->input->post('input_ID') == NULL) //아이디 입력란이 공백 ==> 아이디 찾기
      {
        $input_name  = $this->input->post('input_name');
        $input_email = $this->input->post('input_email');
        $input_arr = array(
          'Name'  => $input_name,
          'Email' => $input_email
        );
        $ID = $this->user_model->findPW($input_arr)['ID'];

        if (isset($ID))
        {     
          alert("회원님의 아이디는 ".$ID." 입니다");
          location_href("../login");
        }
        else 
        {
          alert("해당 아이디가 없습니다.");
          history_back();
        }
      }

      else // 차있을 경우 =-> 비밀번호 찾기.
      {
        $input_ID    = $this->input->post('input_ID');
        $input_name  = $this->input->post('input_name');
        $input_email = $this->input->post('input_email');
        $input_arr = array(
          'ID'    => $input_ID,
          'Name'  => $input_name,
          'Email' => $input_email
        );
        $result = $this->user_model->findPW($input_arr);

        if (isset($result[0]))
        {
          $this->load->view('/templates/login/newPW', $input_arr);   
        }
        else 
        {
          alert("일치하는 정보가 없습니다.");
          history_back();
        }
      }

    }


    public function newPW_func()
    {
      $ID = $this->input->post('ID');
      $new_PW = $this->input->post('input_pass');

      if ($new_PW == NULL)
      {
        alert('비밀번호를 입력해주세요.');
        history_back();
        exit;
      }

      $user_seq = $this->user_model->get_user(array('ID' => $ID))['user_seq'];
      $pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/";
  
      if (!preg_match($pattern, $new_PW)) //비밀번호가 양식에 맞지 않다.
      {
        alert("비밀번호 양식에 맞춰주세요.");
        history_back();
        exit;
      }

      $new_PW = hash("sha256", $new_PW);

      $input_arr = array(
        'ID'       => $ID,
        'Password' => $new_PW.(string) $user_seq
      );

      $this->user_model->update_user(array('set' => 'Password', 'Password' => $new_PW.(string) $user_seq, 'ID' => $ID));
      alert("변경 완료");
      location_href("/");
    }

    function curl()
    {
      $url = "http://ci.test.co.kr/user/test_func";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $response = curl_exec($ch);
      echo $response;
      
      curl_close($ch);      
    }

//http_build_query() url인코딩된 쿼리 문자열을 생성하는 함수


  }
?>