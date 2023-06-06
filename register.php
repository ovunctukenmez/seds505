<?php
require_once("site/config/site.php");
require_once("site/config/auto_loaders.php");

$userSession = new UserSession();
if ($userSession->isSiteUserLoggedIn() == true){
    header("Location: dashboard.php");
    exit();
}

$site_info = array();
$site_info['title'] = 'Register';
$site_info['description'] = '';
$site_info['keywords'] = '';

$result_array = array();
$result_array['page_success'] = true;
$result_array['page_errors'] = array();

require_once('site/php/model/register.php');

$data = array();
$data['current_page'] = 'login';
$data['href_format'] = 'href="%s"';
$data['src_format'] = 'src="%s"';
$data['site_info'] = $site_info;
$data['result_array'] = $result_array;
$data['page_vars'] = isset($page_vars) ? $page_vars : array();

require_once 'ui/login.php';
