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
$page_vars['listing_bids']       = array();

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

// listing bids - begin
$listing_bids = array();

if (count($listing) > 0) {
    $sql
        = <<<EOF
SELECT
t1.id,
t1.bidder,
t1.bid_amount
FROM listing_bids t1
WHERE
t1.listing_id = :listing_id
AND t1.is_deleted = 0
ORDER BY t1.id ASC;
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        $result_array['page_success']  = false;
        $result_array['page_errors'][] = 'fetchListingBids';
        goto end_of_page;
    }

    // Bind values
    $stmt->bindValue(':listing_id', $listing['id'], PDO::PARAM_INT);

    $r = $stmt->execute();
    if ($r === false) {
        $result_array['page_success']  = false;
        $result_array['page_errors'][] = 'fetchListingBids';
        goto end_of_page;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $listing_bids[] = $row;
    }
    $stmt->closeCursor();
}
$page_vars['listing_bids'] = $listing_bids;
// listing bids - end

end_of_page:
