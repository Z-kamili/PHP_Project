<?php

use App\database\DataProvider;
use App\Table\PostTable;


$title = "edit page";

$data = new DataProvider();

//open connexion

$pdo =  $data->connection();

$postTable = new PostTable($pdo);

$post = $postTable->find($params['id']);

$success = false;

$errors = [];
//test 



if(!empty($_POST)) {
    
    if(empty($_POST['name'])) {

        $errors['name'][] = 'Le champs titre ne peut pas étre vide';
        $success = false;

    }

    if(mb_strlen($_POST['name']) <= 3 ) {

         $errors['name'][] = 'Le champs titre ne peut pas étre vide';
         $success = false;

    }

    if(empty($_POST['content'])) {

        $errors['content'][] = 'Le champs content et empty ';
        $success = false;

    }

    if(mb_strlen($_POST['content']) <= 3 ) {

         $errors['content'][] = ' Le champs content doit contenir 3 caractere et plus ';
         $success = false;

    }

    if(empty($errors)) {

         $post->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setId($params['id']);
         $postTable->update($post,'post');
         $success = true;

    }

 }

?>

<?php if($success) :  ?>
    <div class="alert alert-success">
        L'article a bien été modifier      
    </div>
<?php endif ?>

<?php if(!empty($errors)) : ?>
    <div class="alert alert-danger">
        L'article n'a pas pu étre modifier, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1> Editer l'article <?= $post->getName() ?> </h1>

<form action="" method="POST">

   <div class="form-group">
    <label for="name">Titre</label>
    <input type="text" class=" form-control" name="name" value="<?= $post->getName()?>" required > 

    <?php if(!empty($errors)) : ?>

        <div class="invalid-feedback">
            Lorem ipsum dolor sit amet, consectetur kjsfjklfdgkljfgdkljfgdkfdg.
        </div>

    <?php endif ?>

   </div>

   <div class="form-group">
    <label for="content">Content</label>
    <input type="text" class="nt-5 form-control" name="content" value="<?= $post->getContent()?>" required >

    <?php if(!empty($errors)) : ?>

        <div class="invalid-feedback">
         Lorem ipsum dolor sit amet, consectetur kjsfjklfdgkljfgdkljfgdkfdg.
        </div>

    <?php endif ?>

   </div>

   <button class="btn btn-primary">Modifier</button>

</form>

