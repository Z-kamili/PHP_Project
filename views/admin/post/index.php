<?php

use App\database\DataProvider;
use App\Table\PostTable;

$title = "Administration";

$data = new  DataProvider();

$pdo = $data->connection();

$poststable = new PostTable($pdo);

$posts = $poststable->findPaginated();

$link = $router->url('admin_posts');



?>


<table class="table table-striped">

    <thead>
        <th>Titre</th>
        <th>Actions</th>
    </thead>

    <tbody>

    <?php foreach($posts as $post): ?>
         <tr>
                <td> <?= $post->getName() ?> </td>
                <td>  </td>
         </tr>
    <?php endforeach ?>
    </tbody>

</table>

<div class="d-flex justify-content-between my-4">


      <?php if($poststable->getPaginatedQuery()->getcurrentPage() > 1): ?>
        <?php 
        if($poststable->getPaginatedQuery()->getCurrentPage()> 2) $link .= '?page=' . $poststable->getPaginatedQuery()->getCurrentPage() -1;
        ?>
           <a href="<?=$link ?>" class="btn btn-primary">&laquo; Page précédent</a>
       <?php endif ?>


       <?php if ($poststable->getPaginatedQuery()->getCurrentPage() < $poststable->getPaginatedQuery()->getPages()): ?>

            <a href="<?= $link ?>?page=<?= $poststable->getPaginatedQuery()->getCurrentPage() + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
        <?php endif ?>


</div>