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
                <p><strong>Şifre Değişikliği</strong></p>

	            <?php if ($data['page_vars']['is_form_submitted'] == true && $data['page_vars']['form_success'] == false) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
	            <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal" autocomplete="off">

                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label">Kullanıcı Adı</label>
                        <div class="col-sm-9 col-md-3">
                            <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['provider_user']['username']); ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="current_password" class="col-sm-3 col-md-2 control-label">Mevcut Şifre</label>
                        <div class="col-sm-6 col-md-3">
                            <input class="form-control"
                                   type="password"
                                   name="current_password"
                                   id="current_password"
                                   value="<?php if (isset($data['page_vars']['post_values']['current_password'])) {
                                       echo htmlspecialchars($data['page_vars']['post_values']['current_password']);
                                   } ?>"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="col-sm-3 col-md-2 control-label">Yeni Şifre</label>
                        <div class="col-sm-6 col-md-3">
                            <input class="form-control"
                                   type="password"
                                   name="new_password"
                                   id="new_password"
                                   value="<?php if (isset($data['page_vars']['post_values']['new_password'])) {
                                       echo htmlspecialchars($data['page_vars']['post_values']['new_password']);
                                   } ?>"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="re_password" class="col-sm-3 col-md-2 control-label">Yeni Şifre (Tekrar)</label>
                        <div class="col-sm-6 col-md-3">
                            <input class="form-control"
                                   type="password"
                                   name="re_password"
                                   id="re_password"
                                   value="<?php if (isset($data['page_vars']['post_values']['re_password'])) {
                                       echo htmlspecialchars($data['page_vars']['post_values']['re_password']);
                                   } ?>"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                            <button type="submit" name="submit_btn" class="btn btn-primary">Şifreyi Değiştir</button>
                        </div>
                    </div>
                </form>

                <?php if ($data['page_vars']['is_form_submitted'] == true && $data['page_vars']['form_success'] == false) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
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