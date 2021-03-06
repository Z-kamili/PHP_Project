<?php 
namespace App\HTML;

use DateTimeInterface;

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
        $type = $key;


        if(isset($this->errors[$key])) {

            $inputClass .= ' is-invalid';

        }

        return  <<<HTML

            <div class="form-group">
                     <label for="field($key)">{$label}</label>
                     <input type="{$type}" id="field{$key}" class="{$inputClass}" name="{$key}" value="{$value}" required >  
            </div> 

        HTML;

    }

    public function password(string $key,string $label) :string 
    {

        $value = $this->getValue($key);
        $inputClass = 'form-control';
        $type = $key;

        return  <<<HTML

            <div class="form-group">
                     <label for="field($key)">{$label}</label>
                     <input type="{$type}" id="field{$key}" class="{$inputClass}" name="{$key}" required >  
            </div> 

        HTML;

    }

    public function textarea(string $name, string $label) : string 
    {

        $value = $this->getValue($name);
        $inputClass = 'form-control';

        return  <<<HTML
        
        <div class="form-group">
                 <label for="field($name)">{$label}</label>
                 <textarea type="text" id="field{$name}" class="{$inputClass}" name="{$name}">{$value}</textarea>
        </div> 
       
       HTML;
    }

    private function getValue (string $key)
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? null;
        }
        $method = 'get' . ucwords($key);
        $value = $this->data->$method(); 
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }


    private function getErrorFeedback(string $key): string 
    {

         if(isset($this->errors[$key])) {

             if(is_array($this->errors[$key])) {

                 $error = implode('<br>',$this->errors[$key]);

             } else {

                 $error = $this->errors[$key];

             }

             return '<div>' . implode('<br>',$this->errors[$key]) . '</div>';

         }

    }

    public function select(string $key,string $label,array $options = []) : string 
    {

        $optionsHTML = [];
        $value = $this->getValue($key);

        foreach($options as $k => $v) {

            $selected = in_array($k,$value) ? " selected" : "";
            $optionsHTML[] = "<option value=\"$k\"$selected>$v</option>";
 
        }

       
        $optionsHTML = implode('',$optionsHTML);
        $inputClass = 'form-control';

        return  <<<HTML
        
        <div class="form-group">
                 <label for="field($key)">{$label}</label>
                 <select multiple  id="field{$key}" class="{$inputClass}" name="{$key}[]"  >{$optionsHTML}</select>
                
        </div> 
       
       HTML;

    }




    // public function file (string $key, string $label) 
    // {

    //     return  <<<HTML
        
    //     <div class="form-group">
    //              <label for="field{$key}">{$label}</label>
    //              <input type="file" id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}">
    //              {$this->getErrorFeedback($key)}
    //     </div> 
       
    //    HTML;

    // }






/** 
 * 
 * 
 * 
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