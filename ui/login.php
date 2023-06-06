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

<div class="container info-page">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php if ($data['result_array']['page_success'] == false) : ?>
                <div class="alert alert-danger"
                     role="alert"><?php echo $data['result_array']['page_errors'][0]; ?></div>
            <?php else: ?>

                <div class="text-center">
                    <img alt="seds505project" src="<?php echo FILES_ADDRESS . '/ui/images/logo.png'; ?>" class="margin-bottom-30 margin-top-40" />
                </div>

	            <?php if ($data['page_vars']['is_form_submitted'] == true && $data['page_vars']['form_success'] == false) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
	            <?php endif; ?>

                <div class="well login">
                    <!--LOGIN FORM - BEGIN -->
                    <form class="form-horizontal" name="" action="" method="post" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-8">
                                <input class="form-control"
                                       type="text"
                                       name="username"
                                       id="username"
                                       placeholder="Username"
                                       autocomplete="off"
                                       value="<?php if (isset($data['page_vars']['post_values']['username'])) {
                                           echo htmlspecialchars($data['page_vars']['post_values']['username']);
                                       } else { echo 'admin'; } ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_password" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input class="form-control"
                                       type="password"
                                       name="user_password"
                                       id="user_password"
                                       placeholder="Password"
                                       autocomplete="off"
                                       value="<?php if (isset($data['page_vars']['post_values']['user_password'])) {
                                           echo htmlspecialchars($data['page_vars']['post_values']['user_password']);
                                       } else { echo 'password'; } ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button class="btn btn-success" name="submit_btn" id="btn_submit" type="submit">Login</button>
                            </div>
                        </div>

                    </form>
                    <!--LOGIN FORM - END -->

                    <p><a href="#"><i class="fa fa-user"></i> Register</a> (TODO)</p>
                    <p><a href="#"><i class="fa fa-key"></i> Reset Password</a> (TODO)</p>

                </div>

                <?php if ($data['page_vars']['is_form_submitted'] == true && $data['page_vars']['form_success'] == false) : ?>
                    <div class="alert alert-danger" role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
                <?php endif; ?>

            <?php endif; ?>
        <?php include 'login_page_footer.php'; ?>
        </div>

    </div>
</div>

<?php
include 'footer.php';
include 'includes/footer.php';
?>

</body>
</html>