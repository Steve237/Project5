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
        
        $inscription = filter_input(INPUT_POST, 'inscription', FILTER_SANITIZE_STRING);
        
        if (isset($inscription) || !empty($inscription)) {    

        $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);  
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);   
        $password_confirm = filter_input(INPUT_POST, 'password_confirm', FILTER_SANITIZE_STRING); 
        
        $addPseudo = new UsersDAO();
        $addMail = new UsersDAO();
        $nbPseudo = $addPseudo->checkPseudo($pseudo);
        $nbMail = $addMail->checkEmail($email);
        
        if (!$pseudo || empty($pseudo) || $nbPseudo != null) {
            
            $errors ['pseudo'] = "Pseudo non renseigné ou déjà utilisé";
        }
        
        if (strlen($pseudo) < 7 ) {
            
            $errors ['pseudo'] = "Le pseudo doit comporter au moins sept caractères";   
        }
        
        if (preg_match("#[^a-z0-9]+#", $pseudo)) {
            
            $errors ['pseudo'] = "Le pseudo doit être composé seulement de lettres minuscules et d'au moins un chiffre";  
        }
        
        if (!$email  || empty($email) || $nbMail != null || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            $errors ['email'] = "Adresse email non renseigné ou déjà utilisé";
        }
        
        if (!$password  || empty($password) || empty($password_confirm)) {
            
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
            
        } else {
            
            $newmember = new UsersDAO();
            $newmember->addUser($pseudo, $password, $email);

            $confirmkey = md5(microtime(TRUE)*100000);
            $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING); 
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
    
    } else {
        
        $this->view->render('inscription');
    }
    
    }

    // Méthode pour l'activation d'un compte.
    public function countActivation() 
    {   
        $pseudo = filter_input(INPUT_GET, 'log', FILTER_SANITIZE_STRING); 
        $confirmkey = filter_input(INPUT_GET, 'cle', FILTER_SANITIZE_STRING); 
        
        if (isset($pseudo) AND isset($confirmkey) AND !empty($pseudo) 
        AND !empty($confirmkey)) {

            //permet de vérifier si le compte est déjà activé
            $checkCount = new UsersDAO();
            $verifcount = $checkCount->checkConfirmed($pseudo);
            
            //permet de vérifier si la clef d'activation existe en base de données
            $verifKey = new UsersDAO();
            $verif = $verifKey->checkConfirmKey($pseudo);
            
            if ($verifcount == 1) {
            $_SESSION['activation'] = 1;

            header('Location: ../public/index.php?action=connexion');
            
            } else {
            
                if ($verif == $confirmkey) {
               
                    $confirm = new UsersDAO();
                    $confirm->confirmCount($pseudo);
                    
                    $_SESSION['confirmation'] = 1;
                
                    header('Location: ../public/index.php?action=connexion');
                
                } else {

                    $_SESSION['erroractivation'] = 1;
                    header('Location: ../public/index.php?action=connexion');
                }
            }
    
        } else {    
            
            $this->view->render('connexion');
        }
        
    }
    
    //Permet la connexion d'un membre
    public function connexion() { 

        $errors = array();
        
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); 
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); 
        if (isset($email) AND isset($password) AND !empty($email) AND !empty($password)) {

            sleep(1);    
            
            $checkLogin = new UsersDAO();
            $verifLogin = $checkLogin->checkEmail($email);

            $checkPass = new UsersDAO();
            $verifPass = $checkPass->checkPassword($email);
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $verifLogin == null ) {

                $errors ['email'] = "Adresse email non renseigné ou invalide";

            }

            if (empty($password) || $verifPass == false) {

                $errors ['password'] = "Mot de passe invalide ou non renseigné";

            }

            if (!empty($errors)) {
            
               $_SESSION['errors'] = $errors;
                header('Location:../public/index.php?action=connexion');

            } else {
            
                $_SESSION['success_connect'] = 1;
                $_SESSION['allowcomments'] = 1;
                header('Location:../public/index.php');
            
            }
        
        }  else {
                
                $this->view->render('connexion');
        }  
            
    }

    //Permet la récupération du mot de passe
    public function recoveryPass() {

        $errors = array();

        // On vérifie le mail de récupération du mot de passe.
        $recoverysubmit = filter_input(INPUT_POST, 'recoverysubmit', FILTER_SANITIZE_STRING);
        if (isset($recoverysubmit)) {   
         
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);   
            
            $verifEmail = new UsersDAO();
            $nbEmail = $verifEmail->checkEmail($email);

            if (!$email  || empty($email) 
            || $nbEmail == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                
                $errors ['email'] = "adresse email non renseigné ou inconnu du système";
                
            }

            if (!empty($errors)) {
               
                $_SESSION['errors'] = $errors;
                header('Location:../public/index.php?action=recoverypass');
            
            } else {
                
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
                                                <a href="http://localhost/project5/public/index.php?action=updatecode&amp;code='.urlencode($recoveryPass).'" target="_blank">
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
                header('Location:../public/index.php?action=recoverypass');
                
            } 
        
        } else {

            $this->view->render('recoverypass');
        }
    }

    //permet de vérifier la validité du code de recuperation du mot de passe
    public function verifRecoveryCode() {

        $errors = array();
        
        $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
        $checkCode = new UsersDAO();
        $codeChecking = $checkCode->checkRecoveryCode($code);
        
        if (!$code || empty($code) || $codeChecking == null) {

            header('Location: ../public/index.php');

        } else {

            header('Location: ../public/index.php?action=confirmpass');
        }
    
    }

    //permet la mise à jour du mot de passe
    public function confirmPass() {

            
            $submitPass = filter_input(INPUT_POST, 'pass_submit', FILTER_SANITIZE_STRING);

            if (isset($submitPass)) {
            
                sleep(1); 
            
                $email = $_SESSION['email'];
                   
                $newPass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_STRING);
                $confirmPass = filter_input(INPUT_POST, 'confirmpass', FILTER_SANITIZE_STRING);
                
                if (isset($newPass) AND isset($confirmPass)) {
                
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
                        header('Location: ../public/index.php?action=confirmpass');
                    
                    } else {
                    
                        $updatePass = new UsersDAO();
                        $updatePass->updatePass($newPass, $email);
                        
                        $_SESSION['success'] = 1;
                        header('Location: ../public/index.php?action=connexion');
                    }      
                
                }
            
            } 
            
            $this->view->render('updatepass'); 
        } 
    
    //Permet de se déconnecter
    public function disconnect() 
    {
        $disconnect = filter_input(INPUT_POST, 'disconnect', FILTER_SANITIZE_STRING);

        if (isset($disconnect)) {
        
            $_SESSION = array();
            session_destroy();
            
            header('Location: ../public/index.php');
        }
    }

    //Permet de se connecter à l'espace administrateur
    public function adminConnection() {

        sleep(1);    
        $errors = array();
    
        $connectAdmin = filter_input(INPUT_POST, 'connectadmin', FILTER_SANITIZE_STRING);
         
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);  
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (isset($email) AND isset($password) AND !empty($email) AND !empty($password)) {
            
            if (!$email || empty($email)) {
            
                $errors ['email'] = "veuillez entrer votre adresse email";    
            }
        
            if (!$password  || empty($password)) {
            
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
            
            }  else {

                session_regenerate_id();
                
                $_SESSION['success_connect1'] = 1;
                $_SESSION['allowcomments'] = 1;
                header('Location: ../public/index.php?action=adminspace');
            } 
        
        } else {

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
        
        $addNew = filter_input(INPUT_POST, 'add_new', FILTER_SANITIZE_STRING);
        if (isset($addNew)) {

            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
            
            if (isset($_SESSION['token']) AND isset($token) AND !empty($_SESSION['token']) 
            AND !empty($token)) {
        
                if ($_SESSION['token'] == $token) {    

                    $title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    $author = filter_input(INPUT_POST, 'post_author', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    $resume = filter_input(INPUT_POST, 'resume_post', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            
                    if (!$author || empty($author)) {
            
                        $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
                    }
        
                    if (strlen($author > 30)) {
            
                        $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
                    }
        
                    if (!$title || empty($title)) {
            
                        $errors ['post_title'] = "veuillez saisir le titre de l'article";
                    }
        
                    if (strlen($title > 30)) {
            
                        $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
                    }
        
                    if (!$resume || empty($resume)) {
            
                        $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
                    }
        
                    if (strlen($resume > 200)) {
            
                        $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
                    }
        
                    if (!$content || empty($content)) {
            
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
        
                    if (!is_uploaded_file($_FILES['image_post']['tmp_name'])) {
            
                        $errors ['image_post'] = "aucune image téléchargé"; 
                    }
        
                    if (!empty($errors)) {
            
                        $_SESSION['errors'] = $errors;
                    
                        header('Location:../public/index.php?action=addarticle');
                    
                    } else {
                
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
            
            } else {

                header('Location:../public/index.php');
            }
        
        } else {

            $this->view->render('addpost');
        
        }
    
    }    
    
    // Permet de modifier un article.
    public function updateArticle($idArt) {

        $errors = array();

        $idPost = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $singlepost = $this->articleDAO->getArticle($idArt);
        
        $addNew = filter_input(INPUT_POST, 'add_new', FILTER_SANITIZE_STRING);

        if (isset($addNew)) {

            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

            if (isset($_SESSION['token']) AND isset($token) AND !empty($_SESSION['token']) 
            AND !empty($token)) {
        
                if ($_SESSION['token'] == $_POST['token']) {   
        
                    $title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    $author = filter_input(INPUT_POST, 'post_author', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    $resume = filter_input(INPUT_POST, 'resume_post', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
                    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            
                    if (!$author || empty($author)) {
            
                        $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
                    }
        
                    if (strlen($author > 30)) {
            
                        $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
                    }
        
                    if (!$title || empty($title)) {
            
                        $errors ['post_title'] = "veuillez saisir le titre de l'article";
                    }
        
                    if (strlen($title > 30)) {
            
                        $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
                    }
        
                    if (!$resume || empty($resume)) {
            
                        $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
                    }
        
                    if (strlen($resume > 200)) {
            
                        $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
                    }
        
                    if (!$content || empty($content)) {
            
                        $errors ['content'] = "veuillez saisir le contenu de votre article";
                    }

                    if (!is_uploaded_file($_FILES['image_post']['tmp_name'])) {

                        if (!empty($errors)) {
            
                            $_SESSION['errors'] = $errors;
                            header('Location: index.php?action=updatepost&id='.$_GET['id']);
                        } 
            
                        else {

                            $updateNew = $this->articleDAO->updateNew($title, $author, $resume, $content, $idPost);
                            $_SESSION['success_update'] = 1;
                            header('Location:index.php?action=adminspace');  
                        } 
                    
                    } else if (is_uploaded_file($_FILES['image_post']['tmp_name'])) {

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
                        
                        } else if (!empty($errors)) {
            
                            $_SESSION['errors'] = $errors;
                        
                            header('Location: index.php?action=updatepost&id='.$_GET['id']);

                        } else {
            
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
            
            } else {

                header('Location:../public/index.php');
            }
        
        } else {

            $this->view->render('updatepost', ['singlepost' => $singlepost]);
            
        }
    }

    // Permet de supprimer un article.
    public function deleteArticle() 
    {
        $idPost = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
            
        if (isset($_SESSION['token']) AND isset($token) 
        AND !empty($_SESSION['token']) AND !empty($token)) {
        
            if ($_SESSION['token'] == $token) {
                
                $this->articleDAO->deletePost($idPost);
                $_SESSION['delete_post'] = 1;
                header('Location: ../public/index.php?action=adminspace');
    
            }

        } else {

            header('Location:../public/index.php');
        }
    }

    // Renvoi la liste des commentaires dans l'espace de gestion des commentaires.
    public function manageComment() 
    {   
        // Renvoi la liste des commentaires validés
        $comment = $this->commentDAO->getComments();

        // Renvoi la liste des commentaires non validés
        $commentNoValidated = $this->commentDAO->getCommentsNoValidated();

        $this->view->render('managecomment', ['comment' => $comment, 'commentNoValidated' => $commentNoValidated]);
        
    }

    // Permet d'approuver les commentaires
    public function approveComment($idCommentaire) 
    {   
        $idCommentaire = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        
        if (isset($_SESSION['token']) AND isset($token) 
        AND !empty($_SESSION['token']) AND !empty($token)) {
        
            if ($_SESSION['token'] == $token) {
    
                $approve = $this->commentDAO->approveComment($idCommentaire);
                $_SESSION['comment_approved'] = 1;
                
                header('Location: ../public/index.php?action=managecomment');
            }
        
        } else {
            
            header('Location:../public/index.php');
        }
    }

    //Permet de supprimer les commentaires.
    public function deleteComment($idCommentaire) 
    {   
        $idCommentaire = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        
        if (isset($_SESSION['token']) AND isset($token) 
        AND !empty($_SESSION['token']) AND !empty($token)) {
        
            if ($_SESSION['token'] == $token) {
        
                $delete = $this->commentDAO->deleteComment($idCommentaire);
                $_SESSION['comment_delete'] = 1;
                header('Location: ../public/index.php?action=managecomment');
            
            }   
        
        } else {
            
            header('Location:../public/index.php');
        }
    }
}  
    
  
    
    
