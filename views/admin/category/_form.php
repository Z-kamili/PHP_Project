<form action="" method="POST">
     <?= $form->input('name','Titre'); ?>
     <?= $form->input('slug','Slug'); ?>
   <button class="btn btn-primary">

   <?php if($ctg->getId() !== null) : ?>
        Modifier
    <?php else: ?>
        Crèer
    <?php endif ?> 

   </button>

</form> 