<?php 
namespace App\Table;

use App\Model\Post;
use App\PaginatedQuery;
use PDO;

class PostTable extends Table {


    private $paginatedQuery;



    public function findPaginated()
    {

     //pagination
     $this->paginatedQuery = new PaginatedQuery("SELECT * FROM post ORDER BY created_at DESC","SELECT COUNT(id) FROM post",Post::class,$this->pdo,);

     /**@var Post[] */
     $posts =  $this->paginatedQuery->getItems();

     return $posts;

    }


    public function getPaginatedQuery()
    {

        return $this->paginatedQuery;
        
    }

}