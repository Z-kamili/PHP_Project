<?php

use App\database\DataProvider;
use App\HTML\Form;
use App\Model\Post;
use App\Request\Validation;
use App\Table\CategoryTable;
use App\Table\PostTable;
use Valitron\Validator;


$title = "edit page";

$data = new DataProvider();

//open connexion

$pdo =  $data->connection();

$postTable = new PostTable($pdo);

$categoryTable = new CategoryTable($pdo);

$post = new Post();

$categories =  $categoryTable->list('category');




// dd($post->getCategories_ids());

$post = $postTable->find($params['id']);

$success = false;

$errors = [];

//test 

if(!empty($_POST)) {

    $data = $_POST;

    if(!empty($data['categories_ids'])){

        $post->setCategories($data['categories_ids']);

    }



    $v = new Validation($data,$postTable,$post->getCategories_ids());

    $validate = $v->PostValidate();

    if($validate->validate()) {

         $date = $_POST['created_at'];
         $post->setName($_POST['name'])
              ->setContent($_POST['content'])
              ->setSlug($_POST['slug']);
         $post->setId($params['id']);
         $post->setCreated_at($date);
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

<?php require('_form.php') ?>

