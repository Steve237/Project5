<?php

namespace App\src\model;

class Comment
{
    private $_idCommentaire;
    private $_idPost;
    private $_pseudoAuteur;
    private $_contenuCommentaire;
    private $_dateCreation;
    private $_validation;


    public function __construct($valeurs = [])
    {
        if (!empty($valeurs)) {
        
            $this->hydrate($valeurs);
        }
    }

    public function hydrate(array $donnees)
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


    public function getIdCommentaire()
    {
        return $this->_idCommentaire;

    }

    public function getIdPost()
    {
        return $this->_idPost;

    }


    public function getPseudoAuteur()
    {
        return $this->_pseudoAuteur;

    }


    public function getContenuCommentaire()
    {
        return $this->_contenuCommentaire;

    }


    public function getDateCreation()
    {
        return $this->_dateCreation;

    }

    public function validation()
    {
        return $this->_validation;

    }


    public function setIdCommentaire($idCommentaire)
    {

        $idCommentaire = (int) $idCommentaire;

        if ($idCommentaire > 0) {

            $this->_idCommentaire = $idCommentaire;

        }


    }


    public function setIdPost($idPost)
    {
        // On vérifie qu'il s'agit bien d'un nombre
        $idPost = (int) $idPost;
        if ($idPost > 0) {
            $this->_idPost = $idPost;
        }
    }

    public function setPseudoAuteur($pseudoAuteur)
    {

        if (is_string($pseudoAuteur)) {
            
            $this->_pseudoAuteur = $pseudoAuteur;
        }
    }


    public function setContenuCommentaire($contenuCommentaire)
    {

        if (is_string($contenuCommentaire)) {
            
            $this->_contenuCommentaire = $contenuCommentaire;
        }
    }


    public function setDateCreation($dateCreation)
    {

        $this->_dateCreation = $dateCreation;

    }


    public function setValidation($validation)
    {
        $validation = (int) $validation;
        
        if ($validation > 0) {
        
            $this->_validation = $validation;
    
        }
    
    }

}

