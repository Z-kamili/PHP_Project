<?php

use App\Table\Auth;
use App\database\DataProvider;
use App\Table\PostTable;

Auth::check();

$title = "Administration";

$data = new  DataProvider();

$pdo = $data->connection();

$poststable = new PostTable($pdo);

$posts = $poststable->findPaginated();

?>

<?php if(isset($_GET['delete'])) : ?>

<div class="alert alert-success">
    L'enregistrement a bien été supprimé
</div>

<?php endif?>

<table class="table table-striped">

    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>Actions</th>
    </thead>

    <tbody>

    <?php foreach($posts as $post): ?>
         <tr>

               <td> <?= $post->getID() ?> </td>

                <td>

                   <a href="<?= $router->url('admin_post_new',['id'=>$post->getID()]) ?>">     <?= $post->getName() ?>   </a>

                </td>

                <td> 

                   <a href=" <?= $router->url('admin_post_edit', ['id' => $post->getID() ] ) ?> " class="btn btn-primary" >  Editer      </a>

                   <form action=" <?= $router->url('admin_post_delete', [ 'id' => $post->getID() ] ) ?> " style="display: inline-block;" method="POST"  onclick="return confirm('Voulez vous vraiment effectuer cette action')">  <button type="submit"  class="btn btn-danger">Supprimer</button>    </form>
                     
                </td>
         </tr>
    <?php endforeach ?>

    </tbody>

</table>

<div class="d-flex justify-content-between my-4">


      <?php if($poststable->getPaginatedQuery()->getcurrentPage() > 1): ?>
        <?php 
        $link = $router->url('admin_posts');
        if($poststable->getPaginatedQuery()->getCurrentPage()> 2) $link .= '?page=' . $poststable->getPaginatedQuery()->getCurrentPage() -1;
        ?>

           <a href="<?=$link ?>" class="btn btn-primary">&laquo; Page précédent</a>

       <?php endif ?>


       <?php if ($poststable->getPaginatedQuery()->getCurrentPage() < $poststable->getPaginatedQuery()->getPages()): ?>

            <a href="<?= $router->url('admin_posts') ?>?page=<?= $poststable->getPaginatedQuery()->getCurrentPage() + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
        <?php endif ?>


</div>