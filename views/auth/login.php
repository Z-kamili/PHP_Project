<?php

use App\database\DataProvider;
use App\HTML\Form;
use App\Model\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;
use FTP\Connection;

$title = "Mon site";
$user = new User();
$data = new DataProvider();

$pdo = '';

$error = [];

if(!empty($_POST)) {

    $user->setUserName($_POST['username']);

    if(empty($_POST['username']) || !empty($_POST['password'])) {

         $error['password'] = 'Identifiant ou mot de passe incorrect';

    }

    $pdo = $data->connection();

    $table = new UserTable($pdo);

 

    try {

        $user = $table->findByUsername($_POST['username']);

       if(password_verify($_POST['password'],$user->getPassword()) === true ) {

          session_start();
          $_SESSION['auth'] = $user->getId();
          header('Location:' . $router->url('admin_posts'));
          exit();

       }

    } catch (NotFoundException $e) {

         $errors['password'] = 'Identifiant ou mot de passe incorrect';

    }

    

}

$form = new Form($user,$error);



?>
<h1>Se connecter</h1>


<?php if(!empty($error)) : ?> 

<div class="alert alert-warning">
    <?= $error['password'][0] ?>
</div>

<?php endif?>

<form action="" method="POST">

   <?= $form->input('username','Nom d\'utilisateur'); ?>
   <?= $form->input('password','Mot de passe'); ?>
   <button type="submit" class="btn btn-primary">Se connecter</button>



</form>