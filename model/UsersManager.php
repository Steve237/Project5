<?php

require_once("Manager.php");

class UsersManager extends Manager
{


//permet d'ajouter un membre à la bdd    
public function add_Users()

{
    $db = $this->dbConnect();

    $q = $db->prepare('INSERT INTO membres(pseudo, password, email, date_inscription) VALUES(:pseudo, :password, :email, NOW())');

    $q->bindValue(':pseudo', $_POST['pseudo']);
    $q->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
    $q->bindValue(':email', $_POST['email']);
    $q->execute();

}    
   
//permet de vérifier si le pseudo existe en bdd    
public function check_pseudo($pseudo)
{
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT COUNT(*) AS nb_pseudo FROM membres WHERE pseudo = ?');
    $query->execute(array($pseudo));
    
    // On récupère l'objet
    $check_data = $query->fetch(PDO::FETCH_ASSOC);
        // On crée notre instance
    $check_login = new Users();
        // Puis on l'hydrate
    $check_login->hydrate($check_data);
        // On retourne l'objet
    return $check_data['nb_pseudo'];
}

//permet de vérifier si l'email existe en bdd

public function check_email($email)
{
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT COUNT(*) AS nb_email FROM membres WHERE email = ?');
    $query->execute(array($email));
    
    // On récupère l'objet
    $check_data = $query->fetch(PDO::FETCH_ASSOC);
        // On crée notre instance
    $check_usermail = new Users();
        // Puis on l'hydrate
    $check_usermail->hydrate($check_data);
        // On retourne l'objet
    return $check_data['nb_email'];
}


//permet de vérifier si le mot de passe renseigné est en bdd
public function connect_User()
{
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT id_membre, password FROM membres WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $_POST['pseudo']));
    $resultat = $req->fetch(PDO::FETCH_ASSOC);
    $check_user = new Users();
    $check_user->hydrate($resultat);

    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
    return $isPasswordCorrect;
}


public function check_Member()
{
    $db = $this->dbConnect();

    $req = $db->prepare('SELECT COUNT(*) AS nb_pseudo FROM membres WHERE pseudo = ?');
    $req->execute(array($_POST['pseudo']));
    $nb_pseudo = $req->fetch(PDO::FETCH_ASSOC);
    $verif_pseudo = new Users();
    $verif_pseudo->hydrate($nb_pseudo);
    return $nb_pseudo['nb_pseudo'];
}

}






