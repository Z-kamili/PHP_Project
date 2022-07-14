<form action="" method="POST" enctype="multipart/form-data">
     <?= $form->input('name','Titre'); ?>
     <?= $form->input('slug','Slug'); ?>
     <?= $form->select('categories_ids','categories',$categories ) ?>
     <?= $form->textarea('content','content'); ?>
     <?= $form->input('created_at','Date de Creation'); ?> 

   <button class="btn btn-primary">

   <?php if($post->getId() !== null) : ?>
        Modifier
    <?php else: ?>
        Crèer
    <?php endif ?> 

   </button>

</form> 

  