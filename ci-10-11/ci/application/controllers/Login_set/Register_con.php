<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');

    class Register_con extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

                
        public function index() //가입페이지 로드
        {
            $this->load->view('templates/header');
            $this->load->view('templates/login/register');
            $this->load->view('templates/footer');
        }

        public function check()
        {
            $this->load->model('User_model');

            $inputID = $this->input->post('input_ID');

            $inputArr = array(
                'ID' => $inputID
            );

            $result = $this->User_model->check_user($inputArr);

            if ($result)
            {
                echo "이미 존재하는 ID입니다.";
                $this->CHECK_ID = false;
            }
                    
            else
            {
                echo "가능한 ID입니다.";
                $this->CHECK_ID = true;
            }
        }

        public function register_ID()
        {
            $this->load->helper('JS');


            $this->load->model('User_model');
            $input_ID = $this->input->post('input_ID');
            $input_pass = $this->input->post('input_pass');
            $input_pass = hash("sha256", $input_pass);
            $input_name = $this->input->post('input_name');
            $input_email = $this->input->post('input_email');


            $input_arr = array(
                'AFK' => null,
                'ID' =>  $input_ID,
                'Password' =>  $input_pass,
                'Name' =>  $input_name,
                'Email' =>  $input_email,
                'Permission' =>  1,
            );
            $result = $this->User_model->insert_user($input_arr);

            if ($result)
            {
                alerting("회원 가입 성공");
            }
            else
            {
                alerting("실패");
            }
        

        }

    }
    
?>