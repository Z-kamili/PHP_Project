<?php 
namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\Table\Exception\NotFoundException;
use PDO;

class Table {

    protected $pdo;

    /**
     * Undocumented function
     *
     * @param [type] $pdo
     */
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @return void
     */
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


    /**
     * 
     *
     * @param string $field
     * @param [type] $value
     * @param [type] $table
     * @return boolean
     */
    public function exists (string $field,$value,$table) :bool   
    {
       $query = $this->pdo->prepare('SELECT COUNT(id) FROM {$table} WHERE $field = ? ');
       $query->execute([$value]);
       return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;



    }

}