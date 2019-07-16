<?php

class form_site
{

private $datas = [];

public function __construct($datas =[])
{
    
$this->datas = $datas;
    
}
    
private function input($type, $name, $label)
{

$value= "";
    
if(isset($this->datas[$name]))
{
$value = $this->datas['name'];    
}


if ($type == 'textarea')
{

$input = "<textarea class=\"form-control\" placeholder=\"$label\" required name=\"$name\" id=\"input$name\">$value</textarea>";
}

else if ($type == 'text')
{

$input = "<input placeholder=\"$label\" pattern=\"[a-zA-Z]\" class=\"form-control\" required type=\"$type\" name=\"$name\" id=\"input$name\" value=\"$value\">";
}
    
else
{
$input = "<input placeholder=\"$label\" class=\"form-control\" required type=\"$type\" name=\"$name\" id=\"input$name\" value=\"$value\">";
    
}

return "<div>
<label for =\'input$name\'> $label </label>
$input
    </div>";
       

}

public function text($name, $label)

{
    
return $this->input('text', $name, $label);

}


public function email($name, $label)

{
    
  return $this->input('email', $name, $label);


}

public function textarea($name, $label)

{
    
  return $this->input('textarea', $name, $label);

}


}


class validator_site
{

    private $datas = [];
    private $errors = [];
    
    public function __construct($datas)
    {
        
    $this->datas = $datas;
    
    }

public function check($name, $rule)
{
$validator = "validate_$rule";

if(!$this->$validator($name))
{
   $this->errors[$name] = "le champ $name n'a pas été rempli";   
}


else
{

return "le message a bien été envoyé";   
    
}
}


public function validate_required($name)

{

return array_key_exists($name, $this->datas) && $this->datas[$name] != ''; 
    
}


public function validate_email($name)
{


return array_key_exists($name, $this->datas) && filter_var($this->datas[$name], FILTER_VALIDATE_EMAIL); 

}


public function errors()
{    

    return $this->errors;
    
    
}
}





















