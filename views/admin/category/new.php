<?php

use App\database\DataProvider;
use App\HTML\Form;
use App\Model\Category;
use App\Model\Post;
use App\Request\Validation;
use App\Table\CategoryTable;
use App\Table\PostTable;

$title = "category";

$data = new DataProvider();

//open connexion

$pdo =  $data->connection();

$CategoryTable = new CategoryTable($pdo);

$ctg = new Category();

$success = false;

$errors = [];

//test 


if(!empty($_POST)) {

    $data = $_POST;

    $v = new Validation($data , $CategoryTable);

    $validate = $v->CategoryValidate();

    if($validate->validate()) {

         $ctg->setName($_POST['name'])
             ->setSlug($_POST['slug']);
         $ctg->setId(null);
         $CategoryTable->create($ctg,'category');
         header('Location: ' . $router->url('admin_categories', ['id' => $ctg->getId()]) . '?created=1');
         exit();

    } else {

         $errors = $validate->errors();
        
    }

 }

 $form = new Form($ctg,$errors);

?>

<?php if($success) :  ?>
    <div class="alert alert-success">
        L'article a bien été enregistré      
    </div>
<?php endif ?>

<?php if(!empty($errors)) : ?>

    <div class="alert alert-danger">

        L'article n'a pas pu étre enregistré, merci de corriger vos erreurs.
        
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

<h1> Créer une category  </h1>

<?php require('_form.php') ?>



