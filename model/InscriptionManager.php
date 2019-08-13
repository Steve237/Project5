<?php

require_once("Manager.php");

class InscriptionManager extends Manager
{

public function add_member($pseudo, $password, $email)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO membres(pseudo, password, email, date_inscription) VALUES(:pseudo, :password, :email, NOW())');
        $affectedLines = $req->execute(array('pseudo' => $pseudo, 'password' => $password, 'email' => $email));
        return $affectedLines;
        
}


public function verif_pseudo($pseudo)
{
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT COUNT(*) AS nb_pseudo FROM membres WHERE pseudo = ?');
    $req->execute(array($pseudo));
    $nb_pseudo = $req->fetch();
    return $nb_pseudo['nb_pseudo'];
}

public function verif_email($pseudo)
{
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT COUNT(*) AS nb_email FROM membres WHERE pseudo = ?');
    $req->execute(array($pseudo));
    $nb_email = $req->fetch();
    return $nb_email['nb_email'];
}

}
