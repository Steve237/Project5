<?php

class Comments
{
    private $_id_commentaire;
    private $_id_post;
    private $_pseudo_auteur;
    private $_contenu_commentaire;
    private $_date_creation;
    private $_validation;
    private $_titre_article;

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
    
    
    public function id_commentaire()
    {
        return $this->_id_commentaire;
        
    }
    
    public function id_post()
    {
        return $this->_id_post;
        
    }
    
    
    public function pseudo_auteur()
    {
        return $this->_pseudo_auteur;
        
    }
    
    
    public function contenu_commentaire()
    {
        return $this->_contenu_commentaire;
        
    }
    
    
    public function date_creation()
    {
        return $this->_date_creation;
        
    }
    
    public function validation()
    {
        return $this->_validation;
        
    }
    
    
      public function titre_article()
    {
        return $this->_titre_article;
        
    }
    
    
    public function setId_Commentaire($id_commentaire)
    {
        
        $id_commentaire = (int) $id_commentaire;
        
        if ($id_commentaire > 0) 
        {
            
        $this->_id_commentaire = $id_commentaire;
            
        }
        
        
    }
    
    
    public function setId_Post($id_post)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        $id_post = (int) $id_post;
        {
            $this->_id_post = $id_post;
        }
    }
    
    public function setPseudo_Auteur($pseudo_auteur)
    {
        
        if (is_string($pseudo_auteur)) 
        {
            $this->_pseudo_auteur = $pseudo_auteur;
        }
    }
    
    
    public function setContenu_Commentaire($contenu_commentaire)
    {
        
        if (is_string($contenu_commentaire)) 
        {
            $this->_contenu_commentaire = $contenu_commentaire;
        }
    }
    
    
    public function setDate_Creation($date_creation)
    {
        
        $this->_date_creation = $date_creation;
        
    }
    
    
    public function setValidation($validation)
    {
        
        $this->_validation = $validation;
    }
    

    public function setTitre_Article($titre_article)
    {
        
        $this->_titre_article = $titre_article;
    }

}

