<?php 
namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\Pagination;
use App\Table\Exception\NotFoundException;
use Exception;
use PDO;

final class PostTable extends Table {


    private $paginatedQuery;




    public function update(Post $post,$table) :void {

          $query = $this->pdo->prepare("UPDATE {$table} SET name = :name , content = :content , slug = :slug , created_at = :created_at WHERE id = :id");

          // dd($post->getCreated_at()->format('Y-m-d H:i:s'));

          $ok = $query->execute([
            'id' => $post->getID(),
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content'=> $post->getContent(),
            'created_at' => $post->getCreated_at()->format('Y-m-d H:i:s')
          ]);
       
          if($ok === false ) 
          { 
            throw new Exception("Impossible de supprimer l'enregistrement $post->getID() dans la table {$this->table}");
          }

    }

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

    public function delete(int $id,string $table) : void
    {

      $query =  $this->pdo->prepare("DELETE FROM {$table} WHERE id = ? ");

      $ok = $query->execute([$id]);

      if ($ok === false) {

        throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");

      }

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