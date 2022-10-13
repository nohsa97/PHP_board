<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');

    class Login_con extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->helper("url");
            $this->load->helper("JS");
            $this->load->model('User_model');
        }

        public function index() //페이지 로드
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
                $_SESSION['ID'] = $inputID;
                header('Location: /board_con/0');
            }
            else
            {
                alerting("ID와 PW가 일치하지 않습니다.");
                history_back();
            }
        }

        public function logout()
        {
            unset($_SESSION['ID']);
            alerting("로그아웃 하셨습니다.");
            $this->load->view('/templates/header');
            $this->load->view('/templates/login/login');
            $this->load->view('/templates/footer');
        }



        
          
    }
?>