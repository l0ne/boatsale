<?php

define('ROOT', __DIR__);

$config = json_decode(file_get_contents(ROOT . '/cfg/config.json'));
foreach ($config->require->lib as $lib) require_once ROOT . $lib;

require_once ROOT . '/db/data.php';
$data = new Data($config);