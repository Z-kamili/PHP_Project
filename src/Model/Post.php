<?php

namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post {

    private $id;

    private $name;

    private $content;

    private $slug;

    private $created_at;    

    private $categories = [];


    public function getName() : ?string{

        return htmlentities($this->name);

    }

    public function getExcerpt() : ?string {

         if($this->content === null){
            return null;
         }

        return  htmlentities(Text::exerpt($this->content,60));

    }


    public function getCreatedAt () : DateTime 
    {

        return new DateTime($this->created_at);

    }


    public function getId() : int
    {
        return $this->id;
    }

    public function getSlug() : string
    {
        return $this->slug;
    }

}

