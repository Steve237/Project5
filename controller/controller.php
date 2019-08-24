<?php

session_start();

// Chargement des classes
require_once ABSOLUTE_PATH."/model/NewsManager.php";
require_once ABSOLUTE_PATH."/model/news.php";

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

if(!array_key_exists('message', $_POST) || $_POST['message'] == '') 
  {
  $errors ['message'] = "vous n'avez pas renseigné votre message";
  }

//On check les infos transmises lors de la validation
if(!empty($errors))
  { // si erreur on renvoie vers la page précédente
  $_SESSION['errors'] = $errors;//on stocke les erreurs
  $_SESSION['inputs'] = $_POST;
  header('Location: index.php#formContact');
  }
    
else
  {
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
-

function listPosts()
{
    $news_list = new NewsManager(); // Création d'un objet
    $posts = $news_list->getListPosts(); //Appel d'une fonction de cet objet
    
    require ABSOLUTE_PATH.'/view/view_listposts.php';

}

function post()
{
    $post = new NewsManager();
    

    $news = $post->getPostById($_GET['id']);
    

    require ABSOLUTE_PATH.'/view/view_post.php';
}



function homePage() 
{
    
require ABSOLUTE_PATH.'/view/view_homepage.php';    
    
}


