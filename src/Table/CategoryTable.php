<?php 

namespace App\Table;

use App\Model\Category;
use PDO;

class CategoryTable extends Table {



    public function find(int $id) : ?Category
    {

        $query =  $this->pdo->prepare('SELECT * FROM category WHERE id = :id');

        $query->execute(['id' => $id]);
        
        $query->setFetchMode(PDO::FETCH_CLASS , Category::class);

        /** @var Category|false */

        $category = $query->fetch();

        return $category;

    }
 




}