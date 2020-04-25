<?php
namespace App\src\DAO;

use App\src\model\Users;

class UsersDAO extends DAO 
{

    /**
     * @param mixed $pseudo
     * @param mixed $password
     * @param mixed $email
     * 
     * Permet d'ajouter un utilisateur.
     */
    public function addUser($pseudo, $password, $email)
    {
        $sql = 'INSERT INTO membres (pseudo, password, email, dateInscription) VALUES (?, ?, ?, NOW())';
        $this->sql($sql, [$pseudo, password_hash($password, PASSWORD_DEFAULT), $email]);

    }

    /**
     * @param mixed $pseudo
     * 
     * Permet de vérifier si un pseudo existe en base de données.
     */
    public function checkPseudo($pseudo) {

        $sql = 'SELECT pseudo FROM membres WHERE pseudo = ?';
        $result = $this->sql($sql, [$pseudo]);

        return $result->fetch();
    }


    /**
     * @param mixed $email
     * 
     * Permet de vérifier l'existence d'un email en base de données.
     */
    public function checkEmail($email) {

        $sql = 'SELECT email FROM membres WHERE email = ?';
        $result2 = $this->sql($sql, [$email]);
    
        return $result2->fetch();
    }

    /**
     * @param mixed $email
     * 
     * Permet de vérifier si un mot de passe existe en base de données.
     */
    public function checkPassword($email) {

        $sql = 'SELECT password FROM membres WHERE email = ?';
        $result3 = $this->sql($sql, [$email]);
        $checkpass = $result3->fetch();
        $checkuserpass = new Users();
        $checkuserpass->hydrate($checkpass);
        $isPasswordCorrect = password_verify($_POST['password'], $checkpass['password']);
        return $isPasswordCorrect;
    }

    /**
     * @param mixed $confirmkey
     * @param mixed $pseudo
     * 
     * Permet d'ajouter une clef en base de données lors de l'inscription.
     */
    public function addKey($confirmkey, $pseudo)
    {
        $sql = 'UPDATE membres SET confirmKey = ? WHERE pseudo = ?';
        $this->sql($sql, [$confirmkey, $pseudo]);
    }

    
    /**
     * @param mixed $pseudo
     * 
     * Permet de vérifier si un compte a été activé.
     */
    public function checkConfirmed($pseudo)
    {

        $sql = 'SELECT confirmed FROM membres WHERE pseudo = ?';
        $check = $this->sql($sql, [$pseudo]);
        $row = $check->fetch();
        $confirmed = $row['confirmed'];
        return $confirmed;
    }

    /**
     * @param mixed $pseudo
     * 
     * Permet de vérifier si une clef d'activation est en base de données.
     */
    public function checkConfirmKey($pseudo)
    {
        $sql = 'SELECT confirmKey FROM membres WHERE pseudo = ?';
        $checkConfirm = $this->sql($sql, [$pseudo]);
        $row = $checkConfirm->fetch();
        $returnKey = $row['confirmKey'];
        return $returnKey;
    }


    /**
     * @param mixed $pseudo
     * 
     * Permet d'activer un compte.
     */
    public function confirmCount($pseudo) 
    {
        $sql = 'UPDATE membres SET confirmed = 1 WHERE pseudo = ?';
        $this->sql($sql, [$pseudo]);
    }

    /**
     * @param mixed $recoverypass
     * @param mixed $email
     * 
     * Permet d'ajouter la clef de récupération du mot de passe en base de données.
     */
    public function recoveryCode($recoverypass, $email) 
    {
        $sql = 'UPDATE membres SET recoveryCode = ? WHERE email = ?';
        $this->sql($sql, [$recoverypass, $email]);
    }

    /**
     * @param mixed $password
     * @param mixed $email
     * 
     * Permet d'ajouter un nouveau mot de passe.
     */
    public function updatePass($password, $email) 
    {
        $sql = 'UPDATE membres SET password = ? WHERE email = ?';
        $this->sql($sql, [password_hash($password, PASSWORD_DEFAULT), $email]);
    }

    /**
     * @param mixed $email
     * 
     * Permet de vérifier l'existence du mail de l'administrateur en base de données.
     */
    public function checkAdminMail($email) 
    {   
        $sql = 'SELECT email FROM membres WHERE email = ? AND admin = 1';
        $result2 = $this->sql($sql, [$email]);
        return $result2->fetch();
    }


    /**
     * @param mixed $email
     * 
     * Permet de vérifier l'existence du mot de passe en base de données.
     */
    public function checkAdminPass($email) 
    {

        $sql = 'SELECT password FROM membres WHERE email = ? AND admin = 1';
        $resultpass = $this->sql($sql, [$email]);
        $checkpassword = $resultpass->fetch();
        $checkadminpass = new Users();
        $checkadminpass->hydrate($checkpassword);
        $isPasswordCorrect = password_verify($_POST['password'], $checkpassword['password']);
        return $isPasswordCorrect;
    }

}