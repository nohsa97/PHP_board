<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Transaction extends CI_Controller
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array("url", "JS", "Curl"));
      $this->load->model('api_model');

      $this->client_id = "";
      $this->redirect_url = "http://ci.test.co.kr/oauth/get_access_token";
    }

    public function get_transaction_list()
    {
      // $inout_type = $this->input->post('inout_type');
      $fintech = $this->input->post('fintech');
      // $from_date = $this->input->post('from_date');
      // $to_date = $this->input->post('to_date');

      $result = $this->api_model->get_transaction_list($fintech);
      print_r (json_encode($result));

    }
  }
  
?>
