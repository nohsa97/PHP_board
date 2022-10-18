<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
// $route['default_controller'] = 'blog';
// $route['(:any)'] = '';

$route['board/(:num)'] = 'board';