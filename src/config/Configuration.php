<?php 

namespace App\config;

class Configuration {

    private $id;
    private $db_user;
    private $db_password;


    public function __construct()
    {
        $this->id = 'mysql:dbname=php_project;host=localhost;port=3306';
        $this->db_user = 'root';
        $this->db_password = '';
    }


    public function getId()
    {
        return $this->id;
    }

    public function getDbUser()
    {
        return $this->db_user;
    }

    public function getDbPassword()
    {
        return $this->db_password;
    }


}