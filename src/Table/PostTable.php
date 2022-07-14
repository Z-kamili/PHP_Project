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

          $ok = $query->execute([
            'id' => $post->getID(),
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content'=> $post->getContent(),
            'created_at' => $post->getCreated_at()->format('Y-m-d H:i:s')
          ]);

          //update post_category

          foreach($post->getCategories_ids() as $category) 
          {
            $query = $this->pdo->prepare("UPDATE post_category SET post_id = :post_id and category_id = :category_id WHERE post_id = :id");

            $ok = $query->execute([
              'id' => $post->getID(),
              'post_id' => $post->getID(),
              'category_id' => $category,
            ]);
          }
       
          if($ok === false ) 
          { 
            throw new Exception("Impossible de supprimer l'enregistrement $post->getID() dans la table {$this->table}");
          }

    }

    public function create(Post $post,string $table) : void {

       $query = $this->pdo->prepare("INSERT INTO {$table} SET name = :name , slug = :slug , created_at = :created , content = :content");

       $ok = $query->execute([

        'name' => $post->getName(),
        'slug' => $post->getSlug(),
        'content' => $post->getContent(),
        'created' => $post->getCreated_at()->format('Y-m-d H:i:s')

       ]);

                 //add post_category
         $data = $this->all();
                 foreach($post->getCategories_ids() as $category) 
                 {
                   $query = $this->pdo->prepare("INSERT INTO  post_category SET post_id = :post_id, category_id = :category_id");
                   $ok = $query->execute([
                     'post_id' => $data->getID(),
                     'category_id' => $category,
                   ]);
                 }

       if($ok === false) {

             throw new Exception("Impossible de créer l'enregistrement dans la table $table}");

       }

       $post->setId($this->pdo->lastInsertId());

    }

    public function find(int $id) : Post  {

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

    
    public function all()   {

      $query =  $this->pdo->prepare('SELECT * FROM  post  ORDER BY id desc LIMIT 1');

      $query->execute();
      
      $query->setFetchMode(PDO::FETCH_CLASS , Post::class);
      
      /** @var Post|false */
      
      $post = $query->fetch();

      if($post === false) {

          throw new NotFoundException('post',$post);

      }

      return $post;

  }

    public function findPaginated() {

     //pagination
     $this->paginatedQuery = new PaginatedQuery("SELECT * FROM post ORDER BY created_at DESC","SELECT COUNT(id) FROM post",Post::class,$this->pdo,);

     /**@var Post[] */
     $posts =  $this->paginatedQuery->getItems();

     return $posts;

    }

    public function delete(int $id,string $table) : void {

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