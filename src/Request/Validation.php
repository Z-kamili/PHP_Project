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

        $v = new Validator($this->data);
    
        $v->rule('required','name');
    
        $v->rule('required','content');
    
        $v->rule('lengthBetween','name',3,200);
    
        $v->rule('lengthBetween','content',3,200);

        return $v;

    }



}