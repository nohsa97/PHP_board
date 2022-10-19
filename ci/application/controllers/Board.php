<?php
  if (!defined('BASEPATH')) exit ('NO direct script access allowed');

  class Board extends CI_Controller 
  {
    public function __construct()
    {
      parent::__construct();
      $this->load->model(array('board_model', 'comment_model'));
      $this->load->helper(array("url","js"));
      $this->load->library("pagination");
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
      $max_board = $this->board_model->get_board_count();

      
      $paging = array();
      $paging['base_url'] = "/board";
      $paging['total_rows'] = $max_board;
      $paging['per_page'] = 5;
      $paging['uri_segment'] = 2;
      $paging['num_links'] = 3;
                                      
      $paging['full_tag_open'] = '<ul class="pagination" style="justify-content : center !important; " >';
      $paging['full_tag_close'] = '</ul>';
      $paging['num_tag_open'] = '<div class="page-link">';
      $paging['num_tag_close'] = '</div>';
      $paging['cur_tag_open'] = '<b class="page-link"">';
      $paging['cur_tag_close'] = '</b>';
      $paging['next_tag_open'] = '<div class="page-link">';
      $paging['next_tag_close'] = '</div>';
      $paging['prev_tag_open'] = '<div class="page-link">';
      $paging['prev_tag_close'] = '</div>';
      $paging['last_tag_open'] = '<div class="page-link">';
      $paging['last_tag_close'] = '</div>';
      $paging['first_tag_open'] = '<div class="page-link">';
      $paging['first_tag_close'] = '</div>';

      $this->pagination->initialize($paging);

      $page = ( $this->uri->segment(2) ? $this->uri->segment(2) : 0 );
      $data["links"] = $this->pagination->create_links();
      $data['lists'] = $this->board_model->get_board_list($paging["per_page"], $page);
      $data['MAX'] = $max_board - $page;
      $data['page'] = $page;

      //페이징 라이브러리 사용 paging 사용은 넘버링/ 
      $this->load->view("/templates/board/list", $data);
    }

    public function search()
    {
      $search_by = $this->input->get("search_by");
      $search_input = $this->input->get("search_input");
      $max_board = $this->board_model->get_count_search($search_by, $search_input);

      

      $paging = array();
      $paging['base_url'] = "/board/search";
      $paging['total_rows'] = $max_board;
      $paging['per_page'] = 3;
      $paging['uri_segment'] = 3;
      $paging['num_links'] = 3;
      $paging['reuse_query_string'] = TRUE;

              
      $paging['full_tag_open'] = '<ul class="pagination" style="justify-content : center !important; " >';
      $paging['full_tag_close'] = '</ul>';
      $paging['num_tag_open'] = '<div class="page-link">';
      $paging['num_tag_close'] = '</div>';
      $paging['cur_tag_open'] = '<b class="page-link"">';
      $paging['cur_tag_close'] = '</b>';
      $paging['next_tag_open'] = '<div class="page-link">';
      $paging['next_tag_close'] = '</div>';
      $paging['prev_tag_open'] = '<div class="page-link">';
      $paging['prev_tag_close'] = '</div>';
      $paging['last_tag_open'] = '<div class="page-link">';
      $paging['last_tag_close'] = '</div>';
      $paging['first_tag_open'] = '<div class="page-link">';
      $paging['first_tag_close'] = '</div>';

      $this->pagination->initialize($paging);


      $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
      $data["links"] = $this->pagination->create_links();
      $data['lists'] = $this->board_model->get_content_search($search_by, $search_input, $paging["per_page"], $page);
      $data['page'] = $page;
      $data['MAX'] = $max_board - $page;
      $data['search'] = array(
        'search_by' => $search_by,
        'search_input' => $search_input
      );
 

      $this->load->view('/templates/board/list', $data); 
    }

    public function get_content()
    {
      $b_seq = $this->input->get('b_seq');
      $this->board_model->visited_update($b_seq);

      $comment_count = $this->comment_model->get_comment_count($b_seq);
      $result_b = $this->board_model->get_content_count_comment($b_seq, $comment_count);
      $result_c = $this->comment_model->get_comment_list($b_seq);
      

      if ($this->input->get("search_input") != NULL) //검색 결과가 있을 경우.
      {
        $search_by = $this->input->get("search_by");
        $search_input = $this->input->get("search_input");
        $input_array = array(
          'search_by' => $search_by,
          'search_input' => $search_input
        );
        $bottom_navigate = $this->board_model->pre_next_content_search($b_seq, $input_array);
      }
      
      else 
      {
        $bottom_navigate = $this->board_model->pre_next_content($b_seq);
      }

      $data = array(
      'row' => $result_b,
      'comments' => $result_c,
      'bottom' => $bottom_navigate,
      'count' => $comment_count
      );

      $this->load->view('/templates/board/content', $data);
    }


    public function write_page() //글작성 페이지 
    {
      $b_seq = $this->uri->segment(3);

      if ( $b_seq != 0 )
      {
        $result_b = $this->board_model->get_content($b_seq);
        $data = array(
        'b_seq' => $result_b['b_seq'],
        'subject' => $result_b['subject'],
        'writer' => $result_b['writer'],
        'password' => $result_b['password'],
        'body' => $result_b['body'],
        'permission' => $result_b['permission']
      );
        $this->load->view('/templates/board/b_modify', $data); 
      }
      else
      { 
        $this->load->view('/templates/board/b_write');   
      }

    }

    public function write_action_func()
    {
      $b_seq = $this->input->post('b_seq'); //게시글 번호가 넘어옴
      $inputPass_hash = $this->input->post('input_pass');
      $inputPass_hash = hash("sha256", $inputPass_hash);

      $data = array(
      'b_seq' => null,
      'subject' => $this->input->post('subject'),
      'writer' => $this->input->post('input_ID'),
      'Password' => $inputPass_hash,
      'body' => $this->input->post('body'),
      'visited' => 0,
      'permission' => $this->input->post('permission')
      );

      if (isset($b_seq)) // 게시글 번호가 정의된 경우 -> 수정
      {
        $row = $this->board_model->get_content($b_seq); //데이터값 가져오기

        $data['b_seq'] = $b_seq;
        $data['visited'] = $row['visited'];
        $this->board_model->update_board($data);
      }

      else 
      {
      $b_seq = $this->board_model->insert_board($data);
      }

      redirect('../board/get_content?b_seq='.$b_seq.'&list=0');
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
        $base_comment = $this->board_model->get_content($b_seq);
        
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