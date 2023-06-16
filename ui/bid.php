<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $data['site_info']['title']; ?></title>
    <meta name="description" content="<?php echo $data['site_info']['description']; ?>"/>
    <meta name="keywords" content="<?php echo $data['site_info']['keywords']; ?>"/>

    <?php include 'includes/head.php'; ?>
</head>

<body>
<?php include 'includes/body.php'; ?>

<?php include 'navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4 col-md-3 col-lg-2 admin-sidebar">
            <?php include 'admin_sidebar.php'; ?>
        </div>

        <div class="col-sm-8 col-sm-offset-4 col-md-9 col-md-offset-3 col-lg-10 col-lg-offset-2 admin-contents">
            <?php if ($data['result_array']['page_success'] == false) : ?>
                <div class="alert alert-danger"
                     role="alert"><?php echo $data['result_array']['page_errors'][0]; ?></div>
            <?php else: ?>
                <p><strong>Bid</strong></p>

                <?php if ($data['page_vars']['is_form_submitted'] == true
                    && $data['page_vars']['form_success'] == false
                ) : ?>
                    <div class="alert alert-danger"
                         role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal" autocomplete="off">

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fish Type</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['listing']['fish_type']); ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fish Weight</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['listing']['fish_weight']); ?> KG</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fish Height</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['listing']['fish_height']); ?> CM</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fisherman</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['listing']['fisherman']); ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Starting Price</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['listing']['starting_price']); ?> TL</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Current Price</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['listing']['current_price']); ?> TL</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bidder" class="col-sm-6 col-md-4 control-label">Bidder</label>
                                <div class="col-sm-6 col-md-6">
                                    <input class="form-control"
                                           required
                                           type="text"
                                           name="bidder"
                                           id="bidder"
                                           value="<?php if (isset($data['page_vars']['post_values']['bidder'])) {
                                               echo htmlspecialchars($data['page_vars']['post_values']['bidder']);
                                           } ?>"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bid_amount" class="col-sm-6 col-md-4 control-label">Bid Amount</label>
                                <div class="col-sm-6 col-md-6">
                                    <div class="input-group">
                                        <input class="form-control"
                                               required
                                               type="text"
                                               name="bid_amount"
                                               id="bid_amount"
                                               value="<?php if (isset($data['page_vars']['post_values']['bid_amount'])) {
                                                   echo htmlspecialchars($data['page_vars']['post_values']['bid_amount']);
                                               } ?>"
                                        />
                                        <div class="input-group-addon">TL</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            <input name="bid"
                                                   required
                                                   type="checkbox"
                                                <?php if ($data['page_vars']['is_form_submitted'] == true
                                                    && isset($data['page_vars']['post_values']['bid'])
                                                ) {
                                                    echo 'checked';
                                                } ?>
                                            />Confirm Bid
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php if ($data['page_vars']['is_form_submitted'] == true && $data['page_vars']['form_success'] == true) : ?>
                                <div class="alert alert-success" role="alert"><?php echo $data['page_vars']['form_messages'][0]; ?></div>
                                <p><a href="dashboard.php">Dashboard</a></p>
                            <?php else: ?>
                                <div class="form-group">
                                    <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                        <button type="submit" name="submit_btn" class="btn btn-primary">Bid</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <?php if ($data['page_vars']['is_form_submitted'] == true
                    && $data['page_vars']['form_success'] == false
                ) : ?>
                    <div class="alert alert-danger"
                         role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
                <?php endif; ?>

            <?php endif; ?>
            <?php include 'page_footer.php'; ?>
        </div>

    </div>
</div>

<?php
include 'footer.php';
include 'includes/footer.php';
?>

</body>
</html>