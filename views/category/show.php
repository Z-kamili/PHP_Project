<?php

use App\database\DataProvider;
use App\Model\Category;
use App\Model\Post;
use App\Pagination;
use App\URL;

$title = "Category";

$id =  (int)$params['id'];

$slug = $params['slug'];

$data =  new DataProvider();

$pdo  = $data->connection();

$query =  $pdo->prepare('SELECT * FROM category WHERE id = :id');

$query->execute(['id' => $id]);

$query->setFetchMode(PDO::FETCH_CLASS , Category::class);

/** @var Post|false */

$category = $query->fetch();

if($category === false) {

    throw new Exception('Aucun category ne correspond à cet ID');

}

if($category->getSlug() !== $slug) {

    $url = $router->url('category', ['slug' => $category->getSlug(),'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);

} 


$title = "Catégorie {$category->getName()}";


$currentPage = URL::getPositiveInt('page',1);

$perPage = 12;

//ceil eviter la virgule et aussi diviser par 12 c'est le nombre d'article par page.

$count = (int)$pdo
        ->query('SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category->getID())
        ->fetch(PDO::FETCH_NUM)[0];

$pages = Pagination::PagesNum($count,$perPage);

Pagination::verification($currentPage,$pages);

if($currentPage === '1') {
    header('Location: ' . $router->url('home'));
    http_response_code(301);
    exit();
}

$offset = Pagination::getOffset($currentPage,$perPage);

$query =  $pdo->query("
            SELECT p.* 
            FROM post p 
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$category->getId()}
            ORDER BY created_at DESC 
            LIMIT $perPage OFFSET $offset

");

$posts =  $query->fetchAll(PDO::FETCH_CLASS,Post::class);
$link = " ";
$link = $router->url('category',['id' => $category->getID(),'slug' => $category->getSlug()]);

$data->disconnect($pdo);

?>

<h1> <?= $title ?> </h1>


<h1>Ma category</h1>



<div class="row">
<?php foreach($posts as $post) : ?>
    <div class="col-md-3 mb-3">
       <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
<?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">

      <?php if($currentPage > 1): ?>
         
        <?php 

        $L =$router->url('category',['id' => $category->getID(),'slug' => $category->getSlug()]);

        if($currentPage > 2) $L  .= '?page=' . $currentPage -1;
        ?>
           <a href="<?= $L  ?>" class="btn btn-primary">&laquo; Page précédent</a>
       <?php endif ?>


       <?php if ($currentPage < $pages): ?>

            <a href="<?= $router->url('category',['id' => $category->getID(),'slug' => $category->getSlug()]) ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary"> <?= $pages . ' ' . $currentPage ?> Page suivant &raquo;</a>
        
        <?php endif ?>

</div>
