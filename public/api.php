<?php

use App\Controllers\ApiController;
use App\Services\DataProcessor;
use App\Storage\FileStorage;

require_once __DIR__ . '/../vendor/autoload.php';

$storage = new FileStorage(__DIR__ . '/../logs/data.json');

$dataProcessor = new DataProcessor();

$controller = new ApiController($dataProcessor, $storage);

$controller->handleRequest();
