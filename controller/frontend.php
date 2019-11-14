<?php

function sendMail() 
{
    
    $errors = array(); // on crée une vérif de champs
    
    $_POST['name'] = htmlspecialchars($_POST['name']);
    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['message'] = htmlspecialchars($_POST['message']);
    
    if (!array_key_exists('name', $_POST) || empty($_POST['name'])) {
        
        $errors ['name'] = "vous n'avez pas renseigné votre nom";
    }
    
    if (!array_key_exists('email', $_POST) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        
        $errors ['email'] = "vous n'avez pas renseigné votre email";
    }
    
    if (!array_key_exists('message', $_POST) || empty($_POST['message'])) {
        
        $errors ['message'] = "vous n'avez pas renseigné votre message";
    }
    //On check les infos transmises lors de la validation
    if (!empty($errors)) { 
        
        $_SESSION['errors'] = $errors;//on stocke les erreurs
        
        header('Location: index.php#formContact');
        
    }
    
    else {
        
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

    $newsList = new NewsManager(); // Création d'un objet
    $posts = $newsList->getListPosts(); //Appel d'une fonction de cet objet
    require ABSOLUTE_PATH.'/view/view_listposts.php';
}

function post()
{

    $post = new NewsManager();
    $post = new NewsManager();

    $news = $post->getPostById($_GET['id']);
    $commentManager = new CommentManager();
    $listComments = $commentManager->getListCommentById($_GET['id']);
    
    if (isset($_POST['submit_comment'])) {
        
        $_POST['submit_comment'] = htmlspecialchars($_POST['submit_comment']);
       
        if (!array_key_exists('success_connect', $_SESSION)) {
            $errors ['sucess_connect'] = "Veuillez vous connecter pour poster un commentaire";   
        }
        
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
        $_POST['user_comment'] = htmlspecialchars($_POST['user_comment']);
        
        if (!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo'])) {
            $errors ['pseudo'] = "Veuillez entrer un pseudo";   
        }
        
        if (!array_key_exists('user_comment', $_POST) || empty($_POST['user_comment'])) {
            $errors ['user_comment'] = "Veuillez entrer un commentaire";   
        }
        
        if (!empty($errors)) { 
            
            $_SESSION['errors'] = $errors;
        }
        
        else {        
            
            $_SESSION['success'] = 1;
            $insertComment = new CommentManager();
            $insertComment->addComment();
        }
    }
    
    require ABSOLUTE_PATH.'/view/view_post.php';
}

function homePage() 
{

    require ABSOLUTE_PATH.'/view/view_homepage.php';    

}
