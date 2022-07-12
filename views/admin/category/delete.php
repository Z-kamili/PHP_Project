<?php

use App\Table\Auth;
use App\database\DataProvider;
use App\Table\CategoryTable;
use App\Table\PostTable;

$title = "category";

Auth::check();

$data = new DataProvider();

$pdo = $data->connection();

$table = new CategoryTable($pdo);

$table->delete($params['id'],'category');

header('Location:' .$router->url('admin_category') . '?delete=1');

?>
<h1> Suppression de <?= $params['id'] ?> </h1>