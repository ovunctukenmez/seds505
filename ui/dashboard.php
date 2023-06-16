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

                <p><a href="new_listing.php">New Listing</a></p>

                <p><strong>Active Fish Listings (<?php echo $data['page_vars']['listings']['total']; ?>)</strong></p>
                <table class="table table-bordered table-striped">
                    <thead class="records">
                    <tr>
                        <th>#</th>
                        <th>Fish Type</th>
                        <th>Fish Weight</th>
                        <th>Fish Height</th>
                        <th>Starting Price</th>
                        <th>Current Price</th>
                        <th>Bid Count</th>
                        <th>Bid</th>
                        <th>Sell/Unsell Fish</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <?php foreach ($data['page_vars']['listings']['rows'] as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['fish_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['fish_weight']); ?> KG</td>
                            <td><?php echo htmlspecialchars($row['fish_height']); ?> CM</td>
                            <td><?php echo htmlspecialchars($row['starting_price']); ?> TL</td>
                            <td><?php echo htmlspecialchars($row['current_price']); ?> TL</td>
                            <td><?php echo htmlspecialchars($row['bid_count']); ?></td>
                            <td>
                                <a href="bid.php?id=<?php echo $row['id']; ?>">Bid</a>
                            </td>
                            <td>
                                <?php if ($row['is_sold']): ?>
                                    <a href="unsell_fish.php?id=<?php echo $row['id']; ?>">Unsell Fish</a>
                                <?php else: ?>
                                    <a href="sell_fish.php?id=<?php echo $row['id']; ?>">Sell Fish</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_listing.php?id=<?php echo $row['id']; ?>">Edit</a>
                            </td>
                            <td>
                                <a href="edit_listing.php?id=<?php echo $row['id']; ?>&d=1">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="100">
                                <!-- PHOTOS - BEGIN -->
                                <div class="row">
                                    <?php foreach ($row['photos'] as $photo) : ?>
                                        <div class="col-sm-6 col-md-3 col-lg-2">
                                            <div class="thumbnail">
                                                <img src="<?php echo UPLOAD_URL . '/' . $photo['photo_url']; ?>" />
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- PHOTOS - END -->
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="100" align="right">
                            <form id="records" name="records" method="get" action="" autocomplete="off">
                                <span style="margin-right: 10px">
                                    <b>Count</b>:
                                    <?php echo $data['page_vars']['listings']['total']; ?>
                                </span>
                                <span style="margin-right: 10px">
                                    <b>Record Per Page</b>:
                                    <select name="per_page" id="per_page" onchange="document.records.submit();">
                                    <?php foreach (array(10, 20, 50, 100) as $page) { ?>
                                        <option value="<?php echo $page; ?>" <?php if ($page
                                            == $data['page_vars']['listings']['per_page']
                                        ) {
                                            echo 'selected="selected"';
                                        } ?>><?php echo $page; ?></option>
                                    <?php } ?>
                                    </select>
                                </span>
                                <b>Page</b>:
                                <select name="p" id="p" onchange="document.records.submit();">
                                    <?php for (
                                        $i = 1; $i <= $data['page_vars']['listings']['page_count']; $i++
                                    ) { ?>
                                        <option value="<?php echo $i; ?>" <?php if ($i
                                            == $data['page_vars']['listings']['current_page']
                                        ) {
                                            echo 'selected="selected"';
                                        } ?>><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                                <?php foreach ($page_vars['form_hidden_elements'] as $name => $value): ?>
                                    <input type="hidden" name="<?php echo $name; ?>"
                                           value="<?php echo $value; ?>"/>
                                <?php endforeach; ?>
                            </form>
                        </td>
                    </tr>
                </table>

                <p><strong>Passive Fish Listings (<?php echo $data['page_vars']['passive_listings']['total']; ?>)</strong></p>
                <table class="table table-bordered table-striped">
                    <thead class="records">
                    <tr>
                        <th>#</th>
                        <th>Fish Type</th>
                        <th>Fish Weight</th>
                        <th>Fish Height</th>
                        <th>Starting Price</th>
                        <th>Current Price</th>
                        <th>Bid Count</th>
                        <th>Is Sold?</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <?php foreach ($data['page_vars']['passive_listings']['rows'] as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['fish_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['fish_weight']); ?> KG</td>
                            <td><?php echo htmlspecialchars($row['fish_height']); ?> CM</td>
                            <td><?php echo htmlspecialchars($row['starting_price']); ?> TL</td>
                            <td><?php echo htmlspecialchars($row['current_price']); ?> TL</td>
                            <td><?php echo htmlspecialchars($row['bid_count']); ?></td>
                            <td><?php echo ($row['is_sold'] ? 'Yes' : 'No'); ?></td>
                            <td>
                                <a href="edit_listing.php?id=<?php echo $row['id']; ?>">Edit</a>
                            </td>
                            <td>
                                <a href="edit_listing.php?id=<?php echo $row['id']; ?>&d=1">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="100">
                                <!-- PHOTOS - BEGIN -->
                                <div class="row">
                                    <?php foreach ($row['photos'] as $photo) : ?>
                                        <div class="col-sm-6 col-md-3 col-lg-2">
                                            <div class="thumbnail">
                                                <img src="<?php echo UPLOAD_URL . '/' . $photo['photo_url']; ?>" />
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- PHOTOS - END -->
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="100" align="right">
                            <span style="margin-right: 10px">
                                <b>Count</b>:
                                <?php echo $data['page_vars']['passive_listings']['total']; ?>
                            </span>
                        </td>
                    </tr>
                </table>
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