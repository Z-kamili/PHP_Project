<?php

namespace App\Model;

use App\Helpers\Text;
use COM;
use DateTime;

class Post {

    private $id;    

    private $name;

    private $content;

    private $slug;

    private $created_at;    

    private  $categories = [];




    public function getName() : ?string 
    {

        return $this->name;

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


    public function getCreated_at () : ?DateTime 
    {

        if($this->created_at === null) 
        {
            return null;
        }

        return new DateTime($this->created_at);

    }
    


    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId($id) : self
    {
       $this->id =  $id;

       return $this;
    }

    public function getSlug() : ?string
    {
        return $this->slug;
    }

    public function setSlug($slug) 
    {
        return $this->slug = $slug;
    }

    public function getContent() : ?string 
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


    public function getCategories() 
    {
        return $this->categories;
    }

    public function setCategories($cat) : self
    {
        $this->categories = $cat;

        return $this;
    }

    public function getCategories_ids() : array 
    {

         $ids = [];


         foreach($this->categories as $k => $category) 
         {
           
            $ids[] = $category;
         }

         return $ids;

    }


    public function addCategory(Category $category) : void 
    {

         $this->categories[] = $category;
         $category->setPost($this);

    }





}

