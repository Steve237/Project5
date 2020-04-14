<?php
namespace App\src\DAO;

use App\src\model\Comment;

class CommentDAO extends DAO 
{

public function getCommentsFromArticle($idArt) {

    $sql = 'SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS dateCreation FROM commentaires WHERE idPost = ?';
    $result = $this->sql($sql, [$idArt]);
    $comments = [];
        foreach ($result as $row) {
            $commentId = $row['idCommentaire'];
            $comments[$commentId] = $this->buildObject($row);
        }
        return $comments;
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
