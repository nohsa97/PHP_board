<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');

    class Login extends CI_Controller
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
            if ( isset($this->session->ID) ) //로그인 되어있을 시. 바로 리스트 페이지 이동 
            {
                redirect("/board");
            }
           
            $this->load->view('/templates/header');
            $this->load->view('/templates/login/login');
            $this->load->view('/templates/footer');
        }



        public function login()
        {
            
            $input_ID = $this->input->post('inputID');
            $input_pass = $this->input->post('inputPass');
            $input_pass = hash("sha256", $input_pass);
            $AFK = $this->User_model->get_AFK($input_ID);
        

            if ( isset($AFK[0]['AFK']) ) //아이디 afk가 존재한다면 
            {
                $inputArr = array(
                    'ID' => $input_ID,
                    'Password' => $input_pass.(string)$AFK[0]['AFK']
                );
                    
                $result = $this->User_model->check_user($inputArr);

                if ($result) // 값이 존재한다면
                {
                    $_SESSION['ID'] = $input_ID;
                    header('Location: /board/0');
                }
                
                else
                {
                    alerting("ID와 PW가 일치하지 않습니다.");
                    history_back();
                }
    
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