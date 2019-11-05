<?php

function inscription()
{
   
    
    if(isset($_POST['inscription'])) {    
        
        $_POST['inscription'] = htmlspecialchars($_POST['inscription']);
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);    
        $_POST['email'] = htmlspecialchars($_POST['email']);    
        $_POST['password'] = htmlspecialchars($_POST['password']);    
        $_POST['password_confirm'] = htmlspecialchars($_POST['password_confirm']);  
        $errors = array();
        $inscription = new UsersManager();
        $nbPseudo = $inscription->checkPseudo($_POST['pseudo']);
        $connection = new UsersManager();
        $nbEmail = $connection->checkEmail($_POST['email']);
        
        if (!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo']) || $nbPseudo > 0) {
            $errors ['pseudo'] = "pseudo non renseigné ou déjà utilisé";
        }
        
        if (strlen($_POST['pseudo']) < 7 ) {
            $errors ['pseudo'] = "le pseudo doit comporter au moins sept caractères";   
        }
        
        if (preg_match("#[^a-z0-9]+#", $_POST['pseudo'])) {
            $errors ['pseudo'] = "Le pseudo doit être composé seulement de lettres minuscules et d'au moins un chiffre";  
        }
        
        if (!array_key_exists('email', $_POST) || empty($_POST['email']) || $nbEmail > 0 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors ['email'] = "adresse email non renseigné ou déjà utilisé";
        }
        
        if (!array_key_exists('password', $_POST) || empty($_POST['password']) || !array_key_exists('password_confirm', $_POST) ||                                       empty($_POST['password_confirm'])) {
            $errors ['password'] = "veuillez entrer votre mot de passe";
        }
        
        if ($_POST['password'] != $_POST['password_confirm']) {
            $errors ['password'] = "veuillez entrer deux mots de passe identiques";
        }
        
        if (!empty($errors)) {
            
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=inscription#formInscription');
        }
        
        else {
            
            $_SESSION['success'] = 1;    
            $inscription = new UsersManager();
            $inscription->addUsers();
            header('Location: index.php?action=inscription#formInscription');
        }
    } 
    else {
        require ABSOLUTE_PATH.'/view/view_inscription.php';
    }
}

function connection()
{
    
    if (isset($_POST['connection'])) {
        
        sleep(1); 
        
        $_POST['connection'] = htmlspecialchars($_POST['connection']);
        
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);  
        $_POST['password'] = htmlspecialchars($_POST['password']);       
        
        if (!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo'])) {
            $errors ['pseudo'] = "veuillez entrer votre pseudo";    
        }
        
        if (!array_key_exists('password', $_POST) || empty($_POST['password'])) {
            
            $errors ['password'] = "veuillez entrer votre mot de passe";  
        }
        
        $connect = new UsersManager();
        $nbPseudo = $connect->checkMember();
        
        if (!$nbPseudo) {
            $errors ['pseudo'] = "pseudo inconnu";
        }
        
        $connect = new UsersManager();
        $verifPass = $connect ->connectUser();
        
        if ($verifPass == false) {
            $errors ['password'] = "mauvais identifiant ou mot de passe";
        }
        
        if ($verifPass == true) {
            $_SESSION['success_connect'] = "Vous êtes connecté";
            $_SESSION['pseudo'] = $_POST["pseudo"];
            header('Location: index.php');
        }
        
        if (array_key_exists("success-connect", $_SESSION)) {
            header('Location: index.php');
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=connection#formInscription');
        }    
    }
    
    else {
        require ABSOLUTE_PATH.'/view/view_connection.php';
    }
}

