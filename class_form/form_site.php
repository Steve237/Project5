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