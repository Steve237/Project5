<?php

class News
{
    private $_idPost;
    private $_titreArticle;
    private $_pseudoAuteur;
    private $_descriptifArticle;
    private $_contenu;
    private $_dateModification;
    private $_imageArticle;
    private $_nomImage;


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


    public function getIdPost()
    {
        return $this->_idPost;

    }


    public function getTitreArticle()
    {
        return $this->_titreArticle;

    }


    public function getPseudoAuteur()
    {
        return $this->_pseudoAuteur;

    }


    public function getDescriptifArticle()
    {
        return $this->_descriptifArticle;

    }


    public function getContenu()
    {
        return $this->_contenu;

    }

    public function getDateModification()
    {
        return $this->_dateModification;

    }


    public function getImageArticle()
    {
        return $this->_imageArticle;

    }

    
    public function getNomImage()
    {
        return $this->_nomImage;

    }

    public function setIdPost($idPost)
    {

        $idPost = (int) $idPost;

        if ($idPost > 0) {

            $this->_idPost = $idPost;

        }

    }


    public function setTitreArticle($titreArticle)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        if (is_string($titreArticle)) {
            
            $this->_titreArticle = $titreArticle;
        }
    }

    public function setPseudoAuteur($pseudoAuteur)
    {

        if (is_string($pseudoAuteur)) {
            
            $this->_pseudoAuteur = $pseudoAuteur;
        }
    }


    public function setDescriptifArticle($descriptifArticle)
    {

        if (is_string($descriptifArticle)) {
            
            $this->_descriptifArticle = $descriptifArticle;
        }
    }


    public function setContenu($contenu)
    {

        if (is_string($contenu)) {
            
            $this->_contenu = $contenu;
        }
    }


    public function setDateModification($dateModification)
    {

        $this->_dateModification = $dateModification;
    }

    
    public function setImageArticle($imageArticle)
    {

        $this->_imageArticle = $imageArticle;

    }

    
    public function setNomImage($nomImage)
    {

        $this->_nomImage = $nomImage;

    }



}
