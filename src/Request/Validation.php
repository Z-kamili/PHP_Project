<?php 

namespace App\Request;

use App\Table\PostTable;
use Valitron\Validator;

class Validation {

    private $data;
    private $table;
     

    public function __construct(array $data,$table)
    {
        $this->data = $data;
        $this->table = $table;
    }


    public function PostValidate() {

        Validator::lang('fr');

        $v = new Validator($this->data);
    
        $v->rule('required',['name','slug','content','created_at']);
        
        $v->rule('lengthBetween','name',3,200);
    
        $v->rule('lengthBetween','content',3,200);

        $v->rule('slug','slug');

        $v->rule(function ($field,$value)  {

            return !$this->table->exists($field,$value,'post');

        },['slug','name'],'Ce slug est déja utilisé');

        $v->rule('required','created_at');
    

        return $v;

    }

    public function  CategoryValidate() {

        Validator::lang('fr');

        $v = new Validator($this->data);
    
        $v->rule('required',['name','slug']);
        
        $v->rule('lengthBetween','name',3,200);

        $v->rule('slug','slug');

        $v->rule(function ($field,$value)  {

            return !$this->table->exists($field,$value,'category');

        },['slug','name'],'Ce slug est déja utilisé');
    

        return $v;

    }



}