<?php
namespace App\src\Controller;

use App\src\model\View;
use App\src\DAO\UsersDAO;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;

class BackController {

    private $view;
    private $usersDAO;
    private $articleDAO;
    private $commentDAO;

    public function __construct() {
        
        $this->view = new View();
        $this->usersDAO = new UsersDAO();
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
    }

    // Méthode pour l'inscription d'un nouveau membre
    public function inscription()
    {
        $errors = array();
        
        if(isset($_POST['inscription'])) {    
        
        $inscription = htmlspecialchars($_POST['inscription']);
        $pseudo = htmlspecialchars($_POST['pseudo']);    
        $email = htmlspecialchars($_POST['email']);    
        $password = htmlspecialchars($_POST['password']);    
        $password_confirm = htmlspecialchars($_POST['password_confirm']);
        
        $addPseudo = new UsersDAO();
        $addMail = new UsersDAO();
        $nbPseudo = $addPseudo->checkPseudo($pseudo);
        $nbMail = $addMail->checkEmail($email);
        var_dump($nbPseudo);
        var_dump($nbMail);
        
        if (!array_key_exists('pseudo', $_POST) || empty($pseudo) || $nbPseudo != null) {
            
            $errors ['pseudo'] = "Pseudo non renseigné ou déjà utilisé";
        }
        
        if (strlen($pseudo) < 7 ) {
            
            $errors ['pseudo'] = "Le pseudo doit comporter au moins sept caractères";   
        }
        
        if (preg_match("#[^a-z0-9]+#", $pseudo)) {
            
            $errors ['pseudo'] = "Le pseudo doit être composé seulement de lettres minuscules et d'au moins un chiffre";  
        }
        
        if (!array_key_exists('email', $_POST) || empty($email) || $nbMail != null || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            $errors ['email'] = "Adresse email non renseigné ou déjà utilisé";
        }
        
        if (!array_key_exists('password', $_POST) || empty($password) || empty($password_confirm)) {
            
            $errors ['password'] = "Veuillez entrer votre mot de passe";
        }
        
        if (preg_match("#[^a-zA-Z0-9]+#", $password)) {

            $errors ['password'] = "Votre mot de passe doit comporter au moins une majuscule, 
            une minuscule, et un chiffre";

        }

        if (strlen($password) < 7) {

            $errors ['password'] = "Votre mot de passe doit comporter au moins 7 caractères"; 
        }

        
        if ($password != $password_confirm) {
            
            $errors ['password'] = "Veuillez entrer deux mots de passe identiques";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ../public/index.php?action=inscription#formInscription');
            
        }
        
        // Envoi d'un mail pour activer le compte
        else {
            
            $newmember = new UsersDAO();
            $newmember->addUser($pseudo, $password, $email);

            $confirmkey = md5(microtime(TRUE)*100000);
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $addVerifKey = new UsersDAO();
            $addVerifKey->addKey($confirmkey, $pseudo);
            
            $header="MIME-Version: 1.0\r\n";
            $header.='From:"Blog de Steve Essama"<adouessono@steveessama.com>'."\n";
            $header.='Content-Type:text/html; charset="utf-8"'."\n";
            $header.='Content-Transfer-Encoding: 8bit';
            $message = '
            <html>
                <head>
                    <title>Activation du compte</title>
                    <meta charset="utf-8" />
                </head>
                <body>
                    <font color="#303030";>
                        <div align="center">
                            <table width="600px">
                                <tr>
                                    <td>
                                        <p align="center">
                                            Bonjour, vous vous êtes inscrit sur notre Blog. 
                                        </p>
                                        <p>
                                            Pour activer votre compte, 
                                            veuillez cliquer sur <a href = "http://localhost/project5/public/index.php?action=confirminscription&log='.urlencode($pseudo).'&cle='.urlencode($confirmkey).'">Activer mon compte.</a>
                                            
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <font size="2">
                                            Ceci est un email automatique, merci de ne pas y répondre
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </font>
                </body>
            </html>
            ';
           
            mail($email, "Activation du compte", $message, $header);
            
            $_SESSION['success'] = 1;   
            
            header('Location: ../public/index.php?action=inscription#formInscription');
            
        }
    } 
    
    else {
        
        $this->view->render('inscription');
    }
    
    }

