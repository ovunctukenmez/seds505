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
$page_vars['form_messages']        = array();
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
    && $_POST['email'] != ''
) {
    $page_vars['is_form_submitted'] = true;

    // reset_password
    $email = $_POST['email'];

    // check user
    $sql
        = <<<EOF
SELECT
t1.id,
t1.is_deleted
FROM users t1
WHERE
t1.email = :email
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $result_array['page_success']  = false;
        $result_array['page_errors'][] = 'sqlError';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);

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

    // generate new password
    $password = substr(md5(rand()), 0, 6);

    // update user password
    $sql
        = <<<EOF
UPDATE users
SET
password = :password
WHERE
id = :id;
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'editListings';
        goto end_of_page;
    }

    $id = $user['id'];

    // Bind values
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = $db->errorCode();
        goto end_of_page;
    } else {
        $page_vars['form_messages'][] = 'Your new password has been generated: ' . $password;
    }
}

end_of_page:
