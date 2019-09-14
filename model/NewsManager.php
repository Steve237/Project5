<?php

require_once("Manager.php");

class NewsManager extends Manager
{

    public function add(News $news)
    {
        $db = $this->dbconnect();
        $q = $db->prepare('INSERT INTO articles(id_article, titre_article, pseudo_auteur, descriptif_article, contenu, date_modification, image_article)                 VALUES(:id_article, :titre_article, :pseudo_auteur, :descriptif_article, :contenu, :date_modification, :image_article)');
    
        $q->bindValue(':id_article', $news->id_article());
        $q->bindValue(':titre_article', $news->titre_article());
        $q->bindValue(':titre_article', $news->titre_article());
        $q->bindValue(':pseudo_auteur', $news->pseudo_auteur());
        $q->bindValue(':descriptif_article', $news->descriptif_article());
        $q->bindValue(':contenu', $news->contenu());
        $q->bindValue(':date_modification', $news->date_modification());
        $q->bindValue(':image_article', $news->image_article());
        $q->execute();
    }

  
    public function getListPosts()
    {
        $db = $this->dbconnect();
        $query = $db->query('SELECT id_post, titre_article, descriptif_article, DATE_FORMAT(date_modification, "%d/%m/%Y %Hh%imin%ss") AS date_modification,             image_article FROM articles');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);        
        // instanciation de notre tableau d'objets
        $listPost = array();
        foreach ($results as $donnees) 
        {
            // on instancie notre objet
            $post = new News();
            // on hydrate notre objet avec les valeurs récupérées en bdd
            $post->hydrate($donnees);
            // puis on le met dans notre tableau
            $listPost[] = $post;            
        }
        return $listPost;
    }
    
    
    
    public function getPostById($postId)
    {
        $db  = $this->dbconnect();
        $query = $db->prepare('SELECT titre_article, pseudo_auteur, contenu, DATE_FORMAT(date_modification, "%d/%m/%Y %Hh%imin%ss") AS date_modification, id_post, descriptif_article, image_article FROM articles WHERE id_post = ?');
        $query->execute(array($postId));
        
     // On récupère l'objet
        $resultDb = $query->fetch(PDO::FETCH_ASSOC);
        // On crée notre instance
        $post = new News();
        // Puis on l'hydrate
        $post->hydrate($resultDb);
        // On retourne l'objet
        return $post;
    }
    
}
