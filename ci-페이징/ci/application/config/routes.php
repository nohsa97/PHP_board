<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login_con/loginpage';
// $route['default_controller'] = 'blog';
// $route['(:any)'] = '';

$route['board_con/(:num)'] = 'board_con';