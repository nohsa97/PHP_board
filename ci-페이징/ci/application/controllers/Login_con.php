<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');

    class Login_con extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('User_model');
        }

        public function loginPage() //페이지 로드
        {
           
            $this->load->view('/templates/header');
            $this->load->view('/templates/login/login');
            $this->load->view('/templates/footer');
            
        }



        public function login()
        {
            
            $this->load->helper('url');
            $this->load->helper('JS');
            
            $inputID = $this->input->post('inputID');
            $inputPass = $this->input->post('inputPass');
            $inputPass = hash("sha256", $inputPass);
            $inputArr = array(
                'ID' => $inputID,
                'Password' => $inputPass
            );

            $result = $this->User_model->check_user($inputArr);

            if ($result) // 값이 존재한다면
            {
                // $session_data = array (
                //     'userID' => $inputID,
                // );
                // $this->session->set_userdata($session_data);
                // alerting("$inputID 님 환영합니다.");
                header('Location: /board_con');
                // redirect('blog');
            }
            else
            {
                alerting("ID와 PW가 일치하지 않습니다.");
                history_back();
            }
        }

        public function logout()
        {
            $this->load->view('/templates/header');
            $this->load->view('/templates/login/login');
            $this->load->view('/templates/footer');
        }



        
          
    }
?>