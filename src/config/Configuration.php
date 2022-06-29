<?php 

namespace App\config;

class Configuration {

    private $id;
    private $db_user;
    private $db_password;


    public function __construct($id,$db_user,$db_password)
    {
        $this->id = $id;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
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