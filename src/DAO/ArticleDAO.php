<?php
namespace App\src\DAO;

use App\src\model\Article;

class ArticleDAO extends DAO
{
    
    public function getArticles()
    {
       
        $sql = 'SELECT idPost, titreArticle, pseudoAuteur, descriptifArticle, contenu, DATE_FORMAT(dateModification, "%d/%m/%Y %Hh%imin%ss") AS dateModification, imageArticle FROM articles';
        
        $result = $this->sql($sql);
        
        $articles = [];
        foreach ($result as $row) {
            $articleId = $row['idPost'];
            $articles[$articleId] = $this->buildObject($row);
        }
        return $articles;
    }

    public function getArticle($idArt)
    {
        $sql = 'SELECT idPost, titreArticle, pseudoAuteur, descriptifArticle, contenu, DATE_FORMAT(dateModification, "%d/%m/%Y %Hh%imin%ss") AS dateModification, imageArticle FROM articles WHERE idPost = ?';
        $result = $this->sql($sql, [$idArt]);
        
        $row = $result->fetch();
        
        return $this->buildObject($row);
    }

    public function addArticles($title, $author, $resume, $content, $image, $imagename)
    {
        $sql = 'INSERT INTO articles (titreArticle, pseudoAuteur, descriptifArticle, contenu, dateModification, imageArticle, nomImage) VALUES (?, ?, ?, ?, NOW(), ?, ?)';
        $this->sql($sql, [$title, $author, $resume, $content, $image, $imagename]);

    }

    
    public function updatePost($title, $author, $resume, $content, $image, $imagename, $idPost)
    {

        $sql = 'UPDATE articles SET titreArticle = ?, pseudoAuteur = ?, descriptifArticle = ?, contenu = ?, dateModification = NOW(), imageArticle = ?, nomImage = ? WHERE idPost = ?';
        $this->sql($sql, [$title, $author, $resume, $content, $image, $imagename, $idPost]);

    }
    
    
    public function deletePost($idPost) {

        $sql = 'DELETE FROM articles WHERE idPost = ? ';
        $this->sql($sql, [$idPost]);

    }
    
    private function buildObject(array $row)
    {
        $article = new Article();
        $article->setIdPost($row['idPost']);
        $article->setTitreArticle($row['titreArticle']);
        $article->setContenu($row['contenu']);
        $article->setDateModification($row['dateModification']);
        $article->setImageArticle($row['imageArticle']);
        $article->setDescriptifArticle($row['descriptifArticle']);
        $article->setPseudoAuteur($row['pseudoAuteur']);
        return $article;
    }

}