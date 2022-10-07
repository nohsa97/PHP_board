<?
    // defined('BASEPATH') OR exit('No direct');

    class Topic extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }
        public function index()
        {
            
            echo "asdxxx";
        }

   

        public function get($param)
        {
            echo "get id = ".$param;
        }
    }
?>