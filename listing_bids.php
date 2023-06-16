<?php
require_once("site/config/site.php");
require_once("site/config/auto_loaders.php");
require_once("site/config/db.php");

$userSession = new UserSession();

if ($userSession->isSiteUserLoggedIn() == false){
    header("Location: login.php");
    exit();
}

$site_info = array();
$site_info['title'] = 'Listing Bids';
$site_info['description'] = '';
$site_info['keywords'] = '';

$result_array = array();
$result_array['page_success'] = true;
$result_array['page_errors'] = array();

require_once('site/php/model/listing_bids.php');

$data = array();
$data['current_page'] = 'listing_bids';
$data['href_format'] = 'href="%s"';
$data['src_format'] = 'src="%s"';
$data['site_info'] = $site_info;
$data['result_array'] = $result_array;
$data['page_vars'] = isset($page_vars) ? $page_vars : array();

require_once 'ui/listing_bids.php';
