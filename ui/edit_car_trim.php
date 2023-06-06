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
                <p><strong>Versiyon Tanımlama</strong></p>

                <?php if ($data['page_vars']['is_form_submitted'] == true
                    && $data['page_vars']['form_success'] == false
                ) : ?>
                    <div class="alert alert-danger"
                         role="alert"><?php echo $data['page_vars']['form_errors'][0]; ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal"
                              autocomplete="off">
                            <div class="form-group">
                                <label for="car_make_id" class="col-sm-6 col-md-4 control-label">Marka</label>
                                <div class="col-sm-6 col-md-6">
                                    <select name="car_make_id" id="car_make_id" class="form-control" required>
                                        <option value="">Seçiniz</option>
                                        <?php foreach ($data['page_vars']['car_makes'] as $row) : ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ((isset($data['page_vars']['post_values']['car_make_id'])
                                                    && $data['page_vars']['post_values']['car_make_id'] == $row['id'])
                                                || ($data['page_vars']['is_form_submitted'] == false
                                                    && $data['page_vars']['car_trim']['car_make_id'] == $row['id'])
                                            ) {
                                                echo 'selected';
                                            } ?>><?php echo $row['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="car_model_id" class="col-sm-6 col-md-4 control-label">Model</label>
                                <div class="col-sm-6 col-md-6">
                                    <select name="car_model_id" id="car_model_id" class="form-control" required>
                                        <option value="">Seçiniz</option>
                                        <?php foreach ($data['page_vars']['car_models'] as $row) : ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ((isset($data['page_vars']['post_values']['car_model_id'])
                                                    && $data['page_vars']['post_values']['car_model_id'] == $row['id'])
                                                || ($data['page_vars']['is_form_submitted'] == false
                                                    && $data['page_vars']['car_trim']['car_model_id'] == $row['id'])
                                            ) {
                                                echo 'selected';
                                            } ?>><?php echo $row['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="car_model_generation_id"
                                       class="col-sm-6 col-md-4 control-label">Nesil</label>
                                <div class="col-sm-6 col-md-6">
                                    <select name="car_model_generation_id" id="car_model_generation_id"
                                            class="form-control">
                                        <option value="">Seçiniz</option>
                                        <?php foreach ($data['page_vars']['car_model_generations'] as $row) : ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ((isset($data['page_vars']['post_values']['car_model_generation_id']) && $data['page_vars']['post_values']['car_model_generation_id'] == $row['id'])
                                                || ($data['page_vars']['is_form_submitted'] == false && $data['page_vars']['car_trim']['car_model_generation_id'] == $row['id'])
                                            ) {
                                                echo 'selected';
                                            } ?>><?php echo $row['compound_title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-6 col-md-4 control-label">Versiyon</label>
                                <div class="col-sm-6 col-md-6">
                                    <input class="form-control"
                                           type="text"
                                           name="title"
                                           id="title"
                                           value="<?php if (isset($data['page_vars']['post_values']['title'])) {
                                               echo htmlspecialchars($data['page_vars']['post_values']['title']);
                                           } else {
                                               echo htmlspecialchars($data['page_vars']['car_trim']['title']);
                                           } ?>"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="revision" class="col-sm-6 col-md-4 control-label">Revizyon</label>
                                <div class="col-sm-6 col-md-6">
                                    <input class="form-control"
                                           type="text"
                                           name="revision"
                                           id="revision"
                                           value="<?php if (isset($data['page_vars']['post_values']['revision'])) {
                                               echo htmlspecialchars($data['page_vars']['post_values']['revision']);
                                           } else {
                                               echo htmlspecialchars($data['page_vars']['car_trim']['revision']);
                                           } ?>"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-sm-6 col-md-4 control-label">Fiyat</label>
                                <div class="col-sm-6 col-md-6">
                                    <div class="input-group">
                                        <input class="form-control"
                                               type="text"
                                               name="price"
                                               id="price"
                                               value="<?php if (isset($data['page_vars']['post_values']['price_100'])) {
                                                   echo htmlspecialchars($data['page_vars']['post_values']['price_100'] / 100);
                                               } else {
                                                   echo htmlspecialchars($data['page_vars']['car_trim']['price_100'] / 100);
                                               } ?>"
                                        />
                                        <div class="input-group-addon">TL</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6 col-md-4 control-label">Slug</label>
                                <div class="col-sm-6 col-md-6">
                                    <p class="form-control-static"><?php echo htmlspecialchars($data['page_vars']['car_trim']['slug']); ?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            <input name="is_on_sale"
                                                   type="checkbox"
                                                <?php if ($data['page_vars']['is_form_submitted'] == true
                                                    && isset($data['page_vars']['post_values']['is_on_sale'])
                                                ) {
                                                    echo 'checked';
                                                } elseif ($data['page_vars']['is_form_submitted'] == false
                                                    && $data['page_vars']['car_trim']['is_on_sale'] == true
                                                ) {
                                                    echo 'checked';
                                                } ?>
                                            />Satışta
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
                                            />Sil
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                    <input type="hidden" name="mode" value="update"/>
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item"><a target="_blank"
                                                           href="car_models.php?car_make_id=<?php echo $data['page_vars']['car_trim']['car_make_id']; ?>"><i
                                            class="fa fa-external-link"></i> Modeller</a></li>
                            <li class="list-group-item"><a target="_blank"
                                                           href="car_model_generations.php?car_make_id=<?php echo $data['page_vars']['car_trim']['car_make_id']; ?>&car_model_id=<?php echo $data['page_vars']['car_trim']['car_model_id']; ?>"><i
                                            class="fa fa-external-link"></i> Nesiller</a></li>
                            <li class="list-group-item"><a target="_blank"
                                                           href="car_trims.php?car_make_id=<?php echo $data['page_vars']['car_trim']['car_make_id']; ?>&car_model_id=<?php echo $data['page_vars']['car_trim']['car_model_id']; ?>&car_model_generation_id=<?php echo $data['page_vars']['car_trim']['car_model_generation_id']; ?>"><i
                                            class="fa fa-external-link"></i> Versiyonlar</a></li>
                            <li class="list-group-item"><a href="<?php echo Functions::getUrl(array('slug' => $data['page_vars']['car_trim']['slug'], 'car_model_slug' => $data['page_vars']['car_trim']['car_model_slug'], 'car_make_slug' => $data['page_vars']['car_trim']['car_make_slug']),'car_trim'); ?>" target="_blank"><i
                                            class="fa fa-external-link"></i> Sitede Gör</a></li>
                        </ul>
                    </div>
                </div>

                <?php if ( ! empty($car_trim['cdn_thumbnail_path'])): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="" method="post" enctype="multipart/form-data" role="form"
                                  class="form-horizontal" autocomplete="off">
                                <div class="form-group">
                                    <label for="current_image" class="col-sm-3 col-md-2 control-label">Resim</label>
                                    <div class="col-sm-6 col-md-3">
                                        <img class="img-thumbnail" id="current_image"
                                             src="<?php echo AZURE_STORAGE_ADDRESS
                                                 . $car_trim['cdn_thumbnail_path']; ?>"
                                             alt="<?php echo htmlspecialchars($car_trim['car_make_title'] . ' '
                                                 . $car_trim['car_model_generation_title'] . ' '
                                                 . $car_trim['title']); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
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
                                                />Sil
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-md-offset-2 col-sm-9 col-md-10">
                                        <input type="hidden" name="mode" value="delete_image"/>
                                        <button type="submit" name="submit_btn" class="btn btn-primary">Resmi Sil
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal"
                              autocomplete="off">
                            <div class="form-group">
                                <label for="new_image" class="col-sm-3 col-md-2 control-label">Yeni Resim</label>
                                <div class="col-sm-6 col-md-3">
                                    <input class="form-control"
                                           required
                                           type="file"
                                           name="new_image"
                                           id="new_image"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                    <input type="hidden" name="mode" value="upload_image"/>
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Resim Yükle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <!--
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="" method="post" enctype="multipart/form-data" role="form"
                                      class="form-horizontal" autocomplete="off">
                                    <div class="form-group">
                                        <label for="new_spec_parent_id"
                                               class="col-sm-6 col-md-4 control-label">Kategori</label>
                                        <div class="col-sm-6 col-md-6">
                                            <select name="new_spec_parent_id" id="new_spec_parent_id"
                                                    class="form-control" required>
                                                <option value="">Seçiniz</option>
                                                <?php foreach ($data['page_vars']['spec_parents'] as $spec_parent): ?>
                                                    <option value="<?php echo $spec_parent['id']; ?>"><?php echo htmlspecialchars($spec_parent['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_spec_id" class="col-sm-6 col-md-4 control-label">Donanım</label>
                                        <div class="col-sm-6 col-md-6">
                                            <select name="new_spec_id" id="new_spec_id" class="form-control" required>
                                                <option value="">Seçiniz</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_spec_value"
                                               class="col-sm-6 col-md-4 control-label">Değer</label>
                                        <div class="col-sm-6 col-md-6">
                                            <select name="new_spec_value" id="new_spec_value" class="form-control"
                                                    required>
                                                <option value="">Seçiniz</option>
                                                <option value="standard" <?php if ((isset($data['page_vars']['post_values']['new_spec_value'])
                                                    && $data['page_vars']['post_values']['new_spec_value']
                                                    == 'standard')
                                                ) {
                                                    echo 'selected';
                                                } ?>>Standart
                                                </option>
                                                <option value="optional" <?php if ((isset($data['page_vars']['post_values']['new_spec_value'])
                                                    && $data['page_vars']['post_values']['new_spec_value']
                                                    == 'optional')
                                                ) {
                                                    echo 'selected';
                                                } ?>>Opsiyonel
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                            <input type="hidden" name="mode" value="add_spec"/>
                                            <button type="submit" name="submit_btn" class="btn btn-primary">Donanım
                                                Ekle
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    -->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="" method="post" enctype="multipart/form-data" role="form"
                                      class="form-horizontal" autocomplete="off">
                                    <div class="form-group">
                                        <label for="source_car_trim_id"
                                               class="col-sm-6 col-md-4 control-label">Versiyon</label>
                                        <div class="col-sm-6 col-md-6">
                                            <select name="source_car_trim_id" id="source_car_trim_id"
                                                    class="form-control">
                                                <option value="">Seçiniz</option>
                                                <?php foreach ($data['page_vars']['car_trim_model_trims'] as $row) : ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php if (isset($data['page_vars']['post_values']['source_car_trim_id']) && $data['page_vars']['post_values']['source_car_trim_id'] == $row['id']) {
                                                        echo 'selected';
                                                    } ?>><?php echo $row['car_make_title'] . ' ' . $row['car_model_title'] . ' ' . $row['title']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!--
                                    <div class="form-group">
                                        <label for="source_car_trim_spec_parent"
                                               class="col-sm-6 col-md-4 control-label">Kategori</label>
                                        <div class="col-sm-6 col-md-6">
                                            <select name="source_car_trim_spec_parent" id="source_car_trim_spec_parent"
                                                    class="form-control" required>
                                                <option value="">Seçiniz</option>
                                                <option value="all">Tümü</option>
                                                <?php foreach ($data['page_vars']['spec_parents'] as $spec_parent): ?>
                                                    <option value="<?php echo $spec_parent['id']; ?>"><?php echo htmlspecialchars($spec_parent['title']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    -->

                                    <div class="form-group">
                                        <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="confirm_copy_specs_from_other_car_trim"
                                                           type="checkbox"
                                                           required
                                                        <?php if ($data['page_vars']['is_form_submitted'] == true
                                                            && isset($data['page_vars']['post_values']['confirm_create_new_car_trim'])
                                                        ) {
                                                            echo 'checked';
                                                        } ?>
                                                    />İşlem Onayı
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-6 col-sm-6 col-md-offset-4 col-md-6">
                                            <input type="hidden" name="mode" value="copy_specs_from_other_car_trim"/>
                                            <button type="submit" name="submit_btn" class="btn btn-primary">Seçili Versiyonun Donanımını Bu Versiyona Kopyala</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal"
                                      autocomplete="off">
                                    <div class="form-group">
                                        <label for="new_car_trim_title" class="col-sm-3 col-md-2 control-label">Versiyon</label>
                                        <div class="col-sm-6 col-md-6">
                                            <input class="form-control"
                                                   required
                                                   type="text"
                                                   name="new_car_trim_title"
                                                   id="new_car_trim_title"
                                                   value="<?php if (isset($data['page_vars']['post_values']['new_car_trim_title'])) {
                                                       echo htmlspecialchars($data['page_vars']['post_values']['new_car_trim_title']);
                                                   } ?>"
                                            />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="confirm_create_new_car_trim"
                                                           type="checkbox"
                                                           required
                                                        <?php if ($data['page_vars']['is_form_submitted'] == true
                                                            && isset($data['page_vars']['post_values']['confirm_create_new_car_trim'])
                                                        ) {
                                                            echo 'checked';
                                                        } ?>
                                                    />İşlem Onayı
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                            <input type="hidden" name="mode" value="copy_car_trim"/>
                                            <button type="submit" name="submit_btn" class="btn btn-primary">Versiyonun Kopyasını Oluştur</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal"
                              autocomplete="off">
                            <div class="form-group">
                                <label for="new_specs_parent_id"
                                       class="col-sm-3 col-md-2 control-label">Kategori</label>
                                <div class="col-sm-6 col-md-3">
                                    <select name="new_specs_parent_id" id="new_specs_parent_id" class="form-control"
                                            required>
                                        <option value="">Seçiniz</option>
                                        <?php foreach ($data['page_vars']['spec_parents'] as $spec_parent): ?>
                                            <option value="<?php echo $spec_parent['id']; ?>"><?php echo htmlspecialchars($spec_parent['title']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new_specs" class="col-sm-3 col-md-2 control-label">Donanımlar</label>
                                <div class="col-sm-9 col-md-10">
                                    <label>Standart Donanımlar
                                        <textarea name="standard_specs" rows="10" cols="60"
                                                  class="form-control"><?php if (isset($data['page_vars']['post_values']['standard_specs'])) {
                                                echo htmlspecialchars($data['page_vars']['post_values']['standard_specs']);
                                            } ?></textarea>
                                    </label>
                                    <label>Opsiyonel Donanımlar
                                        <textarea name="optional_specs" rows="10" cols="60"
                                                  class="form-control"><?php if (isset($data['page_vars']['post_values']['optional_specs'])) {
                                                echo htmlspecialchars($data['page_vars']['post_values']['optional_specs']);
                                            } ?></textarea>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input name="delete_current_specs_of_selected_category"
                                                   type="checkbox"
                                                <?php if ($data['page_vars']['is_form_submitted'] == true
                                                    && isset($data['page_vars']['post_values']['delete_current_specs_of_selected_category'])
                                                ) {
                                                    echo 'checked';
                                                } ?>
                                            />Kategorideki donanımları sil
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                    <input type="hidden" name="mode" value="add_specs"/>
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Donanım Ekle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                -->

                <!-- SPECS AND TECHNICAL DATA -->
                <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal" autocomplete="off">

                    <h2>Teknik Özellikler</h2>
                    <table class="table table-bordered">
                        <tbody>
                        <?php foreach ($data['page_vars']['tech_specs'] as $spec): ?>
                            <?php if ($spec['parent_id'] === null): ?>
                                <tr>
                                    <td colspan="100"
                                        class="specs_parent"><?php echo htmlspecialchars($spec['title']); ?></td>
                                </tr>
                                <?php foreach ($data['page_vars']['tech_specs'] as $sub): ?>
                                    <?php if ($sub['parent_id'] == $spec['id']): ?>
                                        <tr>
                                            <td class="col-md-2 text-right vertical-middle">
                                                <b><?php echo htmlspecialchars($sub['title']); ?></b></td>
                                            <td class="col-sm-4 col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Değer</div>
                                                    <?php if ($sub['has_value_list'] == true): ?>
                                                        <select style="background-color: #ffffdb;" class="form-control" name="tech_spec_value_ids[<?php echo $sub['id']; ?>]" id="tech_spec_value_ids[<?php echo $sub['id']; ?>]" <?php if ($sub['is_required'] == true): ?>required<?php endif; ?>>
                                                            <option value=""></option>
                                                            <?php foreach ($sub['tech_spec_values'] as $tech_spec_value) : ?>
                                                                <option value="<?php echo $tech_spec_value['id']; ?>"
                                                                    <?php if ((isset($data['page_vars']['post_values']['tech_spec_value_ids'][$sub['id']]) && $data['page_vars']['post_values']['tech_spec_value_ids'][$sub['id']] == $tech_spec_value['id'])
                                                                        || ($data['page_vars']['is_form_submitted'] == false && $sub['car_trim']['tech_spec_value_id'] == $tech_spec_value['id'])
                                                                    ) {
                                                                        echo 'selected';
                                                                    } ?>><?php echo $tech_spec_value['title']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php else: ?>
                                                        <input class="form-control"
                                                               type="text"
                                                               name="tech_spec_values[<?php echo $sub['id']; ?>]"
                                                               id="tech_spec_values[<?php echo $sub['id']; ?>]"
                                                               value="<?php if (isset($data['page_vars']['post_values']['tech_spec_values'][$sub['id']])) {
                                                                   echo htmlspecialchars($data['page_vars']['post_values']['tech_spec_values'][$sub['id']]);
                                                               } else {
                                                                   echo htmlspecialchars($sub['car_trim']['spec_value']);
                                                               } ?>"
                                                               <?php if ($sub['is_required'] == true): ?>required<?php endif; ?>
                                                        />
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="col-sm-4 col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Birim</div>
                                                    <input class="form-control"
                                                           type="text"
                                                           name="tech_spec_units[<?php echo $sub['id']; ?>]"
                                                           id="tech_spec_units[<?php echo $sub['id']; ?>]"
                                                           value="<?php if (isset($data['page_vars']['post_values']['tech_spec_units'][$sub['id']])) {
                                                               echo htmlspecialchars($data['page_vars']['post_values']['tech_spec_units'][$sub['id']]);
                                                           } else {
                                                               echo htmlspecialchars($sub['unit']);
                                                           } ?>"
                                                           readonly
                                                    />
                                                </div>
                                            </td>
                                            <td width="100"></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <tr>
                                    <td></td>
                                    <td colspan="4">
                                        <button type="submit" name="submit_btn" class="btn btn-primary">Kaydet</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <h2>Ortak Donanımlar</h2>
                    <table class="table table-bordered">
                        <tbody>
                        <?php foreach ($data['page_vars']['common_specs'] as $spec): ?>
                            <?php if ($spec['parent_id'] === null): ?>
                                <tr>
                                    <td colspan="100"
                                        class="specs_parent"><?php echo htmlspecialchars($spec['title']); ?></td>
                                </tr>
                                <?php foreach ($data['page_vars']['common_specs'] as $sub): ?>
                                    <?php if ($sub['parent_id'] == $spec['id']): ?>
                                        <tr>
                                            <td class="col-md-3 text-right vertical-middle">
                                                <label class="checkbox-inline">
                                                    <input name="common_spec_value_checks[<?php echo $sub['id']; ?>]"
                                                           type="checkbox"
                                                        <?php if (($sub['is_selected_by_default'] == true && $sub['car_trim']['exists'] === false) || $sub['car_trim']['is_selected'] == true || $sub['is_required'] == true) {
                                                            echo 'checked';
                                                        } ?>
                                                       <?php if ($sub['is_required'] == true): ?>required<?php endif; ?>
                                                    /> <b><?php echo htmlspecialchars($sub['title']); ?></b>
                                                </label>
                                            </td>
                                            <td class="col-sm-4 col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Değer</div>

                                                    <?php if ($sub['has_value_list'] == true): ?>
                                                        <select style="background-color: #ffffdb;" class="form-control" name="common_spec_value_ids[<?php echo $sub['id']; ?>]" id="common_spec_value_ids[<?php echo $sub['id']; ?>]" <?php if ($sub['is_required'] == true): ?>required<?php endif; ?>>
                                                            <option value=""></option>
                                                            <?php foreach ($sub['common_spec_values'] as $common_spec_value) : ?>
                                                                <option value="<?php echo $common_spec_value['id']; ?>"
                                                                    <?php if ((isset($data['page_vars']['post_values']['common_spec_value_ids'][$sub['id']]) && $data['page_vars']['post_values']['common_spec_value_ids'][$sub['id']] == $common_spec_value['id'])
                                                                        || ($data['page_vars']['is_form_submitted'] == false && $sub['car_trim']['common_spec_value_id'] == $common_spec_value['id'])
                                                                    ) {
                                                                        echo 'selected';
                                                                    } ?>><?php echo $common_spec_value['title']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php else: ?>
                                                        <input class="form-control"
                                                               type="text"
                                                               name="common_spec_values[<?php echo $sub['id']; ?>]"
                                                               id="common_spec_values[<?php echo $sub['id']; ?>]"
                                                               value="<?php if (isset($data['page_vars']['post_values']['common_spec_values'][$sub['id']])) {
                                                                   echo htmlspecialchars($data['page_vars']['post_values']['common_spec_values'][$sub['id']]);
                                                               } else {
                                                                   echo htmlspecialchars($sub['car_trim']['spec_value']);
                                                               } ?>"
                                                               <?php if ($sub['is_required'] == true): ?>required<?php endif; ?>
                                                        />
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="col-sm-4 col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Birim</div>
                                                    <input class="form-control"
                                                           type="text"
                                                           name="common_spec_units[<?php echo $sub['id']; ?>]"
                                                           id="common_spec_units[<?php echo $sub['id']; ?>]"
                                                           value="<?php if (isset($data['page_vars']['post_values']['common_spec_units'][$sub['id']])) {
                                                               echo htmlspecialchars($data['page_vars']['post_values']['common_spec_units'][$sub['id']]);
                                                           } else {
                                                               echo htmlspecialchars($sub['unit']);
                                                           } ?>"
                                                           readonly
                                                    />
                                                </div>
                                            </td>
                                            <td width="100"></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <tr>
                                    <td></td>
                                    <td colspan="4">
                                        <button type="submit" name="submit_btn" class="btn btn-primary">Kaydet</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h2>Donanımlar</h2>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="specs" rows="12" cols="60"
                                              class="form-control"><?php if (isset($data['page_vars']['post_values']['specs'])) {
                                               echo htmlspecialchars($data['page_vars']['post_values']['specs']);
                                           } else {
                                               echo htmlspecialchars($data['page_vars']['car_trim']['specs']);
                                           } ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--
                    <h2>Donanımlar</h2>
                    <table class="table table-bordered">
                        <colgroup>
                            <col>
                            <col style="width: 1px;">
                            <col style="width: 1px;">
                            <col style="width: 1px;">
                        </colgroup>
                        <tbody>
                        <?php foreach ($data['page_vars']['car_trim_specs'] as $spec): ?>
                            <?php if ($spec['parent_id'] === null): ?>
                                <tr>
                                    <td colspan="5"
                                        class="specs_parent"><?php echo htmlspecialchars($spec['title']); ?></td>
                                </tr>
                                <?php foreach ($data['page_vars']['car_trim_specs'] as $sub): ?>
                                    <?php if ($sub['parent_id'] == $spec['spec_id']): ?>
                                        <tr>
                                            <td class="col-md-2 text-right"><p
                                                        class="form-control-static"><?php echo htmlspecialchars($spec['title']); ?></p>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input name="spec_values[<?php echo $sub['id']; ?>]"
                                                           type="radio"
                                                           required
                                                        <?php if ((isset($data['page_vars']['post_values']['spec_values'][$sub['id']])
                                                                && $data['page_vars']['post_values']['spec_values'][$sub['id']]
                                                                == 'standard')
                                                            || ($data['page_vars']['is_form_submitted'] == false
                                                                && $sub['spec_value'] == 'standard')
                                                        ) {
                                                            echo 'checked';
                                                        } ?>
                                                           value="standard"> Standart
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input name="spec_values[<?php echo $sub['id']; ?>]"
                                                           type="radio"
                                                           required
                                                        <?php if ((isset($data['page_vars']['post_values']['spec_values'][$sub['id']])
                                                                && $data['page_vars']['post_values']['spec_values'][$sub['id']]
                                                                == 'optional')
                                                            || ($data['page_vars']['is_form_submitted'] == false
                                                                && $sub['spec_value'] == 'optional')
                                                        ) {
                                                            echo 'checked';
                                                        } ?>
                                                           value="optional"> Opsiyonel
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input name="spec_values[<?php echo $sub['id']; ?>]"
                                                           type="radio"
                                                           required
                                                        <?php if ((isset($data['page_vars']['post_values']['spec_values'][$sub['id']])
                                                                && $data['page_vars']['post_values']['spec_values'][$sub['id']]
                                                                == 'optional')
                                                            || ($data['page_vars']['is_form_submitted'] == false
                                                                && $sub['spec_value'] == '')
                                                        ) {
                                                            echo 'checked';
                                                        } ?>
                                                           value="remove"> Yok
                                                </label>
                                            </td>
                                            <td><p class="form-control-static">
                                                    <b><?php echo htmlspecialchars($sub['title']); ?></b></p></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <tr>
                                    <td></td>
                                    <td colspan="4">
                                        <button type="submit" name="submit_btn" class="btn btn-primary">Kaydet</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    -->


                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                            <input type="hidden" name="mode" value="update_specs"/>
                        </div>
                    </div>
                </form>

                <!-- GALLERY - BEGIN -->
                <div class="panel panel-default">
                    <div class="panel-heading">Resim Galerisi</div>
                    <div class="panel-body">
                        <form action="" method="post" enctype="multipart/form-data" role="form" class="form-horizontal"
                              autocomplete="off">
                            <div class="form-group">
                                <label for="image_category_id" class="col-sm-3 col-md-2 control-label">Kategori</label>
                                <div class="col-sm-6 col-md-3">
                                    <select name="image_category_id" id="image_category_id" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($data['page_vars']['image_categories'] as $row) : ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if (isset($data['page_vars']['post_values']['image_category_id'])
                                                && $data['page_vars']['post_values']['image_category_id'] == $row['id']
                                            ) {
                                                echo 'selected';
                                            } ?>><?php echo $row['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="image-selection">
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="new_images[]" class="col-sm-3 col-md-2 control-label">Yeni Resim</label>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-inline">
                                            <input class="form-control"
                                                   required
                                                   type="file"
                                                   name="new_images[]"
                                                   id="new_images[]"/>
                                            <button type="button" class="btn btn-primary remove-image-input"><i
                                                        class="fa fa-minus"></i></button>
                                            <button type="button" class="btn btn-primary add-image-input"><i
                                                        class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="titles[]" class="col-sm-3 col-md-2 control-label">Açıklama (İsteğe Bağlı)</label>
                                    <div class="col-sm-6 col-md-3">
                                        <input class="form-control"
                                               type="text"
                                               name="titles[]"
                                               id="titles[]"
                                               value=""
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-3">
                                    <input type="hidden" name="mode" value="upload_gallery_image"/>
                                    <button type="submit" name="submit_btn" class="btn btn-primary">Resim Yükle</button>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <?php foreach ($data['page_vars']['car_trim_images'] as $row) : ?>
                                <div class="col-sm-6 col-md-3 col-lg-2">
                                    <div class="thumbnail">
                                        <img src="<?php echo AZURE_STORAGE_ADDRESS . $row['cdn_thumbnail_path']; ?>"
                                             alt="<?php echo htmlspecialchars($car_trim['car_make_title'] . ' '
                                                 . $car_trim['car_model_title'] . ' '
                                                 . $car_trim['car_model_generation_title'] . ' '
                                                 . $car_trim['title']); ?>"/>
                                        <div class="caption text-center">
                                            <form action="" method="post" enctype="multipart/form-data" role="form"
                                                  class="form-horizontal" autocomplete="off">
                                                <p><?php echo htmlspecialchars($row['image_category_title']); ?>
                                                    &nbsp;<?php echo ! empty($row['title']) ? '| '
                                                        . htmlspecialchars($row['title']) : ''; ?></p>
                                                <input type="hidden" name="mode" value="delete_gallery_image"/>
                                                <input type="hidden" name="image_id" value="<?php echo $row['id']; ?>"/>
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
                                                        />Sil
                                                    </label>
                                                </div>
                                                <p class="margin-top-10">
                                                    <button type="submit" name="submit_btn" class="btn btn-primary">
                                                        Resmi Sil
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
                <!-- GALLERY - END -->

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
            var el_car_make = $('#car_make_id');
            var el_car_model = $('#car_model_id');
            var el_car_model_generation = $('#car_model_generation_id');
            var el_new_spec_parent = $('#new_spec_parent_id');
            var el_new_spec = $('#new_spec_id');

            el_car_make.change(function () {
                if (el_car_model.children().length > 0) {
                    el_car_model.children().slice(1).remove();
                }
                if (el_car_model_generation.children().length > 0) {
                    el_car_model_generation.children().slice(1).remove();
                }

                el_car_make.prop('disabled', true);
                el_car_model.prop('disabled', true);

                jQuery.ajax({
                    method: 'POST',
                    url: '<?php echo AJAX_URL; ?>?action=car_models',
                    data: {car_make_id: el_car_make.prop('value')},
                    dataType: 'json'
                }).done(function (msg) {
                    if (msg.result === 'success') {
                        msg.values.rows.forEach(function (row) {
                            el_car_model.append("<option value=\"" + row['id'] + "\">" + row['title'] + "</option>");
                        });
                    }
                    else {
                        console.log(msg.error);
                    }
                    el_car_make.prop('disabled', false);
                    el_car_model.prop('disabled', false);
                });
            });

            el_car_model.change(function () {
                if (el_car_model_generation.children().length > 0) {
                    el_car_model_generation.children().slice(1).remove();
                }

                el_car_model.prop('disabled', true);
                el_car_model_generation.prop('disabled', true);

                jQuery.ajax({
                    method: 'POST',
                    url: '<?php echo AJAX_URL; ?>?action=car_model_generations',
                    data: {car_model_id: el_car_model.prop('value')},
                    dataType: 'json'
                }).done(function (msg) {
                    if (msg.result === 'success') {
                        msg.values.rows.forEach(function (row) {
                            el_car_model_generation.append("<option value=\"" + row['id'] + "\">" + row['compound_title'] + "</option>");
                        });
                    }
                    else {
                        console.log(msg.error);
                    }

                    el_car_model.prop('disabled', false);
                    el_car_model_generation.prop('disabled', false);
                });
            });

            el_new_spec_parent.change(function () {
                if (el_new_spec.children().length > 0) {
                    el_new_spec.children().slice(1).remove();
                }

                el_new_spec_parent.prop('disabled', true);
                el_new_spec.prop('disabled', true);

                jQuery.ajax({
                    method: 'POST',
                    url: '<?php echo AJAX_URL; ?>?action=specs',
                    data: {
                        parent_id: el_new_spec_parent.prop('value'),
                        car_trim_id: <?php echo $data['page_vars']['car_trim']['id']; ?> },
                    dataType: 'json'
                }).done(function (msg) {
                    if (msg.result === 'success') {
                        msg.values.rows.forEach(function (row) {
                            el_new_spec.append("<option value=\"" + row['id'] + "\">" + row['title'] + "</option>");
                        });
                    }
                    else {
                        console.log(msg.error);
                    }
                    el_new_spec_parent.prop('disabled', false);
                    el_new_spec.prop('disabled', false);
                });
            });

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