<?php

use App\Router;

require '../vendor/autoload.php';

define('DEBUG_TIME',microtime(true));

$whoops = new \Whoops\Run;

$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

$whoops->register();

$router = new Router(dirname(__DIR__) . '/views');

$router
       ->get('/','post/index','home')
       ->get('/blog/category/[*:slug]-[i:id]','category/show','category')
       ->get('/blog/[*:slug]-[i:id]','post/show','post')
       ->get('/admin','admin/post/index','admin_posts')
       ->get('/admin/post/new','admin/post/new','admin_post_new')
       ->get('/admin/post/edit/[i:id]','admin/post/edit','admin_post_edit')
       ->post('/admin/post/delete/[i:id]' , 'admin/post/delete' , 'admin_post_delete')
       ->run();

