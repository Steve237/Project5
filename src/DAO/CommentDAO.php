<?php
namespace App\src\DAO;

class CommentDAO extends DAO 
{

public function getCommentsFromArticle($idArt) {

    $sql = 'SELECT idCommentaire, idPost, pseudoAuteur, contenuCommentaire, DATE_FORMAT(dateCreation, "%d/%m/%Y %Hh%imin%ss") AS dateCreation FROM commentaires WHERE idPost = ?';
    $result = $this->sql($sql, [$idArt]);
    return $result;

}

}