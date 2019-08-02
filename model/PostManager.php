<?php

require_once('model/Manager.php');

class PostManager extends Manager

{
public function getPosts()
{

$db = $this->dbconnect();    

$data = $db->query('SELECT id_article, titre_article, descriptif_article, date_modification, image_liste_article FROM articles');

return $data;

}


public function getPost($id_post)
{
$db = $this->dbconnect();
$req = $db->prepare('SELECT titre_article, pseudo_auteur, contenu, date_modification, id_article, descriptif_article, image_article FROM articles WHERE id_article = ?');
$req->execute(array($id_post));
$post = $req->fetch();
return $post;
}

}