    // Méthode pour l'activation d'un compte.
    public function countActivation() 
    {
        if (isset($_GET['log']) AND isset($_GET['cle']) AND !empty($_GET['log']) 
        AND !empty($_GET['cle'])) {
            
            $pseudo = htmlspecialchars($_GET['log']);
            $confirmkey = htmlspecialchars($_GET['cle']);

            $checkCount = new UsersDAO();
            $verifcount = $checkCount->checkConfirmed($pseudo);
            
            
            $verifKey = new UsersDAO();
            $verif = $verifKey->checkConfirmKey($pseudo);
            

            if($verifcount == 1) {
            $_SESSION['activation'] = 1;

            header('Location: ../public/index.php?action=connexion');
            
            }

            else {
            
                if($verif == $confirmkey) {
               
                    $confirm = new UsersDAO();
                    $confirm->confirmCount($pseudo);
                    
                    $_SESSION['confirmation'] = 1;
                
                    header('Location: ../public/index.php?action=connexion');
                }

                else {

                    $_SESSION['erroractivation'] = 1;
                    header('Location: ../public/index.php?action=connexion');
                }
            }
    
        }
    
        else {    
            
            $this->view->render('connexion');
        }
        
    }
    
    //Permet la connexion d'un membre
    public function connexion() { 

        $errors = array();
        
        if(isset($_POST['email']) AND isset($_POST['password'])) {

            sleep(1);    
            
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $checkLogin = new UsersDAO();
            $verifLogin = $checkLogin->checkEmail($email);

            $checkPass = new UsersDAO();
            $verifPass = $checkPass->checkPassword($email);
            
            if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $verifLogin == null ) {

                $errors ['email'] = "Adresse email non renseigné ou invalide";

            }

            if(empty($password) || $verifPass == false) {

                $errors ['password'] = "Mot de passe invalide ou non renseigné";

            }

            if(!empty($errors)) {
            
               $_SESSION['errors'] = $errors;
                header('Location:../public/index.php?action=connexion');

            }

            else {
            
                $_SESSION['success_connect'] = 1;
                $_SESSION['allowcomments'] = 1;
                header('Location:../public/index.php');
            
            }
        }  
        
