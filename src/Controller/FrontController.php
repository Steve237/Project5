<?php
namespace App\src\Controller;

use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\model\View;

class FrontController {

    private $articleDAO;
    private $commentDAO;
    private $view;

    public function __construct() 
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }

    //Permet l'affichage de la page d'accueil.
    public function home() 
    {
        $this->view->render('homepage');
    
    }

    //Permet l'affichage de la liste des articles.
    public function articles() 
    {
        $article = $this->articleDAO->getArticles();
        $this->view->render('posts', ['article' => $article]);
    }

    /**
     * Permet l'envoi d'un mail via formulaire de contact.
     */
    public function sendMail() 
    {
        $errors = array(); // on crée une vérif de champs
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        
        if (!$name || empty($name)) {
        
            $errors ['name'] = "vous n'avez pas renseigné votre nom";
        }
    
        if (!$email || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
            $errors ['email'] = "vous n'avez pas renseigné votre email";
        }
    
        if (!$message || empty($message)) {
        
            $errors ['message'] = "vous n'avez pas renseigné votre message";
        }
        
        //On check les infos transmises lors de la validation
        if (!empty($errors)) { 
           
            $_SESSION['errors'] = $errors;//on stocke les erreurs
        
            header('Location: ../public/index.php#formContact');
        
        } else {
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'FROM:' . $name;
            $to = "espiritokamer237@gmail.com";
            $subject = 'Message envoyé par ' . $name .' - <i>' . $email .'</i>';
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
                    <td>'. $message .'</td>
                </tr>
            </table>
            ';
            mail($to, $subject, $message_content, $headers);
            header('Location: index.php#formContact');
            
            $_SESSION['success'] = 1;
        }
    }

    //Permet l'affichage d'un article en particulier.
    public function single($idArt) 
    {
        $idArt = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        $singlepost = $this->articleDAO->getArticle($idArt);
        $comment = $this->commentDAO->getCommentsFromArticle($idArt);
        
        $submitComment = filter_input(INPUT_POST, 'submit_comment', FILTER_SANITIZE_STRING);
        
        if (isset($submitComment) {
            
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
            $userComment = filter_input(INPUT_POST, 'user_comment', FILTER_SANITIZE_STRING);
            
            if (!$pseudo || empty($pseudo)) {
                
                $errors ['pseudo'] = "Veuillez entrer un pseudo";   
            }
            
            if (!$userComment || empty($userComment)) {
                
                $errors ['user_comment'] = "Veuillez entrer un commentaire";   
            }
            
            if (!empty($errors)) { 
                
                $_SESSION['errors'] = $errors;
                header('Location: ../public/index.php?action=article&id='.$idArt.'');
            
            } else {        
                
                $insertComment = $this->commentDAO->addComment($idArt, $pseudo, $userComment);
                
                $_SESSION['send_comment'] = 1;
                header('Location: ../public/index.php?action=article&id='.$idArt.'');
            }
        
        } else {

            $this->view->render('single', [
                'singlepost' => $singlepost,
                'comment' => $comment
            ]);

        }    
    }

}