function recovery()
{
   
    if (isset($_GET['section'])) {
        
        $section = htmlspecialchars($_GET['section']);   
    }
    else {
        
        $section=""; 
    }
    
    if (isset($_POST['recovery_submit'])) {   
        
        $_POST['recovery_submit'] = htmlspecialchars($_POST['recovery_submit']); 
        
        $email = htmlspecialchars($_POST['email']);   
        $errors = array();
        $verifEmail = new UsersManager();
        $nbEmail = $verifEmail->checkEmail($_POST['email']);
        
        if (!array_key_exists('email', $_POST) || empty($_POST['email']) || !$nbEmail || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors ['email'] = "adresse email non renseigné ou inconnu du système";
            header('Location: index.php?action=recovery_pass');
        }
        
        if ($nbEmail > 0) {
            $_SESSION['email'] = $email;
            $recoveryPass = sha1(time());
            $_SESSION['recovery_pass'] = $recovery_pass;
            $verifEmail = new UsersManager();
            $nbEmail = $verifEmail->checkEmail($_POST['email']);
            
            if ($nb_email > 0) {
                
                $updateData = new Users(array('recoveryCode'=>$recoveryPass, 'email'=>$email));
                $updateInfo = new UsersManager();
                $updateInfo->updateRecovery($updateData);
                $_SESSION['success'] = 1;
                $header="MIME-Version: 1.0\r\n";
                $header.='From:"Blog de Steve Essama"<essonoadou@gmail.com>'."\n";
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
                                                Cliquez <a href="http://localhost/test/index.php?                                                                                                               action=recovery_pass&section=update_password&code='.$recoveryPass.'">
                                                ici pour réinitialiser votre mot de passe</a> </br>
                                                A bientôt sur <a href="index.php/">Notre blog!</a>
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
            
            }
        }
        
        if (!empty($errors)) {
            
            $_SESSION['errors'] = $errors;
        }  
    }
    
    if (isset($_POST['pass_submit'])) {
        
        sleep(1); 
        $_POST['pass_submit'] = htmlspecialchars($_POST['pass_submit']); 
        
        if (isset($_POST['new_pass'], $_POST['confirm_pass'])) {
            $newPass = htmlspecialchars($_POST['new_pass']);
            $confirmPass = htmlspecialchars($_POST['confirm_pass']);
            
            if (!empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
                
                if ($newPass == $confirmPass) {
                    $updateUser = new Users(array('password'=>$newPass, 'email'=>$_SESSION['email']));
                    $updatePass = new UsersManager();
                    $updatePass->updatePassword($updateUser);
                    header('Location: index.php?action=connection');
                }
                
                else {
                    $errors ['new_pass'] = "Les deux mots de passe ne correspondent pas";
                    header('Location: index.php?action=recovery_pass&section=update_password');
                }
            }
            
            else {
                $errors ['new_pass'] = "veuillez remplir les champs";
                header('Location: index.php?action=recovery_pass&section=update_password');
            }
        }
        
        if (!empty($errors)) {
            
            $_SESSION['errors'] = $errors;
        }         
    }
    
    else {
        
        require ABSOLUTE_PATH.'/view/view_recovery-password.php';
    }
}

function disconnect()
{
    if (isset($_POST['disconnect'])) {
        $_POST['disconnect'] = htmlspecialchars($_POST['disconnect']); 
        unset($_SESSION['success_connect']);
        // On redirige le visiteur vers la page désirée :
        header('Location: index.php');
        exit();
    }
}

function connectionAdmin()
{
    
    if (isset($_POST['connect_admin'])) {
        
        sleep(1); 
        $_POST['connect_admin'] = htmlspecialchars($_POST['connect_admin']); 
        
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);  
        $_POST['password'] = htmlspecialchars($_POST['password']);       
        
        if (!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo'])) {
            $errors ['pseudo'] = "veuillez entrer votre pseudo";    
        }
        
        if (!array_key_exists('password', $_POST) || empty($_POST['password'])) {
            
            $errors ['password'] = "veuillez entrer votre mot de passe";  
        }
        $connectAdmin = new UsersManager();
        $nbPseudoAdmin = $connectAdmin->checkAdmin();
        
        if (!$nbPseudoAdmin) {
            $errors ['pseudo'] = "Ce pseudo ne correspond à aucun administrateur ";
        }
        
        $connectAdmin = new UsersManager();
        $verifPass = $connectAdmin ->connectUser();
        
        if ($verifPass == false) {
            $errors ['password'] = "mauvais identifiant ou mot de passe";
        }
        
        if ($verifPass == true) {
            $_SESSION['success_connect'] = "Vous êtes connecté";
            $_SESSION['pseudo'] = $_POST["pseudo"];
            header('Location: index.php?action=admin_space');
        }
        
        if (!empty($errors)) {
            
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=connect_admin#form_admin');
        }          
    }
    
    else {
        
        require ABSOLUTE_PATH.'/view/view_connection_admin.php';
    }
}

function adminSpace()
{
       
   if (!array_key_exists('success_connect', $_SESSION)) {
        header('Location: index.php');
    
    }
    
    $newsList = new NewsManager(); // Création d'un objet
    $posts = $newsList->getListPosts(); //Appel d'une fonction de cet objet
    require ABSOLUTE_PATH.'/view/view_admin_space.php';

}


function addArticle()
{
   
    if (isset($_POST['add_new'])) {
            
        if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
        
            if ($_SESSION['token'] == $_POST['token']) {    
        
        
                $_POST['add_new'] = htmlspecialchars($_POST['add_new']);
                $_POST['post_title'] = htmlspecialchars($_POST['post_title']);
                $_POST['post_author'] = htmlspecialchars($_POST['post_author']);
                $_POST['resume_post'] = htmlspecialchars($_POST['resume_post']);
                $_POST['content'] = htmlspecialchars($_POST['content']);
                $_POST['token'] = htmlspecialchars($_POST['token']);
        
        
                if (!array_key_exists('post_author', $_POST) || empty($_POST['post_author'])) {
            
                    $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
                }
        
                if (strlen($_POST['post_author'] > 30)) {
            
                    $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
                }
        
                if (!array_key_exists('post_title', $_POST) || empty($_POST['post_title'])) {
            
                    $errors ['post_title'] = "veuillez saisir le titre de l'article";
                }
        
                if (strlen($_POST['post_title'] > 30)) {
            
                    $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
                }
        
                if (!array_key_exists('resume_post', $_POST) || $_POST['resume_post'] == "") {
            
                    $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
                }
        
                if (strlen($_POST['resume_post'] > 200)) {
            
                    $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
                }
        
                if (!array_key_exists('content', $_POST) || $_POST['content'] == "") {
            
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
                    header('Location: index.php?action=add_article');
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
                    imagejpeg($newImage , 'public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee, 100); 
                    $_POST['MAX_FILE_SIZE'] = 'public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee;
                    $insertPost = new NewsManager();
                    $insertPost->addPost();
                    $_SESSION['insert_success'] = 1;
                    header('Location: index.php?action=admin_space');
                }
            }
    
    
        }
          
        else {  
    
            header('Location:index.php');
    
        }
    
    }
    
    require ABSOLUTE_PATH.'/view/view_add_article.php';
}


