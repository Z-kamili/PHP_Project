<?php 

namespace App\HTML\Category;

class Form {


      private $data;

      private $error;


      public function __construct($data,array $errors)
      {
        
           $this->data = $data;
           $this->error = $errors;

      }

      public function input(string $key, string $label) : string 
      {
          $inputClass = 'form-control';

  
          return  <<<HTML
  
              <div class="form-group">
                       <label for="field($key)">{$label}</label>
                       <input type="text" id="field{$key}" class="{$inputClass}" name="{$key}"  required >  
              </div> 
  
          HTML;
  
      }

      






}



?>