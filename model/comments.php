<?php

class Comments
{
    private $_id_commentaire;
    private $_id_post;
    private $_pseudo_auteur;
    private $_contenu_commentaire;
    private $_date_creation;
    private $_validation;


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


    public function id_Commentaire()
    {
        return $this->_id_commentaire;

    }

    public function id_Post()
    {
        return $this->_id_post;

    }


    public function pseudo_Auteur()
    {
        return $this->_pseudo_auteur;

    }


    public function contenu_Commentaire()
    {
        return $this->_contenu_commentaire;

    }


    public function date_Creation()
    {
        return $this->_date_creation;

    }

    public function validation()
    {
        return $this->_validation;

    }


    public function setId_Commentaire($idCommentaire)
    {

        $idCommentaire = (int) $idCommentaire;

        if ($idCommentaire > 0) 
        {

            $this->_id_Commentaire = $idCommentaire;

        }


    }


    public function setId_Post($idPost)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        $idPost = (int) $idPost;
        if ($idPost > 0) 
        {
            $this->_id_Post = $idPost;
        }
    }

    public function setPseudo_Auteur($pseudoAuteur)
    {

        if (is_string($pseudoAuteur)) 
        {
            $this->_pseudo_auteur = $pseudoAuteur;
        }
    }


    public function setContenu_Commentaire($contenuCommentaire)
    {

        if (is_string($contenuCommentaire)) 
        {
            $this->_contenu_commentaire = $contenuCommentaire;
        }
    }


    public function setDate_Creation($dateCreation)
    {

        $this->_date_creation = $dateCreation;

    }


    public function setValidation($validation)
    {
        $validation = (int) $validation
        
        if($validation > 0)
        {
        
            $this->_validation = $validation;
    
        }
    
    }



    public function getTitreArticle()
    {

        $newsManager = new NewsManager();

        $post = $newsManager->getPostById($this->_id_post);

        return $post->titre_article();

    }


}