function delete()
{
       
    
    $_GET['id'] = htmlspecialchars($_GET['id']);
   
    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
    
        $_POST['token'] = htmlspecialchars($_POST['token']);
        
        
        if ($_SESSION['token'] == $_POST['token']) {
        
            $deletePost = new NewsManager();
            $deletePost->deleteNew($_GET['id']);
            $_SESSION['delete_post'] = 1;
            header('Location: index.php?action=admin_space');
            require ABSOLUTE_PATH.'/view/view_admin_space.php'; 
        
        }
    
    }
    
    else {
        
        header('Location:index.php');
        
    }

}


function update()
{
   
    if (!array_key_exists('success_connect', $_SESSION)) {
        
        header('Location: index.php');
    }
    
    
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $post = new NewsManager();
    $news = $post->getPostById($_GET['id']);
    
    if (isset($_POST['add_new'])) {
        
        if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
        
            if ($_SESSION['token'] == $_POST['token']) {
        
                $_POST['add_new'] = htmlspecialchars($_POST['add_new']);
                $_POST['resume_post'] = htmlspecialchars($_POST['resume_post']);
                $_POST['content'] = htmlspecialchars($_POST['content']);
                $_POST['post_author'] = htmlspecialchars($_POST['post_author']);
                $_POST['post_title'] = htmlspecialchars($_POST['post_title']);
                $_POST['token'] = htmlspecialchars($_POST['token']);
        
        
        
                if (!array_key_exists('post_author', $_POST) || empty($_POST['post_author'])) {
            
                    $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
                }
        
                if (strlen($_POST['post_author'] > 30)) {
            
                    $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
                }
        
                if (!array_key_exists('post_title', $_POST) || empty($_POST['post_title'])) {
            
                    $errors ['post_title'] = "veuillez saisir le titre de l'article";
                }
        
                if (strlen($_POST['post_title'] > 30)) {
            
                    $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
                }
        
                if (!array_key_exists('resume_post', $_POST) || $_POST['resume_post'] == "") {
            
                    $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
                }
        
                if (strlen($_POST['resume_post'] > 200)) {
            
                    $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
                }
        
                if (!array_key_exists('content', $_POST) || $_POST['content'] == "") {
            
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
                    header('Location: index.php?action=update_post&id='.$_GET['id']);
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
                    imagejpeg($newImage , 'public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee, 100); 
                    $_POST['MAX_FILE_SIZE'] = 'public/img/portfolio/'.$_POST['image_post'].'.'.$ExtensionPresumee;
                    $updatePost = new NewsManager();
                    $updatePost->updateNew();
                    $_SESSION['success_update'] = 1;
                    header('Location: index.php?action=admin_space');
                }
            }
        }
    
        else {
            
            header('Location:index.php');
        
        }
    
    
    }
    
    require ABSOLUTE_PATH.'/view/view_update_post.php';  

}


function manageComment()
{
   
    
    if (!array_key_exists('success_connect', $_SESSION)) {
        header('Location: index.php');
    }
        
    $showComment = new CommentManager();
    $showComment->getListComment();
    require ABSOLUTE_PATH.'/view/view_manage_comment.php';  
}


function approveComment()
{
    $_GET['id'] = htmlspecialchars($_GET['id']);
    
    
    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
        
        $_POST['token'] = htmlspecialchars($_POST['token']);
        
        if ($_SESSION['token'] == $_POST['token']) {
        
            $validComment = new CommentManager();
            $validComment->commentValidation();
            $_SESSION['comment_approved'] = 1;
            header('Location: index.php?action=manage_comment');
            require ABSOLUTE_PATH.'/view/view_manage_comment.php';  
        }
    
    }

    else {
            
        header('Location:index.php');
        
    }

}
        
        
function deleteComment()
{
        
    $_GET['id'] = htmlspecialchars($_GET['id']);
   
    
    if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {
        
        $_POST['token'] = htmlspecialchars($_POST['token']);    
        
        if ($_SESSION['token'] == $_POST['token']) {
        
            $deleteComment = new CommentManager();
            $deleteComment->deleteComment($_GET['id']);
            $_SESSION['comment_delete'] = 1;
            header('Location: index.php?action=manage_comment');
            require ABSOLUTE_PATH.'/view/view_manage_comment.php'; 
        }
        
    }

    else {
            
        header('Location:index.php');
    
    }

}