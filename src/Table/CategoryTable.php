<?php 

namespace App\Table;

use App\Model\Category;
use App\Table\Exception\NotFoundException;
use PDO;

class CategoryTable extends Table {



    public function find(int $id) : ?Category
    {

        $query =  $this->pdo->prepare('SELECT * FROM category WHERE id = :id');

        $query->execute(['id' => $id]);
        
        $query->setFetchMode(PDO::FETCH_CLASS , Category::class);

        /** @var Category|false */

        $category = $query->fetch();

        if ($category === false) {

            throw new NotFoundException('category',$id);

        }

        return $category;

    }
 




}