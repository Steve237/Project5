<?php

require_once("Manager.php");

class connectionManager extends Manager
{

public function connect_Member()
{
$db = $this->dbConnect();

$req = $db->prepare('SELECT id_membre, password FROM membres WHERE pseudo = :pseudo');
$req->execute(array('pseudo' => $_POST['pseudo']));
$resultat = $req->fetch();
return $resultat;
}

}