<?php
namespace App\src\DAO;

use App\src\model\Comment;
use PDO;


class CommentDAO extends DAO 
{

    public function getCommentsFromArticle($idArt) 
    {

    $sql = 'SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, 
    DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS dateCreation FROM commentaires 
    WHERE validation = 1 AND idPost = ?';
    $result = $this->sql($sql, [$idArt]);
    $comments = [];
        foreach ($result as $row) {
            $commentId = $row['idCommentaire'];
            $comments[$commentId] = $this->buildObject($row);
        }
        return $comments;
    }

    public function getComments() 
    {

        $sql = 'SELECT commentaires.idCommentaire as idcom, commentaires.pseudoAuteur 
        as pseudocomment, commentaires.contenuCommentaire as commentcontent, 
        commentaires.dateCreation as datecomment, articles.titreArticle as newtitle
        FROM commentaires INNER JOIN articles ON commentaires.idPost = articles.idPost';
        $result = $this->sql($sql);
        $comments = $result->fetchAll(PDO::FETCH_OBJ);
        return $comments;
        

    }


    public function approveComment($idCommentaire) {

        $sql = 'UPDATE commentaires set validation = 1 WHERE idCommentaire = ?';
        $this->sql($sql, [$idCommentaire]);

    }

    
    public function deleteComment($idCommentaire) {

        $sql = 'DELETE FROM commentaires WHERE idCommentaire = ? ';
        $this->sql($sql, [$idCommentaire]);

    }
    
    private function buildObject(array $row)
    {
        $comment = new Comment();
        $comment->setIdCommentaire($row['idCommentaire']);
        $comment->setIdPost($row['idPost']);
        $comment->setPseudoAuteur($row['pseudoAuteur']);
        $comment->setContenuCommentaire($row['contenuCommentaire']);
        $comment->setDateCreation($row['dateCreation']);
        return $comment;
    }
}
