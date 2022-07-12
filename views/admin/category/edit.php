<?php

use App\database\DataProvider;
use App\HTML\Form;
use App\Request\Validation;
use App\Table\CategoryTable;
use App\Table\PostTable;
use Valitron\Validator;


$title = "edit page";

$data = new DataProvider();

//open connexion

$pdo =  $data->connection();

$categoryTable = new CategoryTable($pdo);

$ctg = $categoryTable->find($params['id']);

$success = false;

$errors = [];

//test 

if(!empty($_POST)) {

    $data = $_POST;

    $v = new Validation($data,$categoryTable);

    $validate = $v->CategoryValidate();

    if($validate->validate()) {

          $ctg->setName($_POST['name'])
              ->setSlug($_POST['slug']);
         $categoryTable->update($ctg,'category');
         $success = true;

    } else {

         $errors = $validate->errors();
        
    }

 }

 $form = new Form($ctg,$errors);

?>

<?php if($success) :  ?>
    <div class="alert alert-success">
        category a bien été modifier      
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

<h1> Editer category <?= $ctg->getName() ?> </h1>

<?php require('_form.php') ?>

