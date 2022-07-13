<?php 

namespace App\Model;


class User {

     /**
      * @var string
      */
     private $username;

     /**
      * Undocumented variable
      *
      * @var string
      */
     private $password;



     public function getUserName() : ?string
     {
        return $this->username;
     }

     public function setUserName($username) : self
     {
       $this->username = $username;
       return $this;
     }

     public function getPassword() : ?string
     {
        return $this->password;
     }

     public function setPassword($password) 
     {
       $this->password = $password;
     }


}


?>