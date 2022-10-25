<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');

class Register extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array("url", "JS"));
    $this->load->model('user_model');
    $this->load->library('email');
  }


  public function index() //가입페이지 로드
  {
    $this->load->view('/templates/header'); 
    $this->load->view('/templates/login/register');
    $this->load->view('/templates/footer'); 
  }

  public function check_ID()
  {
    $pattern  = "/^[a-zA-Z0-9]{5,19}+$/"; 
    $input_ID = $this->input->post('input_ID');


    if (!preg_match($pattern, $input_ID)) // 유효성 검사
    {
      echo "incongruity"; //부적합
      exit;
    }

    $inputArr = array(
     'ID' => $input_ID
    );

    $row = $this->user_model->get_user('ID', $inputArr);

    if (isset($row))
    {
      echo "DB";
    }

    else
    {
      echo "success";
    }
  }

  public function check_email()
  {
    $pattern     = "/^[a-zA-Z0-9+-\_.]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/"; 
    $input_email = $this->input->post('input_email');

    if (!preg_match($pattern, $input_email)) // 유효성 검사
    {
      echo "incongruity"; //부적합
      exit;
    }

    $inputArr = array(
      'Email' => $input_email
    );

    $row = $this->user_model->get_user('Email', $inputArr);

    if (isset($row))
    {
      echo "DB";
    }

    else
    {
      echo "success";
    }
  }

  public function register_ID()
  {
    $input_ID    = $this->input->post('input_ID');
    $input_pass  = $this->input->post('input_pass');
    $input_name  = $this->input->post('input_name');
    $input_email = $this->input->post('input_email');

    $pattern    = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/";
    $id_check   = $this->user_model->get_user('ID' ,array('ID' => $input_ID));
    $mail_check = $this->user_model->get_user('Email', array('Email' ,'Email' => $input_email));

    if (($id_check || $mail_check) || !preg_match($pattern, $input_pass)) //아디와 메일이 존재하거나 혹은 비밀번호가 양식에 맞지 않거나.
    {
      alert("가입에 실패했습니다.");
      location_href("/login");
      exit;
    }

    $input_pass = hash("sha256", $input_pass);

    $input_arr = array(
      'user_seq'   => null,
      'ID'         => $input_ID,
      'Password'   => $input_pass, //형변환하는 이유는 앞에건 문자열이고 뒤에건 숫자라 형변환 해줘야함 라는걸 user_model에서 실행함 .
      'Name'       => $input_name,
      'Email'      => $input_email,
      'Permission' => 1,
    );
    $result = $this->user_model->insert_user($input_arr);

    if ($result)
    {
      redirect('http://ci.test.co.kr');
    }
    else
    {
      alert("가입에 실패했습니다.");
    }
  }

}

?>