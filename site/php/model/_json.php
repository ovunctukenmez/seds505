<?php
if ( ! defined('SITE_ADDRESS')) {
    exit("invalid request");
}

array_walk($_POST, 'Functions::callback_array_walk_trim');
array_walk($_GET, 'Functions::callback_array_walk_trim');

$method_to_call = '';
// methods - begin
if (isset($_GET['action'])) {
    if ( ! in_array($_GET['action'], array('car_models', 'car_trims', 'car_model_generations', 'car_model_years', 'specs'))) {
        $has_error         = true;
        $response['error'] = 'invalid_action';
        goto page_end;
    }
} else {
    $has_error         = true;
    $response['error'] = 'required_action';
    goto page_end;
}
// methods - end

// db connection
try {
    $db = new PDO(PDO_dsn, PDO_username, PDO_password);
} catch (PDOException $exception) {
    $has_error         = true;
    $response['error'] = $exception->getCode() . ' - ' . $exception->getMessage();
    goto page_end;
}

if ($_GET['action'] == 'car_models') { // car models - begin
    $car_models = array();

    $car_make_id = isset($_POST['car_make_id']) ? abs(intval($_POST['car_make_id'])) : null;
    $is_current  = isset($_POST['is_current']) && trim($_POST['is_current']) != "" ? boolval($_POST['is_current']) : null;

    $sql
        = <<<EOF
SELECT
t1.id,
t1.title,
t1.is_current
FROM car_models t1
WHERE
t1.is_deleted = 0
AND (:is_current IS NULL OR t1.is_current = :is_current)
AND (:car_make_id IS NULL OR t1.car_make_id = :car_make_id)
ORDER BY t1.is_current DESC, t1.title ASC;
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $db->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listCarModels';
        goto page_end;
    }

    // Bind values
    $stmt->bindValue(':is_current', $is_current, $is_current !== null ? PDO::PARAM_BOOL : PDO::PARAM_NULL);
    $stmt->bindValue(':car_make_id', $car_make_id, $car_make_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $stmt->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listCarModels';
        goto page_end;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $car_models[] = $row;
    }
    $stmt->closeCursor();

    $response['values']['rows'] = $car_models;
} // car models - end
elseif ($_GET['action'] == 'car_trims') { // car trims - begin
    $car_trims = array();

    $car_model_id = isset($_POST['car_model_id']) ? abs(intval($_POST['car_model_id'])) : null;
    $is_current  = isset($_POST['is_current']) && trim($_POST['is_current']) != "" ? boolval($_POST['is_current']) : null;

    $sql
        = <<<EOF
SELECT
t1.id,
t1.title,
t1.is_current
FROM car_trims t1
WHERE
t1.is_deleted = 0
AND (:is_current IS NULL OR t1.is_current = :is_current)
AND (:car_model_id IS NULL OR t1.car_model_id = :car_model_id)
ORDER BY t1.is_current DESC, t1.title ASC;
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $db->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listCarTrims';
        goto page_end;
    }

    // Bind values
    $stmt->bindValue(':is_current', $is_current, $is_current !== null ? PDO::PARAM_BOOL : PDO::PARAM_NULL);
    $stmt->bindValue(':car_model_id', $car_model_id, $car_model_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $stmt->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listCarTrims';
        goto page_end;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $car_trims[] = $row;
    }
    $stmt->closeCursor();

    $response['values']['rows'] = $car_trims;
} // car trims - end
elseif ($_GET['action'] == 'car_model_generations') { // car model generations - begin
    $car_model_generations = array();

    $car_model_id = isset($_POST['car_model_id']) ? abs(intval($_POST['car_model_id'])) : null;
    $is_current   = isset($_POST['is_current']) && trim($_POST['is_current']) != "" ? boolval($_POST['is_current']) : null;

    $sql
        = <<<EOF
SELECT
t1.id,
t1.title,
t1.year_begin,
t1.year_end,
t1.is_current
FROM car_model_generations t1
WHERE
t1.is_deleted = 0
AND (:is_current IS NULL OR t1.is_current = :is_current)
AND (:car_model_id IS NULL OR t1.car_model_id = :car_model_id)
ORDER BY t1.is_current DESC, t1.title ASC;
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $db->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listCarModelGenerations';
        goto page_end;
    }

    // Bind values
    $stmt->bindValue(':is_current', $is_current, $is_current !== null ? PDO::PARAM_BOOL : PDO::PARAM_NULL);
    $stmt->bindValue(':car_model_id', $car_model_id, $car_model_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $stmt->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listCarModelGenerations';
        goto page_end;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['compound_title'] = trim('(' . $row['year_begin'] . '-' . $row['year_end'] . ') ' . $row['title']);
        $car_model_generations[] = $row;
    }
    $stmt->closeCursor();

    $response['values']['rows'] = $car_model_generations;
} // car model generations - end
elseif ($_GET['action'] == 'specs') { // specs - begin
    $specs = array();

    $parent_id   = isset($_POST['parent_id']) ? abs(intval($_POST['parent_id'])) : null;
    $car_trim_id = isset($_POST['car_trim_id']) ? abs(intval($_POST['car_trim_id'])) : null;

    $sql
        = <<<EOF
SELECT
t1.id,
t1.parent_id,
t1.title
FROM specs t1
WHERE
t1.parent_id = :parent_id
AND (:car_trim_id IS NULL OR NOT t1.id IN (SELECT spec_id FROM car_trim_specs WHERE car_trim_id = :car_trim_id AND t1.is_deleted = 0))
AND t1.is_deleted = 0
ORDER BY t1.order_nr ASC, t1.title ASC
EOF;

    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $db->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listSpecs';
        goto page_end;
    }

    // Bind values
    $stmt->bindValue(':parent_id', $parent_id, $parent_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $stmt->bindValue('car_trim_id', $car_trim_id, $car_trim_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

    $r = $stmt->execute();
    if ($r === false) {
        Functions::error_log($sql . " " . base64_encode(implode(',', $stmt->errorInfo())));
        $has_error         = true;
        $response['error'] = 'listSpecs';
        goto page_end;
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $specs[] = $row;
    }
    $stmt->closeCursor();

    $response['values']['rows'] = $specs;
} // specs - end

/*
// request - begin
$get_vars = array();
$get_vars = $_GET;
$get_vars['action'] = $method_to_call;

$post_vars = array();
$post_vars = $_POST;

$_response = ApiClient::makePostRequest($get_vars, $post_vars);
if ($_response === null) {
    $has_error = true;
    $response['error'] = 'api_call_error';
    goto page_end;
} else {
    $has_error = ($_response['result'] == 'error');
    $response = $_response;
}
// request - end
*/

page_end:
