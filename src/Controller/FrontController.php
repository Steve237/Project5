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

    public function home() 
    {

        $this->view->render('homepage');

    }

    public function articles() 
    {

        $article = $this->articleDAO->getArticles();
        $this->view->render('posts', ['article' => $article]);
    }

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
            session_start();
            $_SESSION['errors'] = $errors;//on stocke les erreurs
        
            header('Location: ../public/index.php#formContact');
        
        }
    
        else {
            session_start();
            $_SESSION['success'] = 1;
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'FROM:' . htmlspecialchars($_POST['name']);
            $to = "espiritokamer237@gmail.com";
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


    public function single($idArt) 
    {

        $singlepost = $this->articleDAO->getArticle($idArt);
        $comment = $this->commentDAO->getCommentsFromArticle($idArt);
        $this->view->render('single', [
            'singlepost' => $singlepost,
            'comment' => $comment
        ]);
    }

}