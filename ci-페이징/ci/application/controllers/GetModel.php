<?
    defined('BASEPATH') OR exit('NO');

    class GetModel extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();
        }
        public function board()
        {
            $this->load->model('Board_model');
            $data['boards'] = $this->Board_model->GetBoards();
            $this->load->view('templates/header');
            $this->load->view('templates/boards', $data);
            $this->load->view('templates/footer');
        }

        public function helpT()
        {
            $this->load->helper();
        }
    }
?>