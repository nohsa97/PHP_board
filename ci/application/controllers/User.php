<?
class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array("url", "JS", "url", "form"));
    $this->load->model('user_model');
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

  public function index()
  {
    $data = $this->user_model->get_user('ID, Name, Email, user_img', array('ID' => $_SESSION['ID']));
    $this->load->view('/templates/login/mypage', $data);
  }

  public function upload_userImg()
  {
    $user = $_SESSION['ID'];
    $tmp = $_FILES['image']['tmp_name'];
    $name = $user.".jpg";
    move_uploaded_file($tmp, "./public/asset/user/$name");

    $name = '/public/asset/user/'.$name;
    $this->user_model->update_user(array('set' => 'user_img', 'user_img' => $name, 'ID' => $user));
    redirect('/user');
  }

  public function withdrawal_func()
  {
    $user_id = $this->input->post('ID');
    $data = array(
      'ID' => $user_id
    );
    $result = $this->user_model->withdrawal($data);

    if ($result == 1)
    {
      echo "탈퇴 성공";
      session_destroy();
    }
    else
    {
      echo "탈퇴 실패";
    }
  }

  public function test_func()
  {
    echo "curl반송";
  }

}

?>