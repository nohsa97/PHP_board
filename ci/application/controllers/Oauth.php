<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Oauth extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array("url", "JS", "Curl"));
      $this->load->model('api_model');

      $this->client_id = "";
      $this->redirect_url = "http://ci.test.co.kr/oauth/get_access_token";
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

    public function authorization()
    {
      $current_token = $this->api_model->get_token_info();
      // if ($current_token['access_token'] != null)
      // {
      //   $data = 
      // }
    
      $this->load->view("/templates/oauth/authorization");
    }

    public function account_list()
    {
      $current_token = $this->api_model->get_token_info();
      $this->load->view("/templates/oauth/account");
    }

    public function getRandStr($length = 6)  //랜덤 변수 생성기 =>  bin2hex(random_bytes(16))의 경우 짝수의 갯수만 출력됨. 둘 중 하나로 통일시켜 구현할 예정입니다.
    {
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) 
      {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }

    public function set_token_input($array) // 추후에 editplus에선 라이브러리나 따로 파일에 넣을 예정입니다.
    {
      $input = array(
        'seq' => null,
        'access_token'  => $array['access_token'],
        'expires_in'    => $array['expires_in'],
        'refresh_token' => $array['refresh_token'],
        'scope'         => 'login inquiry',
        'user_seq_no'   => $array['user_seq_no'],
        'modt'          => date("Y-m-d H-i-s")
      );
      return $input;
    }

    public function get_authorization_code_func() //사용자 인증url로 연결해주는 함수입니다.
    {
      $state = bin2hex(random_bytes(16)); //랜덤 난수값

      $data = array(
        'response_type' => 'code',
        'client_id'     => $this->client_id, //발급받은 api키
        'redirect_uri'  => $this->redirect_url,
        'scope'         => "login inquiry",
        'state'         => $state,
        'auth_type'     => "0",
        'client_info'   => "test",
      );

      $url = "https://testapi.openbanking.or.kr/oauth/2.0/authorize"."?". http_build_query($data, '', ); //사용자 인증 페이지 url 생성. 
      redirect($url);
    }

    public function get_authorization_code2_func() //사용자 인증url로 연결해주는 함수입니다. 구현 중입니다.
    {
      $state = bin2hex(random_bytes(16)); //랜덤 난수값
      $user_info = $this->api_model->get_token_info();

      $data = array(
        'response_type' => 'code',
        'client_id'     => $this->client_id, //발급받은 api키
        'client_info'   => '',
        'redirect_uri'  => $this->redirect_url,
        'scope'         => "login inquiry",
        'state'         => $state,
        'auth_type'     => "2",
        'client_info'   => "test",
      );

      $url = "https://testapi.openbanking.or.kr/oauth/2.0/authorize"."?".http_build_query($data, '', ); //사용자 인증 페이지 url 생성. 

      $header = array(
        'Kftc-Bfop-UserSeqNo: '.$user_info['user_seq_no'], 
        'Kftc-Bfop-AccessToken: '.$user_info['access_token'], 
        'Kftc-Bfop-UserCI: 123'
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      
      $result = curl_exec($ch);
      curl_close($ch);
      // $result = json_decode($result, true); 
      print_r ($result);
    }

    public function get_access_token() //즉시 db기입
    {
      if (isset($_GET['error'])) //사용자가 취소 클릭 시
      {
        alert("인증을 취소하셨습니다.");
        location_href("/login");
        exit;
      }

      $url = "https://testapi.openbanking.or.kr/oauth/2.0/token";

      if ($_GET['code'] == "") //코드가 없다 >> 이상한 요청
      {
        alert("발급 중 오류 발생");
        location_href('/login');
        exit;
      }

      $auth_data = array(
        "client_info" => $_GET['client_info'],
        "scope"       => $_GET['scope'],
        "modt"        => date("Y-m-d H-i-s")
      );

      $auth_result = $this->api_model->insert_auth($auth_data);

      if ($auth_result == 0)
      {
        alert("사용자 인증 등록 실패. 다시 시도해주세요.");
        location_href("/login");
        exit;
      }

      $data = array(
        "code"          => $_GET['code'],
        "client_id"     => $this->client_id, //발급받은 api키
        "client_secret" => "cli",
        "redirect_uri"  => $this->redirect_url,
        "grant_type"    => "authorization_code"
      );

      $result = curl_exec_post_func($url, $data);

      if (isset($result['rsp_code']))
      {
        alert("토큰 발행에 실패하였습니다. 다시 시도해 주세요. 코드 : ".$result['rsp_code']. "메시지 : ".$result['rsp_message']);
        location_href('/login');
        exit;
      }

      $current_time = time();
      $expired_time = date("Y-m-d H-i-s", $current_time + $result['expires_in']);  

      $result['expires_in'] = $expired_time; //결과의 종료 시간에 계산한 시간을 대입.

      $input = $this->set_token_input($result);

      $end = $this->api_model->save_token($input, $auth_result);

      if ($end == 1)
      {
        alert("토큰 발행 성공 하셨습니다.");
        location_href("/login");
        exit;
      }
      alert("데이터 베이스 등록에 실패하였습니다. 다시 시도해주세요.");
      location_href("/login");
    }

    public function refresh_token_func()
    {
      $token = $this->api_model->get_token_info();
      $refresh_token = $token['refresh_token']; //가장 마지막으로 등록된 토큰의 refresh token

      if (!isset($refresh_token))
      {
        alert("refresh 토큰이 없습니다. 토큰을 다시 발행 해주세요.");
        exit;
      }

      $now = date("Y-m-d H:i:s");
      
      $calc = strtotime($token['expires_in']) - strtotime($now);
      $calc = floor($calc / 60 / 60 / 24) + 10; //일수로 표현하기 갱신 토큰의 경우 10일 더함.

      if ($calc < 0) 
      {
        alert("토큰 갱신기간이 만료되었습니다. 다시 발급해주세요.");
        location_href('/login');
        exit;
      }

      // echo $calc;

      // exit;

      $url = "https://testapi.openbanking.or.kr/oauth/2.0/token";

      $data = array(
        "client_id"     => $this->client_id,
        "client_secret" => "",
        "refresh_token" => $refresh_token,
        "scope"         => 'login inquiry',
        "grant_type"    => "refresh_token"
      );

      $result = curl_exec_post_func($url, $data);

      if (isset($result['rsp_code']))
      {
        alert("토큰 발행에 실패하였습니다. 다시 시도해 주세요. 코드 : ".$result['rsp_code']. "메시지 : ".$result['rsp_message']);
        location_href("/login");
        exit;
      }

      $current_time = time();
      $expired_time = date("Y-m-d H-i-s", $current_time + $result['expires_in']);
      $result['expires_in'] = $expired_time;
      $input = $this->set_token_input($result);

      $end = $this->api_model->refreshing_token($input);

      if ($end == 1)
      {
        alert("토큰 재발행 성공 하셨습니다.");
        location_href("/login");
        exit;
      }
      alert("데이터 베이스 등록에 실패하였습니다. 다시 시도해주세요.");
    }

    public function authorize_acount() // 1년 갱신 
    {
      $url = "https://testapi.openbanking.or.kr/oauth/2.0/authorize_account";
      $state = bin2hex(random_bytes(16)); //랜덤 난수값

      $data = array(
        'response_type' => 'code',
        'client_id'     => $this->client_id, //발급받은 api키
        'redirect_uri'  => $this->redirect_url,
        'scope'         => "login inquiry",
        'state'         => $state,
        'auth_type'     => "0",
        'client_info'   => "test",
      );

      $url = "https://testapi.openbanking.or.kr/oauth/2.0/authorize_account"."?". http_build_query($data, '', );
      redirect($url);
    }

    public function transaction_list()
    {
      $this->load->view('/templates/login/transaction');
    }

    public function transaction_list_func()
    {
      $post_from_time = $this->input->post("from_date");
      $post_to_time = $this->input->post("to_date");
      $post_fintehc = $this->input->post('fintech');
      $post_trace = $this->input->post('trace');
      // $post_type = $this->input->post('inout_type');
      $from_date = date("Ymd", strtotime($post_from_time)); 
      $to_date = date("Ymd", strtotime($post_to_time));

      // if ($post_fintehc == "" || $post_type == "") //아무 값도 입력 안됐을 경우
      // {
      //   alert("핀테크 번호 & 입/출금 구분을 선택해주세요");
      //   history_back();
      //   exit;
      // }

      
      if ($from_date == "19700101" || $to_date == "19700101") //아무 값도 입력 안됐을 경우
      {
        alert("날짜를 지정해주세요");
        history_back();
        exit;
      }

      $user_info = $this->api_model->get_token_info();
      $access_token = $user_info['access_token'];
      $bank_tran_id = "M202202142"."U".$this->getrandStr(9);  // 이용기관번호 10자리 + U + 이용기관 부여번호(랜덤한 9자리) 

      $data = array(
        'bank_tran_id'             => $bank_tran_id,
        'fintech_use_num'          => $post_fintehc,
        'inquiry_type'             => 'O',
        'inquiry_base'             => 'D',
        'from_date'                => $from_date,
        // 'from_time'                => "092400",
        'to_date'                  => $to_date,
        // 'to_time'                  => "092500",
        'sort_order'               => 'D',
        'tran_dtime'               => date('YmdHis'),
        'befor_inquiry_trace_info' => $post_trace
      );

      echo "<pre>";
      var_dump($data);
      echo "</pre>";

      $url = "https://testapi.openbanking.or.kr/v2.0/account/transaction_list/fin_num"."?". http_build_query($data, '', ); ;

      $result = curl_exec_get_func($url, $access_token);

      if (!isset($result['res_list'])) //값이 없는 경우 오류메시지 출력
      {
        alert("오류 코드 : ". $result['rsp_code']."오류 메시지: ". $result['rsp_message']);
        history_back();
        exit;
      }

      foreach($result['res_list'] as $item)
      {
        $data = array(
          'fintech_use_num'          => $post_fintehc,
          'res_list_seq'             => null,
          'tran_date'                => $item['tran_date'],
          'tran_time'                => $item['tran_time'],
          'inout_type'               => $item['inout_type'],
          'tran_type'                => $item['tran_type'],
          'print_content'            => $item['print_content'],
          'tran_amt'                 => $item['tran_amt'],
          'after_balance_amt'        => $item['after_balance_amt'],
          'branch_name'              => $item['branch_name'],
          'modt'                     => date("Y-m-d H:i:s"),
          'befor_inquiry_trace_info' => $post_trace
        );
        $this->api_model->save_transaction_list($data);
      }

      echo "<pre>";
      print_r ($result);
      echo "</pre>";
    }

    public function get_fintech_num_func()
    {
      $list = $this->api_model->get_account_list();
      print_r (json_encode($list));
    }

  }