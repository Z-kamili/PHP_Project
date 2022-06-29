<?php 

namespace App\Helpers;

class Text {

    public static function exerpt(string $content, int $limit = 60)
    {

        if(strlen($content) <$limit) {

            return $content;

        }

       return  substr($content,0,60) . '....';



    } 

}