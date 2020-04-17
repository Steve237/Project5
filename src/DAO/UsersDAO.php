<?php
namespace App\src\DAO;

use App\src\model\Users;

class UsersDAO extends DAO 
{

public function addUser($pseudo, $password, $email)
{
    $sql = 'INSERT INTO membres (pseudo, password, email, dateInscription) VALUES (?, ?, ?, NOW())';
    $this->sql($sql, [$pseudo, password_hash($password, PASSWORD_DEFAULT), $email]);

}

public function checkPseudo($pseudo) {

    $sql = 'SELECT pseudo FROM membres WHERE pseudo = ?';
    $result = $this->sql($sql, [$pseudo]);

    return $result->fetch();
}


public function checkEmail($email) {

    $sql = 'SELECT email FROM membres WHERE email = ?';
    $result2 = $this->sql($sql, [$email]);
    
    return $result2->fetch();
}

public function addKey($confirmkey, $pseudo)
{
    $sql = 'UPDATE membres SET confirmKey = ? WHERE pseudo = ?';
    $this->sql($sql, [$confirmkey, $pseudo]);
}

public function checkConfirmed($pseudo)
{

    $sql = 'SELECT confirmed FROM membres WHERE pseudo = ?';
    $check = $this->sql($sql, [$pseudo]);
    $row = $check->fetch();
    $confirmed = $row['confirmed'];
    return $confirmed;
}

public function checkConfirmKey($pseudo)
{
    $sql = 'SELECT confirmKey FROM membres WHERE pseudo = ?';
    $checkConfirmKey = $this->sql($sql, [$pseudo]);
    return $checkConfirmKey->fetch();
}


public function confirmCount($pseudo) 
{
    $sql = 'UPDATE membres SET confirmed = 1 WHERE pseudo = ?';
    $this->sql($sql, [$pseudo]);
}

}