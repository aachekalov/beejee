<?php

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

(new core\Application($config))->run();
