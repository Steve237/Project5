<?php

class RecoveryManager extends Manager
{  
    //permet de savoir si l'email est déjà en base de données

    public function check_recovery_usermail($email)

    {
        $db = $this->dbConnect();

        $query = $db->prepare('SELECT COUNT(*) AS nb_email FROM 
        recovery WHERE email = ?');
        $query->execute(array($email));

        // On récupère l'objet
        $check_recovery_mail = $query->fetch(PDO::FETCH_ASSOC);
        // On crée notre instance
        $user_recovery_mail = new Recovery();
        // Puis on l'hydrate
        $user_recovery_mail->hydrate($check_recovery_mail);
        // On retourne l'objet
        return $check_recovery_mail['nb_email'];
    }


    public function update_recovery(Recovery $recovery) 
    {

        $db = $this->dbConnect();
        $query = $db->prepare('UPDATE membres SET recovery_code=:recovery_code WHERE email=:email');
        $query->bindValue(':recovery_code', $recovery->recovery_code());
        $query->bindValue(':email', $recovery->email());
        $query->execute();

    }


    public function add_recovery(Recovery $recovery)
    {
        $db = $this->dbConnect();
        $query = $db->prepare('INSERT INTO recovery SET email = :email, recovery_code = :recovery_code');
        $query->bindValue(':email', $recovery->email());
        $query->bindValue(':recovery_code', $recovery->recovery_code());
        $query->execute();
    }


    public function check_code($user_code)

    {
        $db = $this->dbConnect();
        $query = $db->prepare('SELECT COUNT(*) AS nb_code FROM recovery WHERE recovery_code = ?');
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


    public function delete_recovery_data($code)
    {
        $db = $this->dbConnect();
        $query = $db->prepare('DELETE FROM recovery WHERE recovery_code = ?');
        $query->execute(array($code));



    }



}





