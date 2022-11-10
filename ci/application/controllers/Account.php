<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Account extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array("url", "JS", "Curl"));
      $this->load->model('api_model');

      $this->client_id = "";
      $this->redirect_url = "http://ci.test.co.kr/oauth/get_access_token";
    }

    public function get_account_list_func()
    {
      $list = $this->api_model->get_account_list();
      print_r (json_encode($list));
    }

    public function get_account()
    {
      $token = $this->api_model->get_token_info();
      $user_seq_no = $token['user_seq_no'];
      $access_token = $token['access_token'];

      $now = date("Y-m-d H:i:s");

      $calc = strtotime($token['expires_in']) - strtotime($now);
      $calc = floor($calc/60/60/24);
 
      if ($calc >= 0 && $calc < 30) //30일 이내의 경우 발급하라고 알림
      {
        echo("토큰 인증기간이 ${calc}일 남았습니다. 새로 발급해주세요.");
      }

      if ($calc < 0)
      {
        echo("토큰 인증기간이 끝났습니다. 토큰을 갱신하시거나 새로 발급해주세요.");
        location_href("/login");
        exit;
      }

      $data = array(
        'user_seq_no' => $user_seq_no,
        'include_cancel_yn' => 'Y',
        'sort_order' => 'D'
      );

      $url = "https://testapi.openbanking.or.kr/v2.0/account/list"."?". http_build_query($data, '', );

      $result = curl_exec_get_func($url, $access_token);

      if ($result['rsp_code'] != "A0000")
      {
        echo("계좌 조회에 실패하였습니다. 다시 시도해 주세요. 코드 : ".$result['rsp_code']. "메시지 : ".$result['rsp_message']);
        // location_href("/login");
        exit;
      }

      if ($result['rsp_code'] == "A0316") // 정보 제공 동의 1년 만료
      {
        echo("출금 동의 및 제 3자 정보 제공 동의가 1년이 지나 만료되었습니다. 재동의 신청 부탁 드립니다.");
        // location_href("/login");
        exit;
      }

      foreach ($result['res_list'] as $account) //같은 값이 존재한다면.
      {
        $test = $this->api_model->check_fintech_num($account['fintech_use_num']);
        if (isset($test))
        {
          continue;
        }

        $data = array(
          'fintech_use_num'      => $account['fintech_use_num'],
          'account_alias'        => $account['account_alias'],
          'bank_code_std'        => $account['bank_code_std'],
          'bank_code_sub'        => $account['bank_code_sub'],
          'bank_name'            => $account['bank_name'],
          'account_num_masked'   => $account['account_num_masked'],
          'account_holder_name'  => $account['account_holder_name'],
          'account_holder_type'  => $account['account_holder_type'],
          'inquiry_agree_yn'     => $account['inquiry_agree_yn'],
          'inquiry_agree_dtime'  => $account['inquiry_agree_dtime'],
          'transfer_agree_yn'    => $account['transfer_agree_yn'],
          'transfer_agree_dtime' => $account['transfer_agree_dtime'],
          'account_state'        => $account['account_state'],
          'savings_bank_name'    => $account['savings_bank_name'],
          'account_seq'          => $account['account_seq'],
          'account_type'         => $account['account_type'],
          'modt'                 => date("Y-m-d H:i:s")
        );
        $this->api_model->save_account($data);
      }
      echo("갱신 되었습니다");
      // location_href("/oauth/account_list");
    }
  }

  //2023-02-07 16:21:25