        else {
                
                $this->view->render('connexion');
        }  
            
    }

    //Permet la récupération du mot de passe
    public function recoveryPass() {

        $errors = array();

        if (isset($_GET['section'])) {
        
            $section = htmlspecialchars($_GET['section']);   
        }
        
        else {
        
            $section=""; 
        }

        // On vérifie le mail de récupération du mot de passe.
        if(isset($_POST['recoverysubmit'])) {   
        
            $recoverysubmit = htmlspecialchars($_POST['recoverysubmit']); 
            
            $email = htmlspecialchars($_POST['email']);   
            
            $verifEmail = new UsersDAO();
            $nbEmail = $verifEmail->checkEmail($email);

            if (!array_key_exists('email', $_POST) || empty($email) 
            || $nbEmail == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                
                $errors ['email'] = "adresse email non renseigné ou inconnu du système";
                
            }

            if (!empty($errors)) {
               
                $_SESSION['errors'] = $errors;
                header('Location../public/index.php?action=recoverypass');
            }     

            // Si le mail est valide, on envoie mail de récupération du mot de passe.
            else {
                
                $_SESSION['email'] = $email;
                $recoveryPass = sha1(time());
                $_SESSION['recoverypass'] = $recoveryPass;
                
                $updateRecovery = new UsersDAO();
                $updateRecovery->recoveryCode($recoveryPass, $email);
                
                
                $header="MIME-Version: 1.0\r\n";
                $header.='From:"Blog de Steve Essama"<adouessono@steveessama.com>'."\n";
                $header.='Content-Type:text/html; charset="utf-8"'."\n";
                $header.='Content-Transfer-Encoding: 8bit';
                $message = '
                <html>
                    <head>
                        <title>Récupération de mot de passe</title>
                        <meta charset="utf-8" />
                    </head>
                    <body>
                        <font color="#303030";>
                            <div align="center">
                                <table width="600px">
                                    <tr>
                                        <td>
                                            <p align="center">
                                                Bonjour, vous avez indiqué avoir oublié votre mot de passe 
                                            </p>
                                            <p>
                                                <a href="http://localhost/project5/public/index.php?action=recoverypass&amp;section=updatepassword&code='.$recoveryPass.'" target="_blank">
                                                Cliquez ici pour réinitialiser votre mot de passe</a></br>
                                                A bientôt sur <a href="../public/index.php/">Notre blog!</a> 
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <font size="2">
                                                Ceci est un email automatique, merci de ne pas y répondre
                                            </font>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </font>
                    </body>
                </html>
                ';
               
                mail($email, "Récupération de mot de passe", $message, $header);
                $_SESSION['sendrecovery'] = 1;
                header('Location../public/index.php?action=recoverypass');
                
            }
        }
        
        // Permet l'ajout d'un nouveau mot de passe.
        if (isset($_POST['pass_submit'])) {
            
            sleep(1); 
            
            $email = $_SESSION['email'];
            
            $submitPass = htmlspecialchars($_POST['pass_submit']); 
            
            if (isset($_POST['newpass']) AND isset($_POST['confirmpass'])) {
                $newPass = htmlspecialchars($_POST['newpass']);
                $confirmPass = htmlspecialchars($_POST['confirmpass']);
                
                if (empty($newPass) || empty($confirmPass)) {
                    
                    $errors ['newpass'] = "Veuillez entrer votre nouveau mot de passe";
                }
                
                if (preg_match("#[^a-zA-Z0-9]+#", $newPass)) {

                    $errors ['newpass'] = "Votre mot de passe doit comporter au moins une majuscule, 
                    une minuscule, et un chiffre";
        
                }
        
                if (strlen($newPass) < 7) {
        
                    $errors ['newpass'] = "Votre mot de passe doit comporter au moins 7 caractères"; 
                }
        
                if ($newPass != $confirmPass) {

                    $errors ['newpass'] = "Veuillez entrer deux mots de passes identiques";
                    
                }
                
                if (!empty($errors)) {
                    
                    $_SESSION['errors'] = $errors;
                    header('Location: ../public/index.php?action=recoverypass&section=updatepassword');
                    
                }  
                
                else {
                    
                        $updatePass = new UsersDAO();
                        $updatePass->updatePass($newPass, $email);
                        
                        $_SESSION['success'] = 1;
                        header('Location: ../public/index.php?action=connexion');
                    }      
                
                }
            }
            
        else {

            $this->view->render('recoverypass', ['section' => $section]);

        }
        
    }

    //Permet de se déconnecter
    public function disconnect() 
    {
        if (isset($_POST['disconnect'])) {
        
            $disconnect = htmlspecialchars($_POST['disconnect']); 
            $_SESSION = array();
            session_destroy();
            
            header('Location: ../public/index.php');
        }
    }

    //Permet de se connecter à l'espace administrateur
    public function adminConnection() {

        $errors = array();
        
    if (isset($_POST['connectadmin'])) {
        
            sleep(1); 
            $connectAdmin = htmlspecialchars($_POST['connectadmin']); 
        
            $email = htmlspecialchars($_POST['email']);  
            $password = htmlspecialchars($_POST['password']);       
        
            if (!array_key_exists('email', $_POST) || empty($email)) {
            
                $errors ['email'] = "veuillez entrer votre adresse email";    
            }
        
            if (!array_key_exists('password', $_POST) || empty($password)) {
            
                $errors ['password'] = "veuillez entrer votre mot de passe";  
            }
        
            $connectAdmin = new UsersDAO();
            $nbEmail = $connectAdmin->checkAdminMail($email);
        
            if ($nbEmail == null) {
            
                $errors ['email'] = "cette email ne correspond à aucun administrateur ";
            }
        
            $connectAdmin = new UsersDAO();
            $verifPass = $connectAdmin ->checkAdminPass($email);
        
            if ($verifPass == false) {
                $errors ['password'] = "mauvais identifiant ou mot de passe";
            }

            if (!empty($errors)) {
               
                $_SESSION['errors'] = $errors;
                header('Location: ../public/index.php?action=adminconnection#form_admin');
            
            }  
        
            else {

                session_regenerate_id();
                
                $_SESSION['success_connect1'] = 1;
                $_SESSION['allowcomments'] = 1;
                header('Location: ../public/index.php?action=adminspace');
            } 
            
        }
        
        else {
        
            $this->view->render('adminconnection');
        }
    
    }

    // Renvoi la liste des articles à l'espace administrateur.
    public function adminSpace() 
    {   
        $news = $this->articleDAO->getArticles();
        $this->view->render('adminspace', ['news' => $news]);   
        
    }

    // Permet d'ajouter un article
    public function addArticle() 
    {
        $errors = array();
    
        if (isset($_POST['add_new'])) {


            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) 
            AND !empty($_POST['token'])) {
        
                if ($_SESSION['token'] == $_POST['token']) {    

                    $addpost = htmlspecialchars($_POST['add_new']);
                    $title = htmlspecialchars($_POST['post_title']);
                    $author = htmlspecialchars($_POST['post_author']);
                    $resume = htmlspecialchars($_POST['resume_post']);
                    $content = htmlspecialchars($_POST['content']);
            
                    if (!array_key_exists('post_author', $_POST) || empty($author)) {
            
                        $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
                    }
        
                    if (strlen($author > 30)) {
            
                        $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
                    }
        
                    if (!array_key_exists('post_title', $_POST) || empty($title)) {
            
                        $errors ['post_title'] = "veuillez saisir le titre de l'article";
                    }
        
                    if (strlen($title > 30)) {
            
                        $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
                    }
        
                    if (!array_key_exists('resume_post', $_POST) || empty($resume)) {
            
                        $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
                    }
        
                    if (strlen($resume > 200)) {
            
                        $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
                    }
        
                    if (!array_key_exists('content', $_POST) || empty($content)) {
            
                        $errors ['content'] = "veuillez saisir le contenu de votre article";
                    }
        
                    $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                    $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
        
                    if (empty($_FILES['image_post'])) {
                    
                        $errors ['image_post'] = "vous n'avez ajouté aucune image";
                
                    }
        
                    if ($_FILES['image_post']['error'] > 0) {
                    
                        $errors ['image_post'] = "Erreur lors du téléchargement de l'image";
                    }
        
                    if ($_FILES['image_post']['size'] > 2097152) {
            
                        $errors ['image_post'] = "l'image choisie est trop lourde";
                    }
        
                    $imagePost = $_FILES['image_post']['name'];
                    $ExtensionPresumee = explode('.', $imagePost);
                    $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
        
                    if ($ExtensionPresumee != 'jpg' && $ExtensionPresumee != 'jpeg') {
            
                        $errors ['image_post'] = "Veuillez ajouter une image au format Jpeg";
                    }
        
                    $imagePost = getimagesize($_FILES['image_post']['tmp_name']);
        
                    if ($imagePost['mime'] != $ListeExtension[$ExtensionPresumee]  && $imagePost['mime'] != $ListeExtensionIE[$ExtensionPresumee]) {
            
                        $errors ['image_post'] = "Veuillez ajouter une image au format jpeg"; 
                    }
        
                    if (!is_uploaded_file($_FILES['image_post']['tmp_name'])) {
            
                        $errors ['image_post'] = "aucune image téléchargé"; 
                    }
        
                    if (!empty($errors)) {
            
                        $_SESSION['errors'] = $errors;
                    
                        header('Location: ../public/index.php?action=addarticle');
                    
                    }   
        
                    else {
                
                        $imageSelected = imagecreatefromjpeg($_FILES['image_post']['tmp_name']);
                        $sizeImageSelected = getimagesize($_FILES['image_post']['tmp_name']);
                        $newImageWidth = 900;
                        $newImageHeight = 650;
                        $newImage = imagecreatetruecolor($newImageWidth , $newImageHeight) or die ("Erreur");
                        imagecopyresampled($newImage , $imageSelected, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $sizeImageSelected[0],$sizeImageSelected[1]);
                        imagedestroy($imageSelected);
                        $imageSelectedName = explode('.', $imagePost);
                        $_POST['image_post'] = time();
                        imagejpeg($newImage , '../public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee, 100); 
                        $_POST['MAX_FILE_SIZE'] = '../public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee;
                        $insertPost = new ArticleDAO();
                        $insertPost->addArticles($title, $author, $resume, $content, $_POST['MAX_FILE_SIZE'], $_POST['image_post']);
                        $_SESSION['insert_success'] = 1;
                         header('Location:../public/index.php?action=adminspace');

                    }    
                }      
            }
            
            else {

                header('Location:../public/index.php');
            }
        }
    
        else {

            $this->view->render('addpost');
        
        }
    
    }    
    
    // Permet de modifier un article.
    public function updateArticle($idArt) {

        $errors = array();

        $idPost = htmlspecialchars($_GET['id']);
        $singlepost = $this->articleDAO->getArticle($idArt);
    
        if (isset($_POST['add_new'])) {


            if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) 
            AND !empty($_POST['token'])) {
        
                if ($_SESSION['token'] == $_POST['token']) {   
        
                    $addnew = htmlspecialchars($_POST['add_new']);
                    $resume = htmlspecialchars($_POST['resume_post']);
                    $content = htmlspecialchars($_POST['content']);
                    $author = htmlspecialchars($_POST['post_author']);
                    $title = htmlspecialchars($_POST['post_title']);
            
                    if (!array_key_exists('post_author', $_POST) || empty($author)) {
            
                        $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
                    }
        
                    if (strlen($author > 30)) {
            
                        $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
                    }
        
                    if (!array_key_exists('post_title', $_POST) || empty($title)) {
            
                        $errors ['post_title'] = "veuillez saisir le titre de l'article";
                    }
        
                    if (strlen($title > 30)) {
            
                        $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
                    }
        
                    if (!array_key_exists('resume_post', $_POST) || empty($resume)) {
            
                        $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
                    }
        
                    if (strlen($resume > 200)) {
            
                        $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
                    }
        
                    if (!array_key_exists('content', $_POST) || empty($content)) {
            
                        $errors ['content'] = "veuillez saisir le contenu de votre article";
                    }
        
                    $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
                    $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');
        
                    if (empty($_FILES['image_post'])) {
            
                    $errors ['image_post'] = "vous n'avez ajouté aucune image";
                    }
        
                    if ($_FILES['image_post']['error'] > 0) {
            
                        $errors ['image_post'] = "Erreur lors du téléchargement de l'image";
                    }
        
                    if ($_FILES['image_post']['size'] > 2097152) {
            
                    $errors ['image_post'] = "l'image choisie est trop lourde";
                    
                    }
        
                    $imagePost = $_FILES['image_post']['name'];
                    $ExtensionPresumee = explode('.', $imagePost);
                    $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
        
                    if ($ExtensionPresumee != 'jpg' && $ExtensionPresumee != 'jpeg') {
            
                        $errors ['image_post'] = "Veuillez ajouter une image au format Jpeg";
                    }
        
                    $imagePost = getimagesize($_FILES['image_post']['tmp_name']);
        
                    if ($imagePost['mime'] != $ListeExtension[$ExtensionPresumee]  && $imagePost['mime'] != $ListeExtensionIE[$ExtensionPresumee]) {
            
                        $errors ['image_post'] = "Veuillez ajouter une image au format jpeg"; 
                    }
        
                    if (!is_uploaded_file($_FILES['image_post']['tmp_name'])) {
            
                        $errors ['image_post'] = "aucune image téléchargé"; 
                    }
        
                    if (!empty($errors)) {
            
                        $_SESSION['errors'] = $errors;
                    
                        header('Location: index.php?action=updatepost&id='.$_GET['id']);
                    
                    }   
        
                    else {
            
                        $imageSelected = imagecreatefromjpeg($_FILES['image_post']['tmp_name']);
                        $sizeImageSelected = getimagesize($_FILES['image_post']['tmp_name']);
                        $newImageWidth = 900;
                        $newImageHeight = 650;
                        $newImage = imagecreatetruecolor($newImageWidth , $newImageHeight);
                        imagecopyresampled($newImage , $imageSelected, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $sizeImageSelected[0],$sizeImageSelected[1]);
                        imagedestroy($imageSelected);
                        $imageSelectedName = explode('.', $imagePost);
                        $_POST['image_post'] = time();
                        imagejpeg($newImage , '../public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee, 100); 
                        $_POST['MAX_FILE_SIZE'] = '../public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee;
                        $updatePost = $this->articleDAO->updatePost($title, $author, $resume, $content, $_POST['MAX_FILE_SIZE'], $_POST['image_post'], $idPost);
                        $_SESSION['success_update'] = 1;
                        header('Location:index.php?action=adminspace');        
                    }
                }
            }
            
            else {

                header('Location:../public/index.php');
            }
        }    
        
        else {

            $this->view->render('updatepost', ['singlepost' => $singlepost]);
            
        }
    }

    // Permet de supprimer un article.
    public function deleteArticle() 
    {
        $idPost = htmlspecialchars($_GET['id']);
            
        if (isset($_SESSION['token']) AND isset($_POST['token']) 
        AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
            
            $_POST['token'] = htmlspecialchars($_POST['token']);
        
            if ($_SESSION['token'] == $_POST['token']) {
                
                $this->articleDAO->deletePost($idPost);
                $_SESSION['delete_post'] = 1;
                header('Location: ../public/index.php?action=adminspace');
    
            }

        }
    
        else {

            header('Location:../public/index.php');
        }
    }

    // Renvoi la liste des commentaires dans l'espace de gestion des commentaires.
    public function manageComment() 
    {
        $comment = $this->commentDAO->getComments();
        $this->view->render('managecomment', ['comment' => $comment]);
        
    }

    // Permet d'approuver les commentaires
    public function approveComment($idCommentaire) 
    {   
        $idCommentaire = htmlspecialchars($_GET['id']);

        if (isset($_SESSION['token']) AND isset($_POST['token']) 
        AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
            
            $_POST['token'] = htmlspecialchars($_POST['token']);
        
            if ($_SESSION['token'] == $_POST['token']) {
    
                $approve = $this->commentDAO->approveComment($idCommentaire);
                $_SESSION['comment_approved'] = 1;
                header('Location: ../public/index.php?action=managecomment');
            }
        }
        
        else {
            
            header('Location:../public/index.php');
        }
    }

    //Permet de supprimer les commentaires.
    public function deleteComment($idCommentaire) 
    {   
        $idCommentaire = htmlspecialchars($_GET['id']);
        
        if (isset($_SESSION['token']) AND isset($_POST['token']) 
        AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
            
            $_POST['token'] = htmlspecialchars($_POST['token']);
        
            if ($_SESSION['token'] == $_POST['token']) {
        
                $delete = $this->commentDAO->deleteComment($idCommentaire);
                $_SESSION['comment_delete'] = 1;
                header('Location: ../public/index.php?action=managecomment');
            
            }   
        }
        
        else {
            
            header('Location:../public/index.php');
        }
    }
}  
    
  
    
    