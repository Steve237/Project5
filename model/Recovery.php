<?php 

class Recovery
{

private $_id_code;
private $_email;
private $_recovery_code;


    
    
     public function __construct($valeurs = [])
  {
    if (!empty($valeurs)) // Si on a spécifié des valeurs, alors on hydrate l'objet.
    {
      $this->hydrate($valeurs);
    }
  }
  
   
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) 
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set' . ucfirst($key);
            
            // Si le setter correspondant existe.
            if (method_exists($this, $method)) 
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }


public function id_code()
{
    
return $this->_id_code;    


}


public function email()
{
    
return $this->_email;    
    
}


public function recovery_code()
{
    
return $this->_recovery_code;    

}


public function setID_Code($id_code)
{
    
$id_code = (int) $id_code;  
    
if($id_code > 0)
{
    
$this->_id_code = $id_code;    

}
    
    
}

public function setEmail($email)
    
{
    
$this->_email = $email;


}
    
    
public function setRecovery_Code($recovery_code)
{
    
    
$this->_recovery_code = $recovery_code;


}

}
    
?>