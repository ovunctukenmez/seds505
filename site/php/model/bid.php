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

if ($result_array['page_success'] == true && isset($_POST['submit_btn']) && isset($_POST['bid'])
) {
    $page_vars['is_form_submitted'] = true;

    // create new listing bid - begin
    $bidder = isset($_POST['bidder']) ? $_POST['bidder'] : null;
    $bid_amount = isset($_POST['bid_amount']) ? floatval($_POST['bid_amount']) : null;

    $sql
        = <<<EOF
INSERT INTO listing_bids
(
listing_id, 
bidder,
bid_amount
) 
VALUES
(
:listing_id, 
:bidder,
:bid_amount
);
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = 'bid';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':listing_id', $listing['id'], $listing['id'] !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $stmt->bindValue(':bidder', $bidder, PDO::PARAM_STR);
    $stmt->bindValue(':bid_amount', $bid_amount, PDO::PARAM_STR);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = $db->errorCode();
        goto end_of_page;
    }
    // create new listing bid - end

    // update current price - begin
    $sql
        = <<<EOF
UPDATE listings
SET
current_price = :current_price
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
    $stmt->bindValue(':current_price', $bid_amount, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, $id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        $page_vars['form_success']  = false;
        $page_vars['form_errors'][] = $db->errorCode();
        goto end_of_page;
    }

    header('Location: dashboard.php');
}

end_of_page:
