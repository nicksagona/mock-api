<?php

$autoloader = include __DIR__ . '/../vendor/autoload.php';

try {
    $app = new Popcorn\Pop($autoloader, include __DIR__ . '/../app/config/app.http.php');
    $app->register(new Mock\Api\Module());
    $app->run();
} catch (\Exception $exception) {
    $app = new Mock\Api\Module();
    $app->httpError($exception);
}


