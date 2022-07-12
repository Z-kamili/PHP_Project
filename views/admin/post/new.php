<?php

use App\database\DataProvider;
use App\HTML\Form;
use App\Model\Post;
use App\Request\Validation;
use App\Table\PostTable;


$title = "ajouter article";

$data = new DataProvider();

//open connexion

$pdo =  $data->connection();

$postTable = new PostTable($pdo);

$post = new Post();

$success = false;

$errors = [];

//test 
$date = date('Y-m-d H:i:s');
$post->setCreated_at($date);

if(!empty($_POST)) {

    $data = $_POST;

    $v = new Validation($data,$postTable);

    $validate = $v->PostValidate();

    if($validate->validate()) {

         $post->setName($_POST['name'])
              ->setContent($_POST['content'])
              ->setSlug($_POST['slug']);
         $post->setCreated_at($date);
         $post->setId(null);
         $postTable->create($post,'post');
         header('Location: ' . $router->url('admin_posts', ['id' => $post->getId()]) . '?created=1');
         exit();

    } else {

         $errors = $validate->errors();
        
    }

 }

 $form = new Form($post,$errors);

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

<h1> Créer un article  </h1>

<?php require('_form.php') ?>



