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

        public function _remap($method)
        {
            if (!strpos($method, "_func"))  //함수만 쓸것 - 뷰를 안나타낼거면 헤더와 푸터가 필요없다.
            {
                    $this->load->view('/templates/header');  
                    
            }

            if (method_exists($this, $method)) {
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
            
            $input_ID = $this->input->post('inputID');
            $input_pass = $this->input->post('inputPass');
            $input_pass = hash("sha256", $input_pass);
            $AFK = $this->User_model->get_AFK($input_ID);
        

            if (isset($AFK[0]['AFK'])) //아이디 afk가 존재한다면 
            {
                $inputArr = array(
                    'ID' => $input_ID,
                    'Password' => $input_pass.(string)$AFK[0]['AFK']
                );
                    
                $result = $this->User_model->check($inputArr);

                if ($result) // 값이 존재한다면
                {
                    $_SESSION['ID'] = $input_ID;
                    header('Location: /board');
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

        public function logout_func()
        {
            unset($_SESSION['ID']);
            alerting("로그아웃 하셨습니다.");
            location_href("../login");
        }

        public function find()
        {
            if ($this->input->post('input_ID') == NULL)
            {
                $input_name = $this->input->post('input_name');
                $input_email = $this->input->post('input_email');
                $input_arr = array(
                    'Name' => $input_name,
                    'Email' => $input_email
                );
                $result = $this->User_model->findPW($input_arr);
      
                if (isset($result[0]))
                {
                    alerting("회원님의 아이디는 ".$result[0]['ID']." 입니다");
                    location_href("../login");
                }
                else 
                {
                    alerting("해당 아이디가 없습니다.");
                    history_back();
                }
            }
            else
            {
                $input_ID = $this->input->post('input_ID');
                $input_name = $this->input->post('input_name');
                $input_email = $this->input->post('input_email');
                $input_arr = array(
                    'ID' => $input_ID,
                    'Name' => $input_name,
                    'Email' => $input_email
                );
                $result = $this->User_model->findPW($input_arr);
      
                if (isset($result[0]))
                {
                    // location_href("../login/newPW_page");
                    $this->load->view('/templates/login/newPW', $input_arr);   
                    
                }
                else 
                {
                    alerting("일치하는 정보가 없습니다.");
                    history_back();
                }
            }
    
        }


        public function newPW_func()
        {
            $before_PW = $this->input->post('before_PW');
            $ID = $this->input->post('ID');
            $before_PW = hash("sha256", $before_PW);
            $AFK = $this->User_model->get_AFK($ID);
            
            
            $input_arr = array(
                'ID' => $ID,
                'Password' => $before_PW.(string)$AFK[0]['AFK']
            );

            if ($this->User_model->check($input_arr) != NULL)
            {
                $new_PW = $this->input->post('after_PW');
                $new_PW = hash("sha256", $new_PW);

                $input_arr = array(
                    'ID' => $ID,
                    'Password' => $new_PW.(string)$AFK[0]['AFK']
                );
  
                $this->User_model->update_user($input_arr);
                alerting("변경 완료");
                location_href("/");
            }
            else 
            {
                alerting("비밀번호를 다시 확인해주세요.");
                history_back();
            }
            
        }

        
          
    }
?>