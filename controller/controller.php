<?php

session_start();

// Chargement des classes
require_once ABSOLUTE_PATH."/model/PostManager.php";
require_once ABSOLUTE_PATH."/model/InscriptionManager.php";
require_once ABSOLUTE_PATH."/model/connectionManager.php";



function sendMail() 
{
// $errors = [];
  $errors = array(); // on crée une vérif de champs
if(!array_key_exists('name', $_POST) || $_POST['name'] == '') 
{// on verifie l'existence du champ et d'un contenu
  $errors ['name'] = "vous n'avez pas renseigné votre nom";
  }
if(!array_key_exists('email', $_POST) || $_POST['email'] == '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
{// on verifie existence de la clé
  $errors ['mail'] = "vous n'avez pas renseigné votre email";
  }
if(!array_key_exists('message', $_POST) || $_POST['message'] == '') {
  $errors ['message'] = "vous n'avez pas renseigné votre message";
  }

//On check les infos transmises lors de la validation
  if(!empty($errors)){ // si erreur on renvoie vers la page précédente
  $_SESSION['errors'] = $errors;//on stocke les erreurs
  $_SESSION['inputs'] = $_POST;
  header('Location: index.php#formContact');
  }
    
else{
  $_SESSION['success'] = 1;
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $headers .= 'FROM:' . htmlspecialchars($_POST['email']);
  $to = 'essonoadou@gmail.com';
  $subject = 'Message envoyé par ' . htmlspecialchars($_POST['name']) .' - <i>' . htmlspecialchars($_POST['email']) .'</i>';
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
  header('Location: index.php#formContact');
  }
}

function listPosts()
{
    $postManager = new PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); //Appel d'une fonction de cet objet
    
    require ABSOLUTE_PATH.'/view/view_listposts.php';

}

function post()
{
    $postManager = new PostManager();
    

    $post = $postManager->getPost($_GET['id']);
    

    require ABSOLUTE_PATH.'/view/view_post.php';
}


function Inscription()
{

if(isset($_POST['inscription']))
{    
   
$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);    
$_POST['email'] = htmlspecialchars($_POST['email']);    
$_POST['password'] = htmlspecialchars($_POST['password']);    
$_POST['password_confirm'] = htmlspecialchars($_POST['password_confirm']);  
    
    
$errors = array();

$inscription = new InscriptionManager();
$nb_pseudo = $inscription->verif_pseudo($_POST['pseudo']);

$inscription = new InscriptionManager();
$nb_email = $inscription->verif_email($_POST['pseudo']);
    
    
if(!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo']) || $nb_pseudo['nb_pseudo'] > 0)
{
    
$errors ['pseudo'] = "pseudo non renseigné ou déjà utilisé";
}

if(!array_key_exists('email', $_POST) || empty($_POST['email']) || $nb_email['nb_email'] > 0)
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

$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$inscription = new InscriptionManager();
$affectedLines = $inscription->add_member($_POST['pseudo'], $pass_hash, $_POST['email']);
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

$connect = new connectionManager();
$resultat_pass = $connect->connect_Member();
        
if (!$resultat_pass)
{
        
$errors ['password'] = "mauvais identifiant ou mot de passe";
    
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


function homePage() 
{
    
require ABSOLUTE_PATH.'/view/view_homepage.php';    
    
}


