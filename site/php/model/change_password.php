<?php
if (!defined('SITE_ADDRESS')) {
    exit("invalid request");
}

array_walk($_POST, 'Functions::callback_array_walk_trim');
array_walk($_GET, 'Functions::callback_array_walk_trim');

// page_vars defaults
$page_vars = array();
$page_vars['is_form_submitted'] = false;
$page_vars['form_success'] = true;
$page_vars['form_errors'] = array();
$page_vars['form_hidden_elements'] = array();
$page_vars['form_error_inputs'] = array();
$page_vars['post_values'] = $_POST;
$page_vars['get_values'] = $_GET;
$page_vars['provider_user'] = array();

// logic

// provider user - begin
$provider_user = array();

$get_vars = array();
$get_vars['action'] = 'fetchProviderUser';

$post_vars = array();
$post_vars['provider_id'] = $userSession->getConnectedProviderUser()->provider_id;
$post_vars['id'] = $userSession->getConnectedProviderUser()->id;
$post_vars['login_provider_id'] = $userSession->getConnectedProviderUser()->provider_id;
$post_vars['login_username'] = $userSession->getConnectedProviderUser()->login_username;
$post_vars['login_password'] = $userSession->getConnectedProviderUser()->login_password;

$response = ApiClient::makePostRequest($get_vars, $post_vars);
if ($response === null) {
    $result_array['page_success'] = false;
    $result_array['page_errors'][] = 'api_call_error';
	goto end_of_page;
} elseif ($response['result'] == 'success') {
    $provider_user = $response['values']['rows'][0];

} elseif ($response['result'] == 'error') {
    $result_array['page_success'] = false;
    $result_array['page_errors'][] = $response['error'];
	goto end_of_page;
}

$page_vars['provider_user'] = $provider_user;
// provider user - end

if ($result_array['page_success'] == true && isset($_POST['current_password']))
{
    $page_vars['is_form_submitted'] = true;

    $get_vars = array();
    $get_vars['action'] = 'editProviderUser';

    // update
    $post_vars = array();
    $post_vars['mode'] = 'update';
    $post_vars['action'] = 'change_password';
    $post_vars['id'] = $provider_user['id'];
    $post_vars['user_current_password'] = isset($_POST['current_password']) ? $_POST['current_password'] : null;
    $post_vars['user_password'] = isset($_POST['new_password']) ? $_POST['new_password'] : null;
    $post_vars['user_re_password'] = isset($_POST['re_password']) ? $_POST['re_password'] : null;
    $post_vars['login_provider_id'] = $userSession->getConnectedProviderUser()->provider_id;
    $post_vars['login_username'] = $userSession->getConnectedProviderUser()->login_username;
    $post_vars['login_password'] = $userSession->getConnectedProviderUser()->login_password;

    $response = ApiClient::makePostRequest($get_vars, $post_vars);
    if ($response === null) {
        $page_vars['form_success'] = false;
        $page_vars['form_errors'][] = 'api_call_error';
    } elseif ($response['result'] == 'success') {
        $userSession->getConnectedProviderUser()->login_password = $_POST['new_password'];
        $userSession->setConnectedProviderUser($userSession->getConnectedProviderUser());
        header('Location: change_password.php');
        exit();
    } elseif ($response['result'] == 'error') {
        $page_vars['form_success'] = false;
        $page_vars['form_errors'][] = $response['error'];
    }

}

end_of_page:
