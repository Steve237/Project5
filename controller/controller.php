<?php

session_start();

// Chargement des classes
require_once('./model/PostManager.php');
require_once('./model/CommentManager.php');


function sendMail() 
{
// $errors = [];
  $errors = array(); // on crée une vérif de champs
if(!array_key_exists('name', $_POST) || $_POST['name'] == '') {// on verifie l'existence du champ et d'un contenu
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
  header('Location: ./view/view_homepage.php#contactForm');
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
  header('Location: ./view/view_homepage.php#contactForm');
  }
}

function listPosts()
{
    $postManager = new PostManager(); // Création d'un objet
    $posts = $postManager->getPosts(); //Appel d'une fonction de cet objet
    
    require './view/view_listposts.php';

}

function post()
{
    $postManager = new PostManager();
    $commentManager = new CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require './view/view_post.php';
}




















