<?php
  if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Board extends CI_Controller 
  {
    public $setting;
    public function __construct()
    {
      parent::__construct();
      $this->load->model(array('board_model', 'comment_model'));
      $this->load->helper(array("url","js"));
      $this->load->library("pagination");
      $this->setting = array(
        'base_url'    => "/board",
        'total_rows'  => 0,
        'per_page'    => 5,
        'uri_segment' => 2,
        'num_links'   => 3
      );
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

    public function paging_func($setting)
    {
      $paging = array();
      $paging['base_url']    = $setting['base_url'];
      $paging['total_rows']  = $setting['total_rows'];

      $paging['per_page']    = $setting['per_page'];
      $paging['uri_segment'] = $setting['uri_segment'];
      $paging['num_links']   = $setting['num_links'];
                                      
      $paging['full_tag_open']   = '<ul class="pagination" style="justify-content : center !important; " >';
      $paging['full_tag_close']  = '</ul>';
      $paging['num_tag_open']    = '<div class="page-link">';
      $paging['num_tag_close']   = '</div>';
      $paging['cur_tag_open']    = '<b class="page-link"">';
      $paging['cur_tag_close']   = '</b>';
      $paging['next_tag_open']   = '<div class="page-link">';
      $paging['next_tag_close']  = '</div>';
      $paging['prev_tag_open']   = '<div class="page-link">';
      $paging['prev_tag_close']  = '</div>';
      $paging['last_tag_open']   = '<div class="page-link">';
      $paging['last_tag_close']  = '</div>';
      $paging['first_tag_open']  = '<div class="page-link">';
      $paging['first_tag_close'] = '</div>';

      return $paging;
    }

    public function index()
    {
      if (isset($GLOBALS['search_input'])) // 검색값 존재
      {
        $search_by    = $GLOBALS['search_by'];
        $search_input = $GLOBALS['search_input'];
        $max_board    = $this->board_model->get_count_search($search_by, $search_input);
  
        $this->setting['per_page']    = 3;
        $this->setting['total_rows']  = $max_board;
        
        $paging = $this->paging_func($this->setting);
        $paging['reuse_query_string'] = TRUE;
      }
      else //검색값 없음.
      {
        $max_board = $this->board_model->get_board_count();
        $this->setting['total_rows'] = $max_board;

        $paging = $this->paging_func($this->setting);
      }

      $this->pagination->initialize($paging);
      $page = $this->uri->segment(2) ? $this->uri->segment(2) : 0;
      $data["links"] = $this->pagination->create_links();

      if (isset($GLOBALS['search_input']))
        $data['lists'] = $this->board_model->get_content_search($paging["per_page"], $page);
      
      else
        $data['lists'] = $this->board_model->get_board_list($paging["per_page"], $page);

      $data['MAX']   = $max_board - $page;
      $data['page']  = $page;

      $this->load->view("/templates/board/list", $data);
    }

    public function get_content_view()
    {
      $b_seq = $this->input->get('b_seq');
      $this->board_model->visited_update($b_seq);

      $comment_count = $this->comment_model->get_comment_count($b_seq);

      $result_b = $this->board_model->load_content($b_seq, $comment_count);
      $result_c = $this->comment_model->get_comment_list($b_seq);
      $writer = null;
      if ($result_b['permission'] == 1)
      {
        $writer = $result_b['writer'];
      }

      if (isset($GLOBALS['search_input'])) //검색 결과가 있을 경우.
      {
        $search_by    = $GLOBALS['search_by'];
        $search_input = $GLOBALS['search_input'];
        $input_array  = array(
          'search_by'    => $search_by,
          'search_input' => $search_input
        );
        
        $bottom_navigate = $this->board_model->pre_next_content_search($b_seq, $input_array);
      }
      
      else 
      {
        $bottom_navigate = $this->board_model->pre_next_content($b_seq);
      }

      $content = array(
        'content'  => $result_b,
        'comments' => $result_c,
        'bottom'   => $bottom_navigate,
        'count'    => $comment_count,
        'writer'   => $writer
      );

      $this->load->view('/templates/board/content', $content);
    }


    public function write_page() //글작성 페이지 
    {
      $b_seq = $this->uri->segment(3);

      if ( $b_seq != 0 )
      {
        $result_b = $this->board_model->get_content($b_seq);
        $this->load->view('/templates/board/b_modify', $result_b); 
      }
      else
      { 
        $this->load->view('/templates/board/b_write');   
      }
    }

    public function test()
    {
      $this->load->view('/templates/board/test');   
    }
    
    public function write_action_func()
    {
      $inputPass_hash = $this->input->post('input_pass');
      $inputPass_hash = hash("sha256", $inputPass_hash);

      $data = array(
      'b_seq'      => null,
      'subject'    => $this->input->post('subject'),
      'writer'     => $this->input->post('input_ID'),
      'Password'   => $inputPass_hash,
      'body'       => $this->input->post('body'),
      'visited'    => 0,
      'permission' => $this->input->post('permission')
      );

      if ($this->input->post('b_seq') != NULL) // 게시글 번호가 정의된 경우 -> 수정
      {
        $b_seq = $this->input->post('b_seq'); //게시글 번호가 넘어옴
        $row = $this->board_model->get_content($b_seq); //데이터값 가져오기

        $data['b_seq']   = $b_seq;
        $data['visited'] = $row['visited'];
        
        $this->board_model->update_board($data);
      }

      else 
      {
        $b_seq = $this->board_model->insert_board($data);
      }

      redirect('../board/get_content_view?b_seq='.$b_seq.'&list=0');
    }


    public function remove_func()
    {       
      $b_seq = $this->input->post("b_seq");

      $input_password = $this->input->post("input_pass");
      if ($input_password == NULL)
      {
        echo $this->board_model->remove_board($b_seq);
        exit;
      }
      else
      {
        $input_password = hash("sha256", $input_password);
        $base_comment   = $this->board_model->get_content($b_seq);
        
        if ($base_comment['password'] == $input_password)
        {
          echo $this->board_model->remove_board($b_seq);
        }
        else
        {
          echo 0;
        }
      }
    }

    public function check_func() //수정하기전 체크하는 함수 -> 위에 제거함수는 직접 제거하는 것임.
    {
      $input_pass = $this->input->post("input_pass");
      $input_pass = hash("sha256", $input_pass);

      $b_seq = $this->input->post("b_seq");

      $result = $this->board_model->get_content($b_seq); //값이 하나뿐일테니
      if($result['password'] == $input_pass)
      {
        echo 1;
      }
      else
      {
        echo "비밀번호가 다릅니다.";
      }
    }
  }

?>