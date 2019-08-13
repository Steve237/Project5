<?php

require_once("Manager.php");

class connectionManager extends Manager
{
//fonction charger de trouver le mot de passe du pseudo renseigné dans la base de données en vue de le comparer au mot de passe renseigné par le client.
public function connect_Member()
{
$db = $this->dbConnect();

$req = $db->prepare('SELECT id_membre, password FROM membres WHERE pseudo = :pseudo');
$req->execute(array('pseudo' => $_POST['pseudo']));
$resultat = $req->fetch();
return $resultat;
}

}