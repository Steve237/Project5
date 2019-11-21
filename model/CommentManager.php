<?php

class CommentManager extends Manager
{

    /**
     * permet d'afficher la liste des commentaires
     */
    public function getListComment()
    {
        $dtb = $this->dbconnect();
        $query = $dtb->query('SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS                       dateCreation, validation FROM commentaires');
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

    /** 
     * permet d'afficher la liste des commentaires sur chaque article
     */
    public function getListCommentById($idPost)
    {
        $dtb  = $this->dbconnect();
        $query = $dtb->prepare('SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS                     dateCreation, validation FROM commentaires WHERE idPost = ? AND validation = 1  ');
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

    /** 
     * permet l'ajout d'un commentaire
     */
    public function addComment()
    {

        $dtb = $this->dbconnect();
        $query = $dtb->prepare('INSERT INTO commentaires(idPost, contenuCommentaire, pseudoAuteur, dateCreation) 
        VALUES(:idPost, :contenuCommentaire, :pseudoAuteur, NOW())');

        $query->bindValue(':idPost', $_GET['id']);
        $query->bindValue(':pseudoAuteur', $_POST['pseudo']);
        $query->bindValue(':contenuCommentaire', $_POST['user_comment']);
        $query->execute();
    }


    /** 
     * permet d'approuver un commentaire
     */
    public function commentValidation() 
    {

        $dtb = $this->dbConnect();
        $query = $dtb->prepare('UPDATE commentaires SET validation=:validation WHERE idCommentaire=:idCommentaire');
        $query->bindValue(':validation', '1');
        $query->bindValue(':idCommentaire', $_GET['id']);
        $query->execute();

    }



    /** 
     * permet de supprimer un commentaire
     */
    public function deleteComment($commentId)
    {

        $dtb = $this->dbconnect();
        $query = $dtb->prepare('DELETE FROM commentaires WHERE idCommentaire = ?');
        $query->execute(array($commentId));

    }

}