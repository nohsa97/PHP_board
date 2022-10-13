<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');

    class Register extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper("url");
            $this->load->model('User_model');
        }

                
        public function index() //가입페이지 로드
        {
            $this->load->view('/templates/header');
            $this->load->view('/templates/login/register');
            $this->load->view('/templates/footer');
        }

        public function check()
        {

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

            $input_ID = $this->input->post('input_ID');
            $input_pass = $this->input->post('input_pass');
            $input_pass = hash("sha256", $input_pass);
            $input_name = $this->input->post('input_name');
            $input_email = $this->input->post('input_email');
            
            $MAX = $this->User_model->get_Max() + 1;



            $input_arr = array(
                'AFK' => null,
                'ID' =>  $input_ID,
                'Password' =>  $input_pass.(string)$MAX, //형변환하는 이유는 앞에건 문자열이고 뒤에건 숫자라 형변환 해줘야함
                'Name' =>  $input_name,
                'Email' =>  $input_email,
                'Permission' =>  1,
            );
            $result = $this->User_model->insert_user($input_arr);

            if ($result)
            {
                redirect('http://ci.test.co.kr');
            }
            else
            {
                alerting("가입에 실패했습니다.");
            }
        

        }

    }
    
?>