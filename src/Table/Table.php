<?php 
namespace App\Table;


class Table {

    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

}