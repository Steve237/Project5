<?php

class Users

{
    
private $_id_membre;
private $_pseudo;
private $_password;
private $_email;
private $_date_inscription;
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
            $method = 'set'.ucfirst($key);
        
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }


    public function id_membre()
    {
    
        return $this->_id_membre;    

    }


    public function pseudo()
    {
    
        return $this->_pseudo;    

    }


    public function password()
    {   
    
        return $this->_password;    

    }

    public function email()
    {
    
        return $this->_email;    

    }


    public function date_inscription()
    {
    
        return $this->_date_inscription;    

    }


    public function setId_Membre($id_membre)

    {

        $id_membre = (int) $id_membre;

        if ($id_membre > 0)

        {

            $this->_id_membre = $id_membre;

        }


    }


    public function setPseudo($pseudo)
    
    
    {
    
        $this->_pseudo = $pseudo;    


    }
    
    
    
    public function setPassword($password)
    
    
    {
    
        $this->_password = $password;    


    }    
    
    
    
    
    
    public function setEmail($email)
    {
    
        $this->_email = $email;    


    }  
    

    public function recovery_code()
    {
    
        return $this->_recovery_code;    

    }    
    
    
    public function setDate_Inscription($date_inscription)
    
    
    {
    
        $this->_date_inscription = $date_inscription;    


    }    
    
    
    public function setRecovery_Code($recovery_code)
    {
    
    
        $this->_recovery_code = $recovery_code;


    }
    
}
