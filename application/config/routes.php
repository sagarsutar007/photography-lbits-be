<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['search-phone'] = 'auth';
$route['update-user'] = 'users/updateUser';
$route['check-username'] = 'users/checkUserName';
$route['get-user'] = 'users/fetchUser';
$route['update-profile'] = 'users/updateProfile';
$route['reset-pin'] = 'users/updatePin';
$route['messages'] = 'messages/fetchUserMessages';
$route['add-service'] = 'services/addService';
$route['services'] = 'services/getServices';
$route['add-abstract'] = 'abstracts/addAbstract';
$route['abstracts'] = 'abstracts/getAbstracts';
$route['send-message'] = 'messages/SendMessage';

