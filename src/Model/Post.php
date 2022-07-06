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


    public function getName() : ?string 
    {

        return htmlentities($this->name);

    }

    public function setName(string $name) :self 
    {

          $this->name = $name;
          return $this;

    }

    public function getExcerpt() : ?string 
    {

         if($this->content === null){
            return null;
         }

        return  htmlentities(Text::exerpt($this->content,60));

    }


    public function getCreated_at () : DateTime 
    {

        return new DateTime($this->created_at);

    }
    


    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id) 
    {
       $this->id =  $id;
    }

    public function getSlug() : string
    {
        return $this->slug;
    }

    public function setSlug($slug) 
    {
        return $this->slug = $slug;
    }

    public function getContent() : string 
    {
        return $this->content;
    }

    public function setContent(string $content): self 
    {

        $this->content = $content;
        return  $this;

    }
    
    public function setCreated_at($date)  : self
    {
        $this->created_at = $date;
        return $this;

    }
}

