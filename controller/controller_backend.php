<?php

require_once ABSOLUTE_PATH."/model/UsersManager.php";
require_once ABSOLUTE_PATH."/model/users.php";


function Inscription()
{

if(isset($_POST['inscription']))
{    
   
$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);    
$_POST['email'] = htmlspecialchars($_POST['email']);    
$_POST['password'] = htmlspecialchars($_POST['password']);    
$_POST['password_confirm'] = htmlspecialchars($_POST['password_confirm']);  
    
    
$errors = array();

$inscription = new UsersManager();
$nb_pseudo = $inscription->check_pseudo($_POST['pseudo']);

$connection = new UsersManager();
$nb_email = $connection->check_email($_POST['email']);
    
    
if(!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo']) || $nb_pseudo > 0)
{
    
$errors ['pseudo'] = "pseudo non renseigné ou déjà utilisé";
}

if(!array_key_exists('email', $_POST) || empty($_POST['email']) || $nb_email > 0 )
{
    
$errors ['email'] = "adresse email non renseigné ou déjà utilisé";
}

if(!array_key_exists('password', $_POST) || empty($_POST['password']) || !array_key_exists('password_confirm', $_POST) || empty($_POST['password_confirm']))      {
    
$errors ['password'] = "veuillez entrer votre mot de passe";
}

if($_POST['password'] != $_POST['password_confirm'])
{

$errors ['password'] = "veuillez entrer deux mots de passe identiques";

}

if(!empty($errors))
{
$_SESSION['errors'] = $errors;
header('Location: index.php?action=inscription#formInscription');

}

else
{
$_SESSION['success'] = 1;    


$inscription = new UsersManager();
$inscription->add_Users();
header('Location: index.php?action=inscription#formInscription');
}
} 
   else
   {

       require ABSOLUTE_PATH.'/view/view_inscription.php';

   }
}


function Connection()
{

    if(isset($_POST['connection']))

{

if(!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo'])) 
{
    
$errors ['pseudo'] = "veuillez entrer votre pseudo";    

}

if(!array_key_exists('password', $_POST) || empty($_POST['password']))  
{
  $errors ['password'] = "veuillez entrer votre mot de passe";  
}


$connect = new UsersManager();
$nb_pseudo = $connect->check_Member();
        
if(!$nb_pseudo)

{

    $errors ['pseudo'] = "pseudo inconnu";
    
}


$connect = new UsersManager();
$verif_pass = $connect ->connect_User();
    
if($verif_pass == false)
{
        
$errors ['password'] = "mauvais identifiant ou mot de passe";

}
        
if($verif_pass == true)
{
        
$_SESSION['success'] = 1;

$_SESSION['pseudo'] = $_POST["pseudo"];

header('Location: index.php?action=connection#formInscription');
    
}
        
if(!empty($errors))
{
$_SESSION['errors'] = $errors;
header('Location: index.php?action=connection#formInscription');

}    
    
    }
  
    
else
   {

       require ABSOLUTE_PATH.'/view/view_connection.php';

   }

}

function recovery()
{
$user_mail = htmlspecialchars($_POST['user_mail']);    

if(isset $_POST['user_mail'] && !empty($_POST['user_mail']))
{    
    
$connection = new UsersManager();
$nb_email = $connection->check_email($_POST['user_mail']);
    
    
if(!array_key_exists('user_mail', $_POST) || empty($_POST['user_mail']) || $nb_email > 0 )
{
    
$errors ['user_mail'] = "adresse email non renseigné ou déjà utilisé";
}
    

if(!empty($errors))
{
$_SESSION['errors'] = $errors;
header('Location: index.php?action=connection#form_recovery');

}        
    

else
{   
  $_SESSION['user_mail'] = $user_mail;
  $_SESSION['recovery_password'] = $recovery_password;
  $_SESSION['success'] = 1;
    
  $recovery_code = "";
  for($i=0; $i < 8; $i++)
  {   
    $recovery_code .= mt_rand(0, 9);
  }
    
  $_SESSION['recovery_code'] = $recovery_code;  
  
  $recovery = new RecoveryManager();
  $recovery_mail_exist = $recovery->$check_recovery_usermail($_POST['email']);   
  
  if($recovery_mail_exist > 0)
  {
    
  }
    
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $headers .= 'FROM:' . htmlspecialchars($_POST['email']);
  $to = 'essonoadou@gmail.com';
  $subject = 'Message envoyé par ' . htmlspecialchars($_POST['email']) .'</i>';
  $message_content = '
  <table>
  <tr>
  <td><b>Emetteur du message:</b></td>
  </tr>
  <tr>
  <td>'. $subject . '</td>
  </tr>
  <tr>
  <td><b>Contenu du message:</b></td>
  </tr>
  <tr>
  <td>'. htmlspecialchars($_POST['message']) .'</td>
  </tr>
  </table>
  ';
  mail($to, $subject, $message_content, $headers);
  header('Location: index.php?action=connection#form_recovery');

}
}
    
}


