<?php

require_once("Manager.php");

class NewsManager extends Manager
{
    //permet d'insérer un article
    public function add_post()
    {
        $db = $this->dbconnect();
        $q = $db->prepare('INSERT INTO articles(titre_article, pseudo_auteur, descriptif_article, contenu, date_modification, image_article, nom_image)             VALUES(:titre_article, :pseudo_auteur, :descriptif_article, :contenu, NOW(), :image_article, :nom_image)');
    
        $q->bindValue(':titre_article', $_POST['post_title']);
        $q->bindValue(':pseudo_auteur', $_POST['post_author']);
        $q->bindValue(':descriptif_article', $_POST['resume_post']);
        $q->bindValue(':contenu', $_POST['content']);
        $q->bindValue(':image_article', $_POST['MAX_FILE_SIZE']);
        $q->bindValue(':nom_image', $_POST['image_post']);
        
        $q->execute();
    }
    
    
    //permet de supprimer un article
    public function delete_new($newId)
    {
        
        $db = $this->dbconnect();
        $q = $db->prepare('DELETE FROM articles WHERE id_post = ?');
        $q->execute(array($newId));
    
    }
    
    
    //permet d'afficher la liste des articles
    public function getListPosts()
    {
        $db = $this->dbconnect();
        $query = $db->query('SELECT id_post, titre_article, descriptif_article, contenu, DATE_FORMAT(date_modification, "%d/%m/%Y %Hh%imin%ss") AS                 date_modification, image_article FROM articles');
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
    
    
    //permet d'afficher le contenu d'un article
    public function getPostById($postId)
    {
        $db  = $this->dbconnect();
        $query = $db->prepare('SELECT titre_article, pseudo_auteur, contenu, DATE_FORMAT(date_modification, "%d/%m/%Y %Hh%imin%ss") AS date_modification,         id_post, descriptif_article, image_article FROM articles WHERE id_post = ?');
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
