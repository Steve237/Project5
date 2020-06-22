<?php
namespace App\src\model;

class Article
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

    /**
     * @return int
     */
    public function getIdPost()
    {
        return $this->_idPost;

    }

    /**
     * @return string
     */
    public function getTitreArticle()
    {
        return $this->_titreArticle;

    }

    /**
     * @return string
     */
    public function getPseudoAuteur()
    {
        return $this->_pseudoAuteur;

    }

    /**
     * @return string
     */
    public function getDescriptifArticle()
    {
        return $this->_descriptifArticle;

    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->_contenu;

    }

    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->_dateModification;

    }

    /**
     * @return string
     */
    public function getImageArticle()
    {
        return $this->_imageArticle;

    }

    /**
     * @return string
     */
    public function getNomImage()
    {
        return $this->_nomImage;

    }

    /**
     * @param mixed $idPost
     * 
     * @return int
     */
    public function setIdPost($idPost)
    {

        $idPost = (int) $idPost;

        if ($idPost > 0) {

            $this->_idPost = $idPost;

        }

    }
    
    /**
     * @param mixed $titreArticle
     * 
     * @return string
     */
    public function setTitreArticle($titreArticle)
    {
        // On vérifie qu'il s'agit bien d'une chaîne de caractères.
        if (is_string($titreArticle)) {
            
            $this->_titreArticle = $titreArticle;
        }
    }

    /**
     * @param mixed $pseudoAuteur
     * 
     * @return string
     */
    public function setPseudoAuteur($pseudoAuteur)
    {

        if (is_string($pseudoAuteur)) {
            
            $this->_pseudoAuteur = $pseudoAuteur;
        }
    }


    /**
     * @param mixed $descriptifArticle
     * 
     * @return string
     */
    public function setDescriptifArticle($descriptifArticle)
    {

        if (is_string($descriptifArticle)) {
            
            $this->_descriptifArticle = $descriptifArticle;
        }
    }


    /**
     * @param mixed $contenu
     * 
     * @return string
     */
    public function setContenu($contenu)
    {

        if (is_string($contenu)) {
            
            $this->_contenu = $contenu;
        }
    }


    /**
     * @param mixed $dateModification
     * 
     * 
     */
    public function setDateModification($dateModification)
    {

        $this->_dateModification = $dateModification;
    }

    
    /**
     * @param mixed $imageArticle
     * 
     * @return string
     */
    public function setImageArticle($imageArticle)
    {

        $this->_imageArticle = $imageArticle;

    }

    
    /**
     * @param mixed $nomImage
     * 
     * @return string
     */
    public function setNomImage($nomImage)
    {

        $this->_nomImage = $nomImage;

    }

}
