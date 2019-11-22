<?php

require_once __DIR__ . "/AutoLoader.php";

use lib\router;
use lib\Controller;

$kernel = new router($_GET);
$controller = $kernel->getController();
$controller->ExecuteAction();
