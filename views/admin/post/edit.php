<?php

use App\database\DataProvider;
use App\HTML\Form;
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
    
    Validator::lang('fr');

    $v = new Validator($_POST);

    $v->rule('required','name');

    $v->rule('required','content');

    $v->rule('lengthBetween','name',3,200);

    $v->rule('lengthBetween','content',3,200);



    // if(empty($_POST['name'])) {

    //     $errors['name'][] = 'Le champs titre ne peut pas étre vide';
    //     $success = false;

    // }

    // if(mb_strlen($_POST['name']) <= 3 ) {

    //      $errors['name'][] = 'Le champs titre ne peut pas étre vide';
    //      $success = false;

    // }

    // if(empty($_POST['content'])) {

    //     $errors['content'][] = 'Le champs content et empty ';
    //     $success = false;

    // }

    // if(mb_strlen($_POST['content']) <= 3 ) {

    //      $errors['content'][] = ' Le champs content doit contenir 3 caractere et plus ';
    //      $success = false;

    // }


    if($v->validate()) {

         $post->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setId($params['id']);
         $postTable->update($post,'post');
         $success = true;

    } else {

      $errors = $v->errors();
     




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

   <button class="btn btn-primary">Modifier</button>

</form>

