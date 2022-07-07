<?php

use App\database\DataProvider;
use App\HTML\Form;
use App\Request\Validation;
use App\Table\PostTable;
use Valitron\Validator;


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

    $data = $_POST;

    $v = new Validation($data);

    $validate = $v->validate();

    if($validate->validate()) {


         $date = $_POST['created_at'];
         $post->setName($_POST['name'])
         ->setContent($_POST['content'])
         ->setSlug($_POST['slug']);
         $post->setCreated_at($date);
         $post->setId($params['id']);
         $postTable->update($post,'post');
         $success = true;

    } else {

         $errors = $validate->errors();
        
    }

 }

 $form = new Form($post,$errors);

?>

<?php if($success) :  ?>
    <div class="alert alert-success">
        L'article a bien été modifier      
    </div>
<?php endif ?>

<?php if(!empty($errors)) : ?>

    <div class="alert alert-danger">
        L'article n'a pas pu étre modifier, merci de corriger vos erreurs.
        
        <ul>
            
            <?php  
            
            $i = 0;
            
            foreach($errors as $key => $error)
            {
              
               echo $error[$i]; 
               echo '<br>';
                  
            }
            
            ?>

        </ul>

    </div>

<?php endif ?>

<h1> Editer l'article <?= $post->getName() ?> </h1>

<form action="" method="POST">

     <?= $form->input('name','Titre'); ?>
     <?= $form->input('slug','Slug'); ?>
     <?= $form->textarea('content','content'); ?>
     <?= $form->input('created_at','Date de Creation'); ?>

   <button class="btn btn-primary">Modifier</button>

</form>

