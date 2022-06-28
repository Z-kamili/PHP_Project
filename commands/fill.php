<?php 

// $faker = Faker\Factory::create();


//PDO Initialisation
$pdo = new PDO('mysql:dbname=php_project;host=localhost','root','',[

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

]);

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

//

$posts = [];
$categories = [];

for($i = 0;$i< 50; $i++){

    $pdo->exec("INSERT INTO post SET name='Article #$i' , slug='article-$i' , created_at='2022-05-11 14:00:00', content='Lorem ipsum'");
    $posts[] =  $pdo->lastInsertId();

}

for($i = 0;$i< 5; $i++){

    $pdo->exec("INSERT INTO category SET name='category #$i' , slug='category-$i'");
    $categories[] = $pdo->lastInsertId();

}

foreach($posts as $post) {

    foreach($categories as $category) {

        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");

    }

}

$password = password_hash('admin',PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin' , password='$password'");




