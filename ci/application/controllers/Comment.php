<?
if (!defined('BASEPATH')) exit ('NO direct script access allowed');
class Comment extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('comment_model', 'user_model'));
    $this->load->helper(array("url", "JS")); 
  }

  public function get_data($array)
  {
    $data = array(
      'c_seq'      => null,
      'b_seq'      => $array['b_seq'],
      'parent_seq' => null,
      'sort'       => 0,
      'c_depth'    => 0,
      'writer'     => $array['writer'],
      'password'   => $array['password'],
      'body'       => $array['body'],
      'permission' => $array['permission']
    );
    return $data;
  }

  public function comment_write()
  {
    $parent_c_seq = $this->input->post('c_seq');
    $b_seq        = $this->input->post('b_seq');
    $writer       = $this->input->post('writer');
    $body         = $this->input->post('body');
    $hash_pass    = $this->input->post('password');
    $permission   = ($this->input->post('permission') ? 1 : 0); //값이 존재한다면 1 아니면 0  회원 댓글만 퍼미션 변수를 넘김/

    if ($permission == 1) // 
    {
      $hash_pass = $this->user_model->get_user('user_seq', array('ID' => $writer))['user_seq'];
    }

    $hash_pass = hash("sha256", $hash_pass);
    $input = array(
      'b_seq'      => $b_seq,
      'writer'     => $writer,
      'password'   => $hash_pass,
      'body'       => $body,
      'permission' => $permission
    );


    if (!isset($parent_c_seq))  //포스트로 부모 시퀀스가 안넘어왔다 -> 댓글 
    {
      $data = $this->get_data($input);
      echo $this->comment_model->insert_comment($data);
    }

    else
    {
      $parent_comment = $this->comment_model->get_comment($parent_c_seq);

      if ($parent_comment['c_depth'] == 0)
      {
        $sort = $this->comment_model->get_max_sort();    
      }
      else
      {
        $sort = $parent_comment['sort'];
      }
      $data = $this->get_data($input);

      $data['parent_seq'] = $parent_comment['parent_seq'];
      $data['sort']       = $sort + 1;
      $data['c_depth']    = $parent_comment['c_depth'] + 1;

      $this->comment_model->insert_reply($data, $parent_c_seq);
      $pre_page = $_SERVER['HTTP_REFERER'];
      location_href($pre_page);
    }
  }

  public function remove_func()
  {
    $input_pass = $this->input->post("input_pass");
    $c_seq      = $this->input->post("c_seq");
    $user_id    = $this->input->post("ID");

    if(isset($user_id)) //유저아이디가 존재한다 > 유저의 댓글  비회원 댓글은 아이디를 안넘기고 비밀번호를 넘김.
    {
      $input_pass = $this->user_model->get_user('user_seq', array('ID' => $user_id))['user_seq'];
    }
    $input_pass   = hash("sha256", $input_pass);
    $base_comment = $this->comment_model->get_comment($c_seq);
    
    if ($base_comment['c_depth'] == 0 && $base_comment['password'] == $input_pass)
    {
      echo $this->comment_model->remove_comment($c_seq); 
    }
    else if ($base_comment['c_depth'] != 0 && $base_comment['password'] == $input_pass)
    {
      echo $this->comment_model->remove_reply($c_seq);
    }
    else
    {
      echo 0;
    }
  }
  public function update_func()
  {
    $input_pass   = $this->input->post("input_pass");
    $c_seq        = $this->input->post("c_seq");
    $input_body   = $this->input->post("body");
    $base_comment = $this->comment_model->get_comment($c_seq);

    if ($base_comment['permission'] == 1) // 
    {
      $input_pass = $this->user_model->get_user('user_seq', array('ID' => $base_comment['writer']))['user_seq'];
    }

    $input_pass = hash("sha256", $input_pass);
    if($base_comment['password'] == $input_pass)
    {
      $input_arr = array(
      'c_seq'    => $c_seq,
      'password' => $input_pass,
      'body'     => $input_body      
      );
      echo $this->comment_model->update_func($input_arr);
    }
    else 
    {
      echo 0;
    }

  }


}
?>