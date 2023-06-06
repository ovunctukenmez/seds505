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
$page_vars['listings']             = array();

// db connection
try {
    $db = new PDO(PDO_dsn, PDO_username, PDO_password);
} catch (PDOException $exception) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = $exception->getCode() . ' - ' . $exception->getMessage();
    goto end_of_page;
}

// listing photos - begin
$listing_photos = array();

$sql
    = <<<EOF
SELECT
t1.id,
t1.listing_id,
t1.photo_url
FROM listing_photos t1
WHERE
t1.is_deleted = 0
ORDER BY t1.id ASC;
EOF;

$stmt = $db->prepare($sql);
if ($stmt === false) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'fetchListingPhotos';
    goto end_of_page;
}

$r = $stmt->execute();
if ($r === false) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'fetchListingPhotos';
    goto end_of_page;
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($listing_photos[$row['listing_id']])) {
        $listing_photos[$row['listing_id']] = [];
    }
    $listing_photos[$row['listing_id']][] = $row;
}
$stmt->closeCursor();
// listing photos - end

// listings - begin
$per_page = isset($_GET['per_page']) ? abs(intval($_GET['per_page'])) : 20;

$listings                 = array();
$listings['rows']         = array();
$listings['total']        = 0;
$listings['per_page']     = $per_page;
$listings['page_count']   = 1;
$listings['current_page'] = (isset($_GET['p']) ? abs(intval($_GET['p'])) : 1);
$limit_start               = ($listings['current_page'] - 1) * $listings['per_page'];

$sql
    = <<<EOF
SELECT
SQL_CALC_FOUND_ROWS
t1.id,
t1.fish_weight,
t1.fish_height,
t1.fisherman,
t1.fish_type,
t1.starting_price,
t1.current_price,
(SELECT COUNT(1) FROM listing_bids WHERE listing_id = t1.id) AS bid_count
FROM listings t1
WHERE
t1.is_active = 1
AND t1.is_deleted = 0
ORDER BY t1.id DESC
LIMIT :limit_start,:per_page;

SELECT FOUND_ROWS();
EOF;

$stmt = $db->prepare($sql);
if ($stmt === false) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'fetchListings';
    goto end_of_page;
}

// Bind values
$stmt->bindValue(':limit_start', $limit_start, $limit_start !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
$stmt->bindValue(':per_page', $per_page, $per_page !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

$r = $stmt->execute();
if ($r === false) {
    $result_array['page_success']  = false;
    $result_array['page_errors'][] = 'fetchListings';
    goto end_of_page;
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $photos = isset($listing_photos[$row['id']]) ? $listing_photos[$row['id']] : [];
    $row['photos'] = $photos;
    $listings['rows'][] = $row;
}

$stmt->nextRowset();
$listings['total']      = $stmt->fetchColumn();
$listings['page_count'] = max(1, ceil($listings['total'] / $listings['per_page']));
$stmt->closeCursor();

$page_vars['listings'] = $listings;
// listings - end

end_of_page:
