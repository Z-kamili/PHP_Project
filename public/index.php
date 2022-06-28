<?php

use App\Router;

require '../vendor/autoload.php';

define('VIEWS_PATH',dirname(__DIR__) . '/views');

$router = new AltoRouter();

$router = new Router(dirname(__DIR__) . '/views');

$router
       ->get('/blog','post/index','blog')
       ->get('/blog/category','category/show','category')
       ->run();
