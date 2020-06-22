<?php
namespace App\src\model;

class Users
{

    private $_idMembre;
    private $_pseudo;
    private $_password;
    private $_email;
    private $_dateInscription;
    private $_recoveryCode;
    private $_admin;
    private $_confirmKey;
    private $_confirmed;

    public function __construct($valeurs = [])
    {
        if (!empty($valeurs)) {
        
            $this->hydrate($valeurs);
        }
    }

    public function hydrate($donnees)
    {   
        foreach ($donnees as $key => $value) {
        
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set' . ucfirst($key);

            // Si le setter correspondant existe.
            if (method_exists($this, $method)) {
            
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    public function getIdMembre()
    {

        return $this->_idMembre;    

    }


    public function getPseudo()
    {

        return $this->_pseudo;    

    }


    public function getPassword()
    {   

        return $this->_password;    

    }

    public function getEmail()
    {

        return $this->_email;    

    }


    public function getDateInscription()
    {

        return $this->_dateInscription;    

    }


    
    public function getRecoveryCode()
    {

        return $this->_recoveryCode;    

    }    
    
    
    public function getAdmin()
    {

        return $this->_admin;    

    }  
    

    public function getConfirmKey() {

        return $this->_confirmKey;

    }

    public function getConfirmed() {

        return $this->_confirmed;
    }

    public function setIdMembre($idMembre)
    {
        $idMembre = (int) $idMembre;

        if ($idMembre > 0) {

            $this->_idMembre = $idMembre;

        }
    
    }


    public function setPseudo($pseudo)  
    {
        if (is_string($pseudo)) {
        
            $this->_pseudo = $pseudo;    
        }
    
    }


    public function setPassword($password)
    {
        if (is_string($password)) {
            
            $this->_password = $password;    
        }
    }    


    public function setEmail($email)
    {
        if (is_string($email)) {
            
            $this->_email = $email;    
            
        }
        
    }  

    
    public function setDateInscription($dateInscription)
    {

        $this->_dateInscription = $dateInscription;    

    }    


    public function setRecoveryCode($recoveryCode)
    {

        if (is_string($recoveryCode)) {
            
            $this->_recoveryCode = $recoveryCode;
        
        }
    
    }


    public function setAdmin($admin)
    {
        $admin = (int) $admin;

        if ($admin > 0) {

            $this->_admin = $admin;

        }
    
    }

    public function setConfirmKey($confirmKey)
    {

        if(is_string($confirmKey)) {


            $this->_confirmKey = $confirmKey;
        }

    }


    public function setConfirmed($confirmed) 
    {
        $confirmed = (int) $confirmed;

        if($confirmed > 0) {

            $this->_confirmed = $confirmed;

        }

    }

}
