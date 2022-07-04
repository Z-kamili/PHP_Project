<?php 
namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\Table\Exception\NotFoundException;
use PDO;

class Table {

    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function FindPostCategories(Post $post)
    {

        $query = $this->pdo->prepare('SELECT c.id , c.slug , c.name from post_category pc JOIN category c ON pc.category_id = c.id WHERE pc.post_id = :id ');
        
        $query->execute(['id' => $post->getId()]);
        
        $query->setFetchMode(PDO::FETCH_CLASS,Category::class);
        
        /** @var Category[] */
        
        $categories =  $query->fetchAll();
        
        if ($categories === false) {

              throw new  NotFoundException("category_post", $post->getId());

        }

        return $categories; 
        
    }

}