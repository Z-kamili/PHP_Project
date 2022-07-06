<?php 
namespace App\HTML;

class Form {

    private $data;

    private $errors;

    public function __construct($data , array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label) : string 
    {

        $value = $this->getValue($key);
        $inputClass = 'form-control';


        if(isset($this->errors[$key])) {

            $inputClass .= ' is-invalid';

        }

        return  <<<HTML
            <div class="form-group">
                     <label for="field($key)">{$label}</label>
                     <input type="text" id="field{$key}" class="{$inputClass}" name="{$key}" value="{$value}" required >  
            </div> 
        HTML;

    }

    public function textarea(string $name, string $label) : string 
    {
        $value = $this->getValue($name);
        $inputClass = 'form-control';


        if(isset($this->errors[$name])) {

            $inputClass .= ' is-invalid';

        }

        return  <<<HTML
        <div class="form-group">
                 <label for="field($name)">{$label}</label>
                 <textarea type="text" id="field{$name}" class="{$inputClass}" name="{$name}">{$value}</textarea>
        </div> 
    HTML;
    }

    private function getValue(string $key) {

         if(is_array($this->data)) {

            return $this->data[$key] ?? null;

         }


         
         $method = 'get' . ucfirst($key);


         return  $this->data->$method();


    }


/** 
 * 
 * 
 *  <div class="form-group">
     <label for="name">Titre</label>
     <input type="text" class=" form-control" name="name" value="<?= $post->getName()?>">  
 *   </div> 
 * 
 * 
 * 
 * 
 *  */    


}

?>