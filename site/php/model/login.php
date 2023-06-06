<?php
if ( ! defined('SITE_ADDRESS')) {
    exit("invalid request");
}

array_walk($_POST, 'Functions::callback_array_walk_trim');
array_walk($_GET, 'Functions::callback_array_walk_trim');

require_once(dirname(__FILE__) . '/../../../site/config/access_credentials.php');

// page_vars defaults
$page_vars                         = array();
$page_vars['is_form_submitted']    = false;
$page_vars['form_success']         = true;
$page_vars['form_errors']          = array();
$page_vars['form_hidden_elements'] = array();
$page_vars['form_error_inputs']    = array();
$page_vars['post_values']          = $_POST;
$page_vars['get_values']           = $_GET;

// logic
if ($result_array['page_success'] == true && isset($_POST['username']) && isset($_POST['user_password'])
    && $_POST['username'] != ''
    && $_POST['user_password'] != ''
) {
    $page_vars['is_form_submitted'] = true;

    // login
    $username = $_POST['username'];
    $password = $_POST['user_password'];

    $is_login_success = false;
    foreach ($access_credentials as $credential){
        if ($username == $credential[0] && $password == $credential[1]){
            $is_login_success = true;
            break;
        }
    }

    if ($is_login_success == false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'wrong_credentials';
    } else {
        $siteUser               = new SiteUser();
        $siteUser->username     = $username;
        $siteUser->is_logged_in = true;
        $userSession->setSiteUser($siteUser);

        header('Location: dashboard.php');
        exit();
    }
}
