<?php
require_once("site/config/site.php");
require_once("site/config/auto_loaders.php");

$userSession = new UserSession();
$userSession->logoutSiteUser();

header("Location: dashboard.php");
exit();
