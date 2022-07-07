<?php 

namespace App\Request;

use Valitron\Validator;

class Validation {

    private $data;
     

    public function __construct(array $data)
    {
        $this->data = $data;
    }


    public function validate() {

        Validator::lang('fr');

        // dd($this->data);

        $v = new Validator($this->data);
    
        $v->rule('required',['name','slug','content','created_at']);
        
        $v->rule('lengthBetween','name',3,200);
    
        $v->rule('lengthBetween','content',3,200);

        $v->rule('slug','slug');

        $v->rule(function ($field,$value){

            return false;

        },'slug','Ce slug est déja utilisé');

        $v->rule('required','created_at');
    

        return $v;

    }



}