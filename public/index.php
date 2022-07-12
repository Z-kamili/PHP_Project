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
       ->match('/admin/post/new','admin/post/new','admin_post_new')
       ->match('/admin/post/edit/[i:id]','admin/post/edit','admin_post_edit')
       ->post('/admin/post/delete/[i:id]' , 'admin/post/delete' , 'admin_post_delete')
       ->match('/admin/category/edit/[i:id]','admin/category/edit','admin_category_edit')
       ->post('/admin/category/delete/[i:id]' , 'admin/category/delete' , 'admin_category_delete')
       ->get('/admin/category','admin/category/index','admin_category')
       ->match('/admin/category/new','admin/category/new','admin_category_new')
       ->run();

