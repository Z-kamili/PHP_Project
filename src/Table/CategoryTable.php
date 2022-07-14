<?php 

namespace App\Table;

use App\Model\Category;
use App\PaginatedQuery;
use App\Table\Exception\NotFoundException;
use Exception;
use PDO;

final class CategoryTable extends Table {

    private $paginatedQuery;

    public function find(int $id) : ? Category {

        $query =  $this->pdo->prepare('SELECT * FROM category WHERE id = :id');

        $query->execute(['id' => $id]);
        
        $query->setFetchMode( PDO::FETCH_CLASS , Category::class);

        /** @var Category|false */

        $category = $query->fetch();

        if ($category === false) {

            throw new NotFoundException('category',$id);

        }

        return $category;

    }


    public function create(Category $ctg,string $table) : void {

        $query = $this->pdo->prepare("INSERT INTO {$table} SET name = :name , slug = :slug");
 
        $ok = $query->execute([
 
         'name' => $ctg->getName(),
         'slug' => $ctg->getSlug(),
 
        ]);
 
        if($ok === false) {
 
              throw new Exception("Impossible de créer l'enregistrement dans la table $table}");
 
        }
 
        $ctg->setId($this->pdo->lastInsertId());
 
     }

     public function findPaginated() {

        //pagination
        $this->paginatedQuery = new PaginatedQuery("SELECT * FROM category","SELECT COUNT(id) FROM category",Category::class,$this->pdo,);
   
        /**@var Post[] */
        $categories =  $this->paginatedQuery->getItems();
        
        return $categories;
   
    }

    public function getPaginatedQuery() {

        return $this->paginatedQuery;
        
    }

    public function update(Category $ctg,$table) :void {

        $query = $this->pdo->prepare("UPDATE {$table} SET name = :name  , slug = :slug  WHERE id = :id");

        $ok = $query->execute([
          'id' => $ctg->getId(),
          'name' => $ctg->getName(),
          'slug' => $ctg->getSlug(),
        ]);
     
        if($ok === false ) 
        { 
          throw new Exception("Impossible de supprimer l'enregistrement $ctg->getID() dans la table {$this->table}");
        }

  }


  public function delete(int $id,string $table) : void {

    $query =  $this->pdo->prepare("DELETE FROM {$table} WHERE id = ? ");

    $ok = $query->execute([$id]);

    if ($ok === false) {

      throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");

    }

  }

  public function all($table)  
  {

     return $this->queryAndFetchAll("SELECT * FROM {$table} ORDER BY  id DESC");

  }

  public function  list($table)  {

    $categories = $this->all($table);


    $result = [];

    foreach($categories as $category) 
    {
         $result[$category->getID()] = $category->getName();
    }

    return $result;

  }



      

     
 




}