<?php
if ( ! defined('SITE_ADDRESS')) {
    exit("invalid request");
}

array_walk($_POST, 'Functions::callback_array_walk_trim');
array_walk($_GET, 'Functions::callback_array_walk_trim');

// page_vars defaults
$page_vars                          = array();
$page_vars['is_form_submitted']     = false;
$page_vars['form_success']          = true;
$page_vars['form_errors']           = array();
$page_vars['form_hidden_elements']  = array();
$page_vars['form_error_inputs']     = array();
$page_vars['post_values']           = $_POST;
$page_vars['get_values']            = $_GET;

// db connection
try {
    $db = new PDO(PDO_dsn, PDO_username, PDO_password);
} catch (PDOException $exception) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = $exception->getCode() . ' - ' . $exception->getMessage();
    goto end_of_page;
}

// logic

if ($result_array['page_success'] == true && isset($_POST['submit_btn'])) {
    $page_vars['is_form_submitted'] = true;

    $user_id = $userSession->getSiteUser()->id;
    $fish_weight = isset($_POST['fish_weight']) ? floatval($_POST['fish_weight']) : null;
    $fish_height = isset($_POST['fish_height']) ? floatval($_POST['fish_height']) : null;
    $fisherman = isset($_POST['fisherman']) ? $_POST['fisherman'] : null;
    $fish_type = isset($_POST['fish_type']) ? $_POST['fish_type'] : null;
    $starting_price = isset($_POST['starting_price']) ? floatval($_POST['starting_price']) : null;
    $current_price = 0;
    $is_active  = isset($_POST['is_active']) ? true : false;

    $sql
        = <<<EOF
INSERT INTO listings
(
user_id,
fish_weight,
fish_height,
fisherman,
fish_type,
starting_price,
current_price,
is_active
) 
VALUES
(
:user_id,
:fish_weight,
:fish_height,
:fisherman,
:fish_type,
:starting_price,
:current_price,
:is_active
);
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'editListings';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':user_id', $user_id, $user_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $stmt->bindValue(':fish_weight', $fish_weight, $fish_weight !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':fish_height', $fish_height, $fish_height !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':fisherman', $fisherman, $fisherman !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':fish_type', $fish_type, $fish_type !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':starting_price', $starting_price, $starting_price !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':current_price', $current_price, $current_price !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
    $stmt->bindValue(':is_active', $is_active, $is_active !== null ? PDO::PARAM_BOOL : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = $db->errorCode();
        goto end_of_page;
    } else {
        $listing_id = $db->lastInsertId();

        // check if file was uploaded
        if (isset($_FILES['new_photos']) && is_array($_FILES['new_photos'])) {
            for ($i = 0; $i < count($_FILES['new_photos']['tmp_name']); $i++) {
                $file_name = $_FILES['new_photos']['name'][$i];
                $file_size = $_FILES['new_photos']['size'][$i];
                $file_tmp  = $_FILES['new_photos']['tmp_name'][$i];
                $file_type = $_FILES['new_photos']['type'][$i];
                $parts     = explode('.', $file_name);
                $file_ext  = strtolower(end($parts));

                if ( ! is_uploaded_file($file_tmp)) {
                    continue;
                }

                if ($file_size > 1048576 * 10) // 10 mb
                {
                    continue;
                }

                // create photo record - begin
                $random_name = bin2hex(random_bytes(10));
                $destination_file = UPLOAD_DIR . '/' . $random_name . '.' . $file_ext;
                $photo_url = $random_name . '.' . $file_ext;

                $sql
                    = <<<EOF
INSERT INTO listing_photos
(
listing_id, 
photo_url
) 
VALUES
(
:listing_id, 
:photo_url
);
EOF;

                $stmt = $db->prepare($sql);
                if ($stmt === false) {
                    $page_vars['form_success']  = false;
                    $page_vars['form_errors'][] = 'editListingPhoto';
                    goto end_of_page;
                }

                // Bind values
                $stmt->bindValue(':listing_id', $listing_id, $listing_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
                $stmt->bindValue(':photo_url', $photo_url, $photo_url !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

                $r = $stmt->execute();
                if ($r === false) {
                    $page_vars['form_success']  = false;
                    $page_vars['form_errors'][] = $db->errorCode();
                    goto end_of_page;
                }

                $new_image_id = $db->lastInsertId();
                // create photo record - end

                move_uploaded_file($file_tmp, $destination_file);
            }
        }

        header('Location: dashboard.php');
        exit();
    }
}

end_of_page:
