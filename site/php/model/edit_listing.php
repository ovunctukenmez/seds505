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
$page_vars['listing']              = array();
$page_vars['listing_photos']       = array();

// db connection
try {
    $db = new PDO(PDO_dsn, PDO_username, PDO_password);
} catch (PDOException $exception) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = $exception->getCode() . ' - ' . $exception->getMessage();
    goto end_of_page;
}

// listing - begin
$listing = array();

$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : 0;

$sql
    = <<<EOF
SELECT
t1.id,
t1.user_id,
t1.fish_type,
t1.fish_weight,
t1.fish_height,
t1.fisherman,
t1.starting_price,
t1.current_price,
t1.is_active,
t1.is_sold,
t1.is_deleted
FROM listings t1
WHERE
t1.id = :id;
EOF;

$stmt = $db->prepare($sql);
if ($stmt === false) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'ListingDetails';
    goto end_of_page;
}

// Bind values
$stmt->bindValue(':id', $id, $id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

$r = $stmt->execute();
if ($r === false) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'ListingDetails';
    goto end_of_page;
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['is_deleted'] == true) {
        continue;
    }
    $listing = $row;
}
$stmt->closeCursor();

if (count($listing) == 0) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'not_found';
    goto end_of_page;
}

$page_vars['listing'] = $listing;
// listing - end

// listing photos - begin
$listing_photos = array();

if (count($listing) > 0) {
    $sql
        = <<<EOF
SELECT
t1.id,
t1.listing_id,
t1.photo_url
FROM listing_photos t1
WHERE
t1.listing_id = :listing_id
AND t1.is_deleted = 0
ORDER BY t1.id ASC;
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $result_array['page_success']  = false;
        $result_array['page_errors'][] = 'fetchListingPhotos';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':listing_id', $listing['id'], PDO::PARAM_INT);

    $r = $stmt->execute();
    if ($r === false) {
        $result_array['page_success']  = false;
        $result_array['page_errors'][] = 'fetchListingPhotos';
        goto end_of_page;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $listing_photos[] = $row;
    }
    $stmt->closeCursor();
}
$page_vars['listing_photos'] = $listing_photos;
// listing photos - end

if ($result_array['page_success'] == true && isset($_POST['submit_btn']) && isset($_POST['mode'])
    && $_POST['mode'] == 'update'
) {
    $page_vars['is_form_submitted'] = true;

    if (isset($_POST['delete_item'])) {
        // delete
        $sql
            = <<<EOF
UPDATE listings
SET
is_deleted = 1
WHERE
id = :id;
EOF;

        $stmt = $db->prepare($sql);
        if ($stmt === false) {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = 'editListing';
            goto end_of_page;
        }

        // Bind values
        $stmt->bindValue(':id', $id, $id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

        $r = $stmt->execute();
        if ($r === false) {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = $db->errorCode();
            goto end_of_page;
        } else {
            header('Location: dashboard.php');
            exit();
        }
    } else {
        // update
        $fish_weight = isset($_POST['fish_weight']) ? floatval($_POST['fish_weight']) : null;
        $fish_height = isset($_POST['fish_height']) ? floatval($_POST['fish_height']) : null;
        $fisherman = isset($_POST['fisherman']) ? $_POST['fisherman'] : null;
        $fish_type = isset($_POST['fish_type']) ? $_POST['fish_type'] : null;
        $starting_price = isset($_POST['starting_price']) ? floatval($_POST['starting_price']) : null;
        $is_active  = isset($_POST['is_active']) ? true : false;

        $sql
            = <<<EOF
UPDATE listings
SET
fish_weight = :fish_weight,
fish_height = :fish_height,
fisherman = :fisherman,
fish_type = :fish_type,
starting_price = :starting_price,
is_active = :is_active
WHERE
id = :id;
EOF;

        $stmt = $db->prepare($sql);
        if ($stmt === false) {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = 'editCarTrims';
            goto end_of_page;
        }

        // Bind values
        $stmt->bindValue(':fish_weight', $fish_weight, $fish_weight !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':fish_height', $fish_height, $fish_height !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':fisherman', $fisherman, $fisherman !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':fish_type', $fish_type, $fish_type !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':starting_price', $starting_price, $starting_price !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':is_active', $is_active, $is_active !== null ? PDO::PARAM_BOOL : PDO::PARAM_NULL);
        $stmt->bindValue(':id', $id, $id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

        $r = $stmt->execute();
        if ($r === false) {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = $db->errorCode();
            goto end_of_page;
        } else {
            header('Location: dashboard.php');
            exit();
        }
    }
} elseif ($result_array['page_success'] == true && isset($_POST['submit_btn']) && isset($_POST['mode'])
    && $_POST['mode'] == 'upload_photo'
) {
    $page_vars['is_form_submitted'] = true;

    // check if file was uploaded
    if ( ! isset($_FILES['new_photos'])) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'select_file';
        goto end_of_page;
    } elseif ( ! is_array($_FILES['new_photos'])) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'invalid_request';
        goto end_of_page;
    }

    for ($i = 0; $i < count($_FILES['new_photos']['tmp_name']); $i++) {
        $file_name = $_FILES['new_photos']['name'][$i];
        $file_size = $_FILES['new_photos']['size'][$i];
        $file_tmp  = $_FILES['new_photos']['tmp_name'][$i];
        $file_type = $_FILES['new_photos']['type'][$i];
        $parts     = explode('.', $file_name);
        $file_ext  = strtolower(end($parts));

        if ( ! is_uploaded_file($file_tmp)) {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = 'invalid_request';
            goto end_of_page;
        }

        if ($file_size > 1048576 * 10) // 10 mb
        {
            $page_vars['form_success']  = false;
            $page_vars['form_errors'][] = 'invalid_file_size';
            goto end_of_page;
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
        $stmt->bindValue(':listing_id', $listing['id'], $listing['id'] !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
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

    header('Location: edit_listing.php?id=' . $listing['id']);
    exit();
} elseif ($result_array['page_success'] == true && isset($_POST['submit_btn']) && isset($_POST['mode'])
    && $_POST['mode'] == 'delete_photo'
) {
    $page_vars['is_form_submitted'] = true;
    $photo_id                       = isset($_POST['photo_id']) ? abs(intval($_POST['photo_id'])) : null;

    if ( ! isset($_POST['delete_item'])) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'confirm_action';
        goto end_of_page;
    } elseif ($photo_id === null) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'invalid_request';
        goto end_of_page;
    }

    // photo details - begin
    $row_photo = array();

    $sql
        = <<<EOF
SELECT
t1.id,
t1.photo_url
FROM listing_photos t1
WHERE
t1.id = :id
AND is_deleted = 0
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'fetchListingPhoto';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':id', $photo_id, $photo_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'ListingPhotoDetails';
        goto end_of_page;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['is_deleted'] == true) {
            continue;
        }
        $row_photo = $row;
    }
    $stmt->closeCursor();

    if (count($row_photo) == 0) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'not_found';
        goto end_of_page;
    }
    // photo details - end

    // delete photo
    unlink(UPLOAD_DIR . '/' . $row_photo['photo_url']);

    $sql
        = <<<EOF
UPDATE listing_photos
SET
is_deleted = 1
WHERE
id = :id
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'editListingPhoto';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':id', $row_photo['id'], $row_photo['id'] !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = $db->errorCode();
        goto end_of_page;
    } else {
        header('Location: edit_listing.php?id=' . $listing['id']);
        exit();
    }
}

end_of_page:
