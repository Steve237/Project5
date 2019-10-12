<?php

require_once("Manager.php");

class CommentManager extends Manager
{

    //permet d'afficher la liste des commentaires
    public function getListComment()
    {
        $db = $this->dbconnect();
        $query = $db->query('SELECT id_commentaire, id_post, pseudo_auteur, contenu_commentaire, DATE_FORMAT(date_creation, "%d/%m/%Y %Hh%imin%ss") AS               date_creation, validation FROM commentaires');
        $query->execute();
        
        
        $comments = $query->fetchAll(PDO::FETCH_ASSOC);        
        
        $listComments = array();
        foreach ($comments as $donnees) 
        {
            // on instancie notre objet
            $comments = new Comments();
            // on hydrate notre objet avec les valeurs récupérées en bdd
            $comments->hydrate($donnees);
            // puis on le met dans notre tableau
            $listComments[] = $comments;            
        }
        return $listComments;
    }
 
    //permet d'afficher la liste des commentaires
    public function getListCommentById($idPost)
    {
         $db  = $this->dbconnect();
        $query = $db->prepare('SELECT id_commentaire, id_post, pseudo_auteur, contenu_commentaire, DATE_FORMAT(date_creation, "%d/%m/%Y %Hh%imin%ss") AS             date_creation, validation FROM commentaires WHERE id_post = ? AND validation = 1');
        $query->execute(array($idPost));
        
        
        $comments = $query->fetchAll(PDO::FETCH_ASSOC);        
        
        $listComments = array();
        foreach ($comments as $donnees) 
        {
            // on instancie notre objet
            $comments = new Comments();
            // on hydrate notre objet avec les valeurs récupérées en bdd
            $comments->hydrate($donnees);
            // puis on le met dans notre tableau
            $listComments[] = $comments;            
        }
        return $listComments;
    }
    
    
    
    
    //permet d'ajouter un commentaire
    public function add_comment()
    {
     
        $db = $this->dbconnect();
        $q = $db->prepare('INSERT INTO commentaires(id_post, contenu_commentaire, pseudo_auteur, date_creation) 
        VALUES(:id_post, :contenu_commentaire, :pseudo_auteur, NOW())');
    
        $q->bindValue(':id_post', $_GET['id']);
        $q->bindValue(':pseudo_auteur', $_POST['pseudo']);
        $q->bindValue(':contenu_commentaire', $_POST['user_comment']);
        
        $q->execute();
    }


    //permet de valider un commentaire
    public function comment_Validation() 
    {
    
        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE commentaires SET validation=:validation WHERE id_commentaire=:id_commentaire');
        $query->bindValue(':validation', '1');
        $query->bindValue(':id_commentaire', $_GET['id']);
        $query->execute();
    
    }
    


    //permet de supprimer un commentaire
    public function delete_Comment($commentId)
    {
        
        $db = $this->dbconnect();
        $q = $db->prepare('DELETE FROM commentaires WHERE id_commentaire = ?');
        $q->execute(array($commentId));
    
    }

}