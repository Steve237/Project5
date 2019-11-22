<?php

class NewsManager extends Manager
{
    /** 
     * permet d'ajouter un article
     */
    public function addPost()
    {
        $dtb = $this->dbconnect();
        $query = $dtb->prepare('INSERT INTO articles(titreArticle, pseudoAuteur, descriptifArticle, contenu, dateModification, imageArticle, nomImage)                   VALUES(:titreArticle, :pseudoAuteur, :descriptifArticle, :contenu, NOW(), :imageArticle, :nomImage)');
        $query->bindValue(':titreArticle', $_POST['post_title']);
        $query->bindValue(':pseudoAuteur', $_POST['post_author']);
        $query->bindValue(':descriptifArticle', $_POST['resume_post']);
        $query->bindValue(':contenu', $_POST['content']);
        $query->bindValue(':imageArticle', $_POST['MAX_FILE_SIZE']);
        $query->bindValue(':nomImage', $_POST['image_post']);
        $query->execute();
    }


    /** 
     * permet de supprimer un article
     */
    public function deleteNew($newId)
    {

        $dtb = $this->dbconnect();
        $query = $dtb->prepare('DELETE FROM articles WHERE idPost = ?');
        $query->execute(array($newId));

    }
    
    /** 
     * permet de modifier un article
     */
    public function updateNew() 
    {

        $dtb = $this->dbConnect();
        $query = $dtb->prepare('UPDATE articles SET pseudoAuteur=:pseudoAuteur, titreArticle=:titreArticle, descriptifArticle=:descriptifArticle,                       contenu=:contenu, dateModification=NOW(), imageArticle=:imageArticle, nomImage=:nomImage WHERE idPost=:idPost');
        $query->bindValue(':pseudoAuteur', $_POST['post_author']);
        $query->bindValue(':titreArticle', $_POST['post_title']);
        $query->bindValue(':descriptifArticle', $_POST['resume_post']);
        $query->bindValue(':contenu', $_POST['content']);
        $query->bindValue(':imageArticle', $_POST['MAX_FILE_SIZE']);
        $query->bindValue(':nomImage', $_POST['image_post']);
        $query->bindValue(':idPost', $_GET['id']);
        $query->execute();
    }


    /** 
     * permet d'afficher la liste des articles
     */
    public function getListPosts()
    {
        $dtb = $this->dbconnect();
        $query = $dtb->query('SELECT idPost, titreArticle, descriptifArticle, contenu, DATE_FORMAT(dateModification, "%d/%m/%Y %Hh%imin%ss") AS                         dateModification, imageArticle FROM articles');
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


    /** 
     * permet d'afficher le contenu d'un article
     */
    public function getPostById($postId)
    {
        $dtb  = $this->dbconnect();
        $query = $dtb->prepare('SELECT titreArticle, pseudoAuteur, contenu, DATE_FORMAT(dateModification, "%d/%m/%Y %Hh%imin%ss") AS                                     dateModification, idPost, descriptifArticle, imageArticle FROM articles WHERE idPost = ?');
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
