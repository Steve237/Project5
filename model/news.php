<?php

class News
{
    private $_id_post;
    private $_titre_article;
    private $_pseudo_auteur;
    private $_descriptif_article;
    private $_contenu;
    private $_date_modification;
    private $_image_article;


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


    public function id_post()
    {
        return $this->_id_post;

    }


    public function titre_article()
    {
        return $this->_titre_article;

    }


    public function pseudo_auteur()
    {
        return $this->_pseudo_auteur;

    }


    public function descriptif_article()
    {
        return $this->_descriptif_article;

    }


    public function contenu()
    {
        return $this->_contenu;

    }

    public function date_modification()
    {
        return $this->_date_modification;

    }


    public function image_article()
    {
        return $this->_image_article;

    }

    public function setId_Post($id_post)
    {

        $id_post = (int) $id_post;

        if ($id_post > 0) 
        {

            $this->_id_post = $id_post;

        }

    }


    public function setTitre_Article($titre_article)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        if (is_string($titre_article)) 
        {
            $this->_titre_article = $titre_article;
        }
    }

    public function setPseudo_Auteur($pseudo_auteur)
    {

        if (is_string($pseudo_auteur)) 
        {
            $this->_pseudo_auteur = $pseudo_auteur;
        }
    }


    public function setDescriptif_Article($descriptif_article)
    {

        if (is_string($descriptif_article)) 
        {
            $this->_descriptif_article = $descriptif_article;
        }
    }


    public function setContenu($contenu)
    {

        if (is_string($contenu)) 
        {
            $this->_contenu = $contenu;
        }
    }


    public function setDate_Modification($date_modification)
    {

        $this->_date_modification = $date_modification;
    }

    public function setImage_Article($image_article)
    {

        $this->_image_article = $image_article;

    }


}
