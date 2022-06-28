<?php 

require '../vendor/autoload.php';

$router = new AltoRouter();

define('VIEWS_PATH',dirname(__DIR__) . '/views');



$router->map('GET','/blog',function(){

    require VIEWS_PATH . '/post/index.php';

});



$router->map('GET','/blog/category',function(){

    require VIEWS_PATH . '/category/show.php';

});



//match route
$match = $router->match();

//call route
$match['target']();
