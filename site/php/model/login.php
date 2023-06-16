<?php
if ( ! defined('SITE_ADDRESS')) {
    exit("invalid request");
}

array_walk($_POST, 'Functions::callback_array_walk_trim');
array_walk($_GET, 'Functions::callback_array_walk_trim');

// page_vars defaults
$page_vars                         = array();
$page_vars['is_form_submitted']    = false;
$page_vars['form_success']         = true;
$page_vars['form_errors']          = array();
$page_vars['form_hidden_elements'] = array();
$page_vars['form_error_inputs']    = array();
$page_vars['post_values']          = $_POST;
$page_vars['get_values']           = $_GET;

// db connection
try {
    $db = new PDO(PDO_dsn, PDO_username, PDO_password);
} catch (PDOException $exception) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = $exception->getCode() . ' - ' . $exception->getMessage();
    goto end_of_page;
}

// logic
if ($result_array['page_success'] == true
    && isset($_POST['email'])
    && isset($_POST['user_password'])
    && $_POST['email'] != ''
    && $_POST['user_password'] != ''
) {
    $page_vars['is_form_submitted'] = true;

    // login
    $email = $_POST['email'];
    $password = $_POST['user_password'];

    // check user
    $sql
        = <<<EOF
SELECT
t1.id,
t1.email,
t1.is_deleted
FROM users t1
WHERE
t1.email = :email
AND t1.password = :password
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $result_array['page_success']  = false;
        $result_array['page_errors'][] = 'sqlError';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = $db->errorCode();
        goto end_of_page;
    } else {
        $user = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['is_deleted'] == true) {
                continue;
            }
            $user = $row;
        }
        $stmt->closeCursor();

        if (count($user) == 0) {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = 'user not found';
            goto end_of_page;
        }
    }

    // login user
    $siteUser               = new SiteUser();
    $siteUser->email        = $user['email'];
    $siteUser->is_logged_in = true;
    $userSession->setSiteUser($siteUser);

    header('Location: dashboard.php');
    exit();
}

end_of_page:
