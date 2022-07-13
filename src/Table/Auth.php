<?php 
namespace App\Table;

use App\Security\ForbiddenException;
use Exception;

class Auth {

    public static function check () {

        if(!isset($_SESSION['auth'])) {
           throw new ForbiddenException();
        }

        
        

    }

}