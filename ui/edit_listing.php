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
                <p><strong>Edit Listing</strong></p>

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
                                    <input class="form-control"
                                           required
                                           type="text"
                                           name="fish_type"
                                           id="fish_type"
                                           value="<?php if (isset($data['page_vars']['post_values']['fish_type'])) {
                                               echo htmlspecialchars($data['page_vars']['post_values']['fish_type']);
                                           } else {
                                               echo htmlspecialchars($data['page_vars']['listing']['fish_type']);
                                           } ?>"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fish Weight</label>
                                <div class="col-sm-6 col-md-6">
                                    <div class="input-group">
                                        <input class="form-control"
                                               required
                                               type="text"
                                               name="fish_weight"
                                               id="fish_weight"
                                               value="<?php if (isset($data['page_vars']['post_values']['fish_weight'])) {
                                                   echo htmlspecialchars($data['page_vars']['post_values']['fish_weight']);
                                               } else {
                                                   echo htmlspecialchars($data['page_vars']['listing']['fish_weight']);
                                               } ?>"
                                        />
                                        <div class="input-group-addon">KG</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fish Height</label>
                                <div class="col-sm-6 col-md-6">
                                    <div class="input-group">
                                        <input class="form-control"
                                               required
                                               type="text"
                                               name="fish_height"
                                               id="fish_height"
                                               value="<?php if (isset($data['page_vars']['post_values']['fish_height'])) {
                                                   echo htmlspecialchars($data['page_vars']['post_values']['fish_height']);
                                               } else {
                                                   echo htmlspecialchars($data['page_vars']['listing']['fish_height']);
                                               } ?>"
                                        />
                                        <div class="input-group-addon">CM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Fisherman</label>
                                <div class="col-sm-6 col-md-6">
                                    <input class="form-control"
                                           required
                                           type="text"
                                           name="fisherman"
                                           id="fisherman"
                                           value="<?php if (isset($data['page_vars']['post_values']['fisherman'])) {
                                               echo htmlspecialchars($data['page_vars']['post_values']['fisherman']);
                                           } else {
                                               echo htmlspecialchars($data['page_vars']['listing']['fisherman']);
                                           } ?>"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-sm-6 col-md-4 control-label">Starting Price</label>
                                <div class="col-sm-6 col-md-6">
                                    <div class="input-group">
                                        <input class="form-control"
                                               required
                                               type="text"
                                               name="starting_price"
                                               id="starting_price"
                                               value="<?php if (isset($data['page_vars']['post_values']['starting_price'])) {
                                                   echo htmlspecialchars($data['page_vars']['post_values']['starting_price']);
                                               } else {
                                                   echo htmlspecialchars($data['page_vars']['listing']['starting_price']);
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
                                            <input name="is_active"
                                                   type="checkbox"
                                                <?php if ($data['page_vars']['is_form_submitted'] == true
                                                    && isset($data['page_vars']['post_values']['is_active'])
                                                ) {
                                                    echo 'checked';
                                                } elseif ($data['page_vars']['is_form_submitted'] == false
                                                    && $data['page_vars']['listing']['is_active'] == true
                                                ) {
                                                    echo 'checked';
                                                } ?>
                                            />Active
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            <input name="delete_item"
                                                   type="checkbox"
                                                <?php if ($data['page_vars']['is_form_submitted'] == true
                                                    && isset($data['page_vars']['post_values']['delete_item'])
                                                ) {
                                                    echo 'checked';
                                                } elseif ($data['page_vars']['is_form_submitted'] == false
                                                    && isset($data['page_vars']['get_values']['d'])
                                                    && $data['page_vars']['get_values']['d'] == true
                                                ) {
                                                    echo 'checked';
                                                } ?>
                                            />Delete
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                    <input type="hidden" name="mode" value="update"/>
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- PHOTOS - BEGIN -->
                <div class="panel panel-default">
                    <div class="panel-heading">Photos</div>
                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal"
                              autocomplete="off">
                            <div class="image-selection">
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="new_photos[]" class="col-sm-3 col-md-2 control-label">New Photo</label>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-inline">
                                            <input class="form-control"
                                                   required
                                                   type="file"
                                                   name="new_photos[]"
                                                   id="new_photos[]"/>
                                            <button type="button" class="btn btn-primary remove-image-input"><i class="fa fa-minus"></i></button>
                                            <button type="button" class="btn btn-primary add-image-input"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                    <input type="hidden" name="mode" value="upload_photo"/>
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Upload Photo</button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <?php foreach ($data['page_vars']['listing_photos'] as $row) : ?>
                                <div class="col-sm-6 col-md-3 col-lg-2">
                                    <div class="thumbnail">
                                        <img src="<?php echo UPLOAD_URL . '/' . $row['photo_url']; ?>" />
                                        <div class="caption text-center">
                                            <form action="" method="post" enctype="multipart/form-data" role="form"
                                                  class="form-horizontal" autocomplete="off">
                                                <input type="hidden" name="mode" value="delete_photo"/>
                                                <input type="hidden" name="photo_id" value="<?php echo $row['id']; ?>"/>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="delete_item"
                                                               type="checkbox"
                                                               required
                                                            <?php if ($data['page_vars']['is_form_submitted'] == true
                                                                && isset($data['page_vars']['post_values']['delete_item'])
                                                            ) {
                                                                echo 'checked';
                                                            } ?>
                                                        />Delete
                                                    </label>
                                                </div>
                                                <p class="margin-top-10">
                                                    <button type="submit" name="submit_btn" class="btn btn-primary">
                                                        Delete Photo
                                                    </button>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- PHOTOS - END -->

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

<?php if ($data['result_array']['page_success'] == true) : ?>
    <script>
        $(document).ready(function () {
            $('.add-image-input').click(function () {
                el_parent = $(this).parents('.image-selection').first();
                el_parent.clone(true).insertAfter(el_parent);
            });
            $('.remove-image-input').click(function () {
                if ($('.image-selection').length > 1) {
                    el_parent = $(this).parents('.image-selection').first();
                    el_parent.remove();
                }
            });
        });
    </script>
<?php endif; ?>

</body>
</html>