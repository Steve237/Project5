<?php

require_once("Manager.php");

class CommentManager extends Manager

{

public function getComments($id_post)
{
$db = $this->dbconnect();
$comments = $db->prepare('SELECT id_commentaire, id_article, pseudo_auteur_commentaire, contenu_commentaire, date_creation_commentaire FROM commentaires 
WHERE id_article = ?');
$comments->execute(array($id_post));
return $comments;
}


}