<?php

use App\Table\Auth;
use App\database\DataProvider;
use App\Table\PostTable;

$title = "good";

Auth::check();

$data = new DataProvider();

$pdo = $data->connection();

$table = new PostTable($pdo);

// $table->delete($params['id'],'post');

header('Location:' .$router->url('admin_posts') . '?delete=1');

?>
<h1> Suppression de <?= $params['id'] ?> </h1>