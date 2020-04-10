<?php

class Article extends Database
{
    
    public function getArticles()
    {
       
        $sql = 'SELECT idPost, titreArticle, pseudoAuteur, descriptifArticle, contenu, DATE_FORMAT(dateModification, "%d/%m/%Y %Hh%imin%ss") AS dateModification, imageArticle FROM articles';
        
        $result = $this->sql($sql);
        
        return $result;
    }

    public function getArticle($idArt)
    {
        $sql = 'SELECT idPost, titreArticle, pseudoAuteur, descriptifArticle, contenu, DATE_FORMAT(dateModification, "%d/%m/%Y %Hh%imin%ss") AS dateModification, imageArticle FROM articles WHERE idPost = ?';
        $result = $this->sql($sql, [$idArt]);
        return $result;
    }

}