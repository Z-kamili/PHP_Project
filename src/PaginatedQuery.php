<?php 
namespace App;

use PDO;

class PaginatedQuery {

    private $query;
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;
    private $currentPage;

    public function __construct(string $query,string $queryCount,string $classMapping,?\PDO $pdo = null,int $perPage = 12)
    {
        
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = $pdo;
        $this->perPage = $perPage;
        $this->currentPage = URL::getPositiveInt('page',1);
            
    }

    public function getItems() : array
    {
      

        $count = (int)$this->pdo
                 ->query($this->queryCount)
                 ->fetch(PDO::FETCH_NUM)[0];

        $pages = Pagination::PagesNum($count,$this->perPage);

        Pagination::verification($this->currentPage,$pages);

        // if($currentPage === '1') {
        //     header('Location: ' . $router->url('home'));
        //     http_response_code(301);
        //     exit();
        // }


        //calcule offset 
        
       $offset = Pagination::getOffset($this->currentPage,$this->perPage);

       //query 

       $query =  $this->pdo->query($this->query . " LIMIT {$this->perPage} OFFSET $offset");

       $posts = $query->fetchAll(PDO::FETCH_CLASS,$this->classMapping);

       return $posts;

    }


    public function getCurrentPage()
    {

       return $this->currentPage;

    }

}