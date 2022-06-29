<?php 
namespace App;

use Exception;

class Pagination {


    public static function PagesNum($count,$perPage,$name = "") {

        $pages = ceil($count /  $perPage);
        
        return $pages;

    }

    public static function verification($currentPage,$pages) {

        if($currentPage > $pages) {

            throw new Exception('Cette page n\existe pas');

        } else {
        
            if($currentPage <= 0) {
        
                throw new Exception('Numéro de page invalide');
            
            }

        }
        


    }

    public  static function getOffset($currentPage,$perPage) {

      return  $offset = $perPage * ( $currentPage - 1 );



    }






}