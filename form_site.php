Class form_site

{

<?php

class form
{

private $datas = [];

public function __construct($datas =[])
{
    
$this->datas = $datas;
    
}
    
private function input($type, $name, $label){

$value= "";
    
if(isset($this->datas[$name]))
{
$value = $this->datas['name'];    
}


if ($type == 'textarea')
{

$input = "<textarea required name =\"$name\" id=\"input$name\">$value</textarea>";
}

else
{
$input = "<input required type =\"$type\" name=\"$name\" id=\"input$name\" value=\"$value\">";
    
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
?>    





































}