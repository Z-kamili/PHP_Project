<?php

use App\HTML\Form;
use App\Model\User;

$title = "Mon site";
$user = new User();
$form = new Form($user,[]);



?>
<h1>Se connecter</h1>

<form action="" method="POST">

   <?= $form->input('username','Nom d\'utilisateur'); ?>
   <?= $form->input('password','Mot de passe'); ?>
    

</form>