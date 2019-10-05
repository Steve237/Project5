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


    //permet de vérifier si le mot de passe de l'utilisateur renseigné est en bdd
    public function connect_User()
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT id_membre, password FROM membres WHERE pseudo = ?');
        $req->execute(array($_POST['pseudo']));
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        $check_user = new Users();
        $check_user->hydrate($resultat);
        $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
        return $isPasswordCorrect;
    }


    //permet de vérifier si le pseudo de l'utilisateur est en bdd
    
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


    
    
    //permet de vérifier si le pseudo de l'administrateur est en bdd    
    public function check_Admin()
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT COUNT(*) AS nb_pseudo FROM membres WHERE pseudo = ? AND admin = 1');
        $req->execute(array($_POST['pseudo']));
        $nb_pseudo = $req->fetch(PDO::FETCH_ASSOC);
        $verif_pseudo = new Users();
        $verif_pseudo->hydrate($nb_pseudo);
        return $nb_pseudo['nb_pseudo'];
    }


    public function update_recovery(Users $recovery) 
    {
    
        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE membres SET recovery_code=:recovery_code WHERE email=:email');
        $query->bindValue(':recovery_code', $recovery->recovery_code());
        $query->bindValue(':email', $recovery->email());

        $query->execute();

    }


    public function check_code($user_code)
    
    {
        $db = $this->dbConnect();
        $query = $db->prepare('SELECT COUNT(*) AS nb_code FROM membres WHERE recovery_code = ?');
        $query->execute(array($user_code));
    
        // On récupère l'objet
        $check_recovery_code = $query->fetch(PDO::FETCH_ASSOC);
        // On crée notre instance
        $user_recovery_code = new Recovery();
        // Puis on l'hydrate
        $user_recovery_code->hydrate($check_recovery_code);
        // On retourne l'objet
        return $check_recovery_code['nb_code'];

    }


    public function update_password(Users $user_pass) 
    {
    
        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE membres SET password=:password WHERE email=:email');
        $query->bindValue(':password', password_hash($_POST['new_pass'], PASSWORD_DEFAULT));
        $query->bindValue(':email', $user_pass->email());
        $query->execute();

    }


}






