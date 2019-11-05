<?php

class UsersManager extends Manager
{


    //permet d'ajouter un membre à la bdd    
    public function addUsers()
    {
        $db = $this->dbConnect();

        $q = $db->prepare('INSERT INTO membres(pseudo, password, email, dateInscription) VALUES(:pseudo, :password, :email, NOW())');

        $q->bindValue(':pseudo', $_POST['pseudo']);
        $q->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $q->bindValue(':email', $_POST['email']);
        $q->execute();

    }    

    //permet de vérifier si le pseudo existe en bdd    
    public function checkPseudo($pseudo)
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

    public function checkEmail($email)
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
    public function connectUser()
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT idMembre, password FROM membres WHERE pseudo = ?');
        $req->execute(array($_POST['pseudo']));
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        $check_user = new Users();
        $check_user->hydrate($resultat);
        $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
        return $isPasswordCorrect;
    }


    //permet de vérifier si le pseudo de l'utilisateur est en bdd

    public function checkMember()
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
    public function checkAdmin()
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT COUNT(*) AS nb_pseudo FROM membres WHERE pseudo = ? AND admin = 1');
        $req->execute(array($_POST['pseudo']));
        $nb_pseudo = $req->fetch(PDO::FETCH_ASSOC);
        $verif_pseudo = new Users();
        $verif_pseudo->hydrate($nb_pseudo);
        return $nb_pseudo['nb_pseudo'];
    }


    public function updateRecovery(Users $recovery) 
    {

        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE membres SET recoveryCode=:recoveryCode WHERE email=:email');
        $query->bindValue(':recoveryCode', $recovery->getRecoveryCode());
        $query->bindValue(':email', $recovery->getEmail());

        $query->execute();

    }


    public function checkCode($user_code)

    {
        $db = $this->dbConnect();
        $query = $db->prepare('SELECT COUNT(*) AS nb_code FROM membres WHERE recoveryCode = ?');
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


    public function updatePassword(Users $user_pass) 
    {

        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE membres SET password=:password WHERE email=:email');
        $query->bindValue(':password', password_hash($_POST['new_pass'], PASSWORD_DEFAULT));
        $query->bindValue(':email', $user_pass->getEmail());
        $query->execute();

    }


}






