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
    if (!strpos($method, "_func")) 
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
    $data = $this->user_model->get_user(array('ID' => $_SESSION['ID']));
    $this->load->view('/templates/login/mypage', $data);
  }

  public function get_user_img_func()
  {
    $user = $this->input->post("user");
    $img = $this->user_model->get_user(array('ID' => $user))['user_img'];
    echo $img;
  }

  public function upload_userImg()
  {
    if ($_FILES['image']['name'] == null)
    {
      alert("파일을 올려주세욧.");
      location_href('/user');
      exit;
    }
    $path = pathinfo($_FILES['image']['name']);

    switch($path['extension'])
    {
        case 'jpeg' :
        case 'jpg'  :
        case 'png'  :
        case 'bmp'  :
        case 'gif'  :
          break;
        default     :
          alert("형식에 맞지않는 파일입니다.");
          location_href('/user');
          exit;
    }

    $user = $_SESSION['ID'];
    $user_seq = $this->user_model->get_user(array('ID' => $user))['user_seq'];
    $user_img = $this->user_model->get_user(array('ID' => $user))['user_img'];

    if ($user_img != null)
    {
      if( !unlink(".".$user_img) ) {
        echo "failed\n";
      }
      else {
        echo "success\n";
      }
    }

    $file_name = uniqid($user_seq."_");

    $tmp = $_FILES['image']['tmp_name'];
    $path = pathinfo($_FILES['image']['name']);
    $name = $file_name.".".$path['extension'];
    
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

}

?>