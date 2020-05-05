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
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
    
        if (!array_key_exists('name', $_POST) || empty($name)) {
        
            $errors ['name'] = "vous n'avez pas renseigné votre nom";
        }
    
        if (!array_key_exists('email', $_POST) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
            $errors ['email'] = "vous n'avez pas renseigné votre email";
        }
    
        if (!array_key_exists('message', $_POST) || empty($message)) {
        
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
        $idArt = htmlspecialchars($_GET['id']);
        
        $singlepost = $this->articleDAO->getArticle($idArt);
        $comment = $this->commentDAO->getCommentsFromArticle($idArt);
        
        if (isset($_POST['submit_comment'])) {
        
            $submitComment = htmlspecialchars($_POST['submit_comment']);
            
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $userComment = htmlspecialchars($_POST['user_comment']);
            
            if (!array_key_exists('pseudo', $_POST) || empty($pseudo)) {
                
                $errors ['pseudo'] = "Veuillez entrer un pseudo";   
            }
            
            if (!array_key_exists('user_comment', $_POST) || empty($userComment)) {
                
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