<?php

use App\Table\Auth;
use App\database\DataProvider;
use App\Table\CategoryTable;
use App\Table\PostTable;

Auth::check();

$title = "Administration";

$data = new  DataProvider();

$pdo = $data->connection();

$categoryTable = new CategoryTable($pdo);

$categories = $categoryTable->findPaginated();

?>

<?php if(isset($_GET['delete'])) : ?>

<div class="alert alert-success">
    L'enregistrement a bien été supprimé
</div>

<?php endif?>


<div class="btn">
       <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-success" >     Ajouter   </a>
</div>


<table class="table mt-5 table-striped">

    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>Actions</th>
    </thead>

    <tbody>

    <?php foreach($categories as $category): ?>
         <tr>

               <td> <?= $category->getID() ?> </td>

                <td>

                   <a href="<?= $router->url('admin_category_new',['id'=>$category->getId()]) ?>">     <?= $category->getName() ?>   </a>

                </td>

                <td> 

                   <a href=" <?= $router->url('admin_category_edit', ['id' => $category->getId() ] ) ?> " class="btn btn-primary" >  Editer   </a>

                   <form action=" <?= $router->url('admin_category_delete', [ 'id' => $category->getId() ] ) ?> " style="display: inline-block;" method="POST"  onclick="return confirm('Voulez vous vraiment effectuer cette action')">  <button type="submit"  class="btn btn-danger"> Supprimer </button>    </form>
                     
                </td>
         </tr>
    <?php endforeach ?>

    </tbody>

</table>

<div class="d-flex justify-content-between my-4">


      <?php if($categoryTable->getPaginatedQuery()->getcurrentPage() > 1): ?>
        <?php 
        $link = $router->url('admin_posts');
        if($categoryTable->getPaginatedQuery()->getCurrentPage()> 2) $link .= '?page=' . $categoryTable->getPaginatedQuery()->getCurrentPage() -1;
        ?>

           <a href="<?= $link ?>" class="btn btn-primary">&laquo; Page précédent</a>

       <?php endif ?>


       <?php if ($categoryTable->getPaginatedQuery()->getCurrentPage() < $categoryTable->getPaginatedQuery()->getPages()): ?>

            <a href="<?= $router->url('admin_posts') ?>?page=<?= $categoryTable->getPaginatedQuery()->getCurrentPage() + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
        <?php endif ?>


</div>