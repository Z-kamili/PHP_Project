<?php 
namespace App\database;

use App\config\Configuration;
use PDO;
use PDOException;



class DataProvider {


    public function connection()
    {


        $config = new Configuration('mysql:dbname=php_project;host=localhost;port=3306','root','');

        try {

            return new PDO($config->getId(),$config->getDbUser(),$config->getDbPassword(),[

                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            
            ]);

        } catch(PDOException $th)
        {
             return null;
        }
         

    }

      public function disconnect($th) 
      {
          $db = null;
      }


}