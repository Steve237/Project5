<?php

class CommentManager extends Manager
{

    //permet d'afficher la liste des commentaires
    public function getListComment()
    {
        $db = $this->dbconnect();
        $query = $db->query('SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS                       dateCreation, validation FROM commentaires');
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
        $query = $db->prepare('SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS                     dateCreation, validation FROM commentaires WHERE idPost = ? AND validation = 1  ');
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
    public function addComment()
    {

        $db = $this->dbconnect();
        $q = $db->prepare('INSERT INTO commentaires(idPost, contenuCommentaire, pseudoAuteur, dateCreation) 
        VALUES(:idPost, :contenuCommentaire, :pseudoAuteur, NOW())');

        $q->bindValue(':idPost', $_GET['id']);
        $q->bindValue(':pseudoAuteur', $_POST['pseudo']);
        $q->bindValue(':contenuCommentaire', $_POST['user_comment']);
        $q->execute();
    }


    //permet de valider un commentaire
    public function commentValidation() 
    {

        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE commentaires SET validation=:validation WHERE idCommentaire=:idCommentaire');
        $query->bindValue(':validation', '1');
        $query->bindValue(':idCommentaire', $_GET['id']);
        $query->execute();

    }



    //permet de supprimer un commentaire
    public function deleteComment($commentId)
    {

        $db = $this->dbconnect();
        $q = $db->prepare('DELETE FROM commentaires WHERE idCommentaire = ?');
        $q->execute(array($commentId));

    }

}