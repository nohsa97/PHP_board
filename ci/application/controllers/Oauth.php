<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Oauth extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array("url", "JS"));
      $this->load->model('api_model');
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
      $this->load->view('/templates/login/oauth');
    }

    public function action() //페이지 로드
    {
      $this->load->view('/templates/login/oauth_action');
    }

    public function get_authorization_code_func()
    {
      $data = array(
        'response_type' => 'code',
        'client_id' => "e5ec3078-b63e-4486-bf67-96395cdb45a5",
        'redirect_uri' => "http://ci.test.co.kr/oauth/action",
        'scope' => "login inquiry transfer cardinfo fintechinfo",
        'state' => "b80BLsfigm9OokPTjy03elbJqRHOfGSY",
        'auth_type' => "0",
        'authorized_cert_yn' => 'N',
      );

      $url = "https://testapi.openbanking.or.kr/oauth/2.0/authorize"."?".http_build_query($data, '', );

      echo $url;

    }

    public function get_access_token_func()
    {
      $url = "https://testapi.openbanking.or.kr/oauth/2.0/token";

      $body_data = array(
        "code" => $_POST['code'],
        "client_id" => "e5ec3078-b63e-4486-bf67-96395cdb45a5",
        "client_secret" => "d1a6e0c9-7996-4eb0-90ee-968acaff8740",
        "redirect_uri" => "http://ci.test.co.kr/oauth/action",
        "grant_type" => "authorization_code"
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=utf-8'));
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body_data, '', '&'));
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec ($ch);
      curl_close($ch);

      echo ($result);
    }

    public function save_data_func()
    {
      $access_token = $this->input->post('access_token');
      $refresh_token = $this->input->post('refresh_token');
      $user_seq_no = $this->input->post('user_seq_no');

      $now_time = date("Y-m-d");
      $expired_time = date("Y-m-d", strtotime($now_time."+90 day"));

      $input = array(
        'seq' => null,
        'access_token' => $access_token,
        'expires_in' => $expired_time,
        'refresh_token' => $refresh_token,
        'scope' => 'login',
        'user_seq_no' => $user_seq_no,
        'modt' => date("Y-m-d")
      );

      echo $this->api_model->save_data($input);
    }

  }