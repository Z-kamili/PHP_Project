<?php 
namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\Pagination;
use App\Table\Exception\NotFoundException;
use PDO;

class PostTable extends Table {


    private $paginatedQuery;



    public function find(int $id) : Post 
    {
        $query =  $this->pdo->prepare('SELECT * FROM post WHERE id = :id');

        $query->execute(['id' => $id]);
        
        $query->setFetchMode(PDO::FETCH_CLASS , Post::class);
        
        /** @var Post|false */
        
        $post = $query->fetch();

        if($post === false) {

            throw new NotFoundException('post',$id);

        }

        return $post;

    }

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

    public function findPaginatedForCategory(int $categoryId)
    {

        $this->paginatedQuery = new PaginatedQuery(
         "SELECT p.* 
          FROM post p 
          JOIN post_category pc ON pc.post_id = p.id
          WHERE pc.category_id = {$categoryId}
          ORDER BY created_at DESC",
          "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryId}",
          Post::class,
          $this->pdo,
        );

        $posts =  $this->paginatedQuery->getItems();

        return $posts;

    }

    



}