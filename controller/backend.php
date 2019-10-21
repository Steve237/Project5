<?php

require_once ABSOLUTE_PATH."/model/UsersManager.php";
require_once ABSOLUTE_PATH."/model/users.php";
require_once ABSOLUTE_PATH."/model/CommentManager.php";
require_once ABSOLUTE_PATH."/model/comments.php";



function Inscription()
{

    if(isset($_POST['inscription']))
    {    
        $_POST['inscription'] = htmlspecialchars($_POST['inscription']);
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);    
        $_POST['email'] = htmlspecialchars($_POST['email']);    
        $_POST['password'] = htmlspecialchars($_POST['password']);    
        $_POST['password_confirm'] = htmlspecialchars($_POST['password_confirm']);  


        $errors = array();

        $inscription = new UsersManager();
        $nb_pseudo = $inscription->check_pseudo($_POST['pseudo']);

        $connection = new UsersManager();
        $nb_email = $connection->check_email($_POST['email']);


        if(!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo']) || $nb_pseudo > 0)
        {

            $errors ['pseudo'] = "pseudo non renseigné ou déjà utilisé";
        }


        if(strlen($_POST['pseudo']) < 7 )
        {

            $errors ['pseudo'] = "le pseudo doit comporter au moins sept caractères";   

        }

        if(preg_match("#[^a-z0-9]+#", $_POST['pseudo']))

        {

            $errors ['pseudo'] = "Le pseudo doit être composé seulement de lettres minuscules et d'au moins un chiffre";  

        }


        if(!array_key_exists('email', $_POST) || empty($_POST['email']) || $nb_email > 0 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {

            $errors ['email'] = "adresse email non renseigné ou déjà utilisé";
        }


        if(!array_key_exists('password', $_POST) || empty($_POST['password']) || !array_key_exists('password_confirm', $_POST) ||                                       empty($_POST['password_confirm']))      
        {

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
            $inscription = new UsersManager();
            $inscription->add_Users();
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
        $_POST['connection'] = htmlspecialchars($_POST['connection']);
        
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);  

        $_POST['password'] = htmlspecialchars($_POST['password']);       


        if(!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo'])) 
        {

            $errors ['pseudo'] = "veuillez entrer votre pseudo";    

        }

        if(!array_key_exists('password', $_POST) || empty($_POST['password']))  
        {
            $errors ['password'] = "veuillez entrer votre mot de passe";  
        }


        $connect = new UsersManager();
        $nb_pseudo = $connect->check_Member();

        if(!$nb_pseudo)

        {

            $errors ['pseudo'] = "pseudo inconnu";

        }


        $connect = new UsersManager();
        $verif_pass = $connect ->connect_User();

        if($verif_pass == false)
        {

            $errors ['password'] = "mauvais identifiant ou mot de passe";

        }

        if($verif_pass == true)
        {

            $_SESSION['success_connect'] = "Vous êtes connecté";

            $_SESSION['pseudo'] = $_POST["pseudo"];

            header('Location: index.php');

        }


        if(array_key_exists("success-connect", $_SESSION))
        {


            header('Location: index.php');

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



function Recovery()
{

    if(isset($_GET['section']))
    {
        $section = htmlspecialchars($_GET['section']);   
    }

    else
    {
        $section=""; 
    }


    if(isset($_POST['recovery_submit']))

    {   
        $_POST['recovery_submit'] = htmlspecialchars($_POST['recovery_submit']); 
        
        $email = htmlspecialchars($_POST['email']);   

        $errors = array();

        $verif_email = new UsersManager();
        $nb_email = $verif_email->check_email($_POST['email']);


        if(!array_key_exists('email', $_POST) || empty($_POST['email']) || !$nb_email || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {

            $errors ['email'] = "adresse email non renseigné ou inconnu du système";
            header('Location: index.php?action=recovery_pass');

        }

        if($nb_email > 0)
        {


            $_SESSION['email'] = $email;

            $recovery_pass = sha1(time());


            $_SESSION['recovery_pass'] = $recovery_pass;

            $verif_email = new UsersManager();
            $nb_email = $verif_email->check_email($_POST['email']);

            if($nb_email > 0)

            {
                $update_data = new Users(array('recovery_code'=>$recovery_pass, 'email'=>$email));
                $update_info = new UsersManager();
                $update_info->update_recovery($update_data);

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
                                                Cliquez <a href="http://localhost/test/index.php?                                                                                                               action=recovery_pass&section=update_password&code='.$recovery_pass.'">
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


        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;

        }  

    }

    if(isset($_POST['pass_submit']))
    {
        
        $_POST['pass_submit'] = htmlspecialchars($_POST['pass_submit']); 
        if(isset($_POST['new_pass'], $_POST['confirm_pass']))
        {

            $new_pass = htmlspecialchars($_POST['new_pass']);
            $confirm_pass = htmlspecialchars($_POST['confirm_pass']);

            if(!empty($_POST['new_pass']) && !empty($_POST['confirm_pass']))
            {

                if($new_pass == $confirm_pass)
                {

                    $update_user = new Users(array('password'=>$new_pass, 'email'=>$_SESSION['email']));
                    $update_pass = new UsersManager();
                    $update_pass->update_password($update_user);
                    header('Location: index.php?action=connection');



                }

                else
                {

                    $errors ['new_pass'] = "Les deux mots de passe ne correspondent pas";
                    header('Location: index.php?action=recovery_pass&section=update_password');


                }


            }

            else
            {

                $errors ['new_pass'] = "veuillez remplir les champs";
                header('Location: index.php?action=recovery_pass&section=update_password');

            }

        }


        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;

        }         

    }


    else
    {


        require ABSOLUTE_PATH.'/view/view_recovery-password.php';
    }

}



function Disconnect()
{

    if(isset($_POST['disconnect']))
    {

        $_POST['disconnect'] = htmlspecialchars($_POST['disconnect']); 
        unset($_SESSION['success_connect']);

        // On redirige le visiteur vers la page désirée :
        header('Location: index.php');
        exit();

    }


}


function Connection_admin()
{

    if(isset($_POST['connect_admin']))

    {

        $_POST['connect_admin'] = htmlspecialchars($_POST['connect_admin']); 
        
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);  

        $_POST['password'] = htmlspecialchars($_POST['password']);       


        if(!array_key_exists('pseudo', $_POST) || empty($_POST['pseudo'])) 
        {

            $errors ['pseudo'] = "veuillez entrer votre pseudo";    

        }


        if(!array_key_exists('password', $_POST) || empty($_POST['password']))  
        {
            $errors ['password'] = "veuillez entrer votre mot de passe";  

        }


        $connect_admin = new UsersManager();
        $nb_pseudo_admin = $connect_admin->check_Admin();

        if(!$nb_pseudo_admin)

        {

            $errors ['pseudo'] = "Ce pseudo ne correspond à aucun administrateur ";

        }


        $connect_admin = new UsersManager();
        $verif_pass = $connect_admin ->connect_User();

        if($verif_pass == false)
        {

            $errors ['password'] = "mauvais identifiant ou mot de passe";

        }


        if($verif_pass == true)
        {

            $_SESSION['success_connect'] = "vous êtes connecté";

            $_SESSION['pseudo'] = $_POST["pseudo"];

            header('Location: index.php?action=admin_space');

        }


        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=connect_admin#form_admin');

        }          

    }

    else
    {

        require ABSOLUTE_PATH.'/view/view_connection_admin.php';
    }

}



function Admin_space()
{

    
    
    if(!array_key_exists('success_connect', $_SESSION))
    {
        header('Location: index.php');
    
    }
    
    $news_list = new NewsManager(); // Création d'un objet
    $posts = $news_list->getListPosts(); //Appel d'une fonction de cet objet

    require ABSOLUTE_PATH.'/view/view_admin_space.php';

}


function Add_article()
{
    if(!array_key_exists('success_connect', $_SESSION))
    {
        header('Location: index.php');
    }
    
    if(isset($_POST['add_new']))
    {
        $_POST['add_new'] = htmlspecialchars($_POST['add_new']);
        $_POST['post_title'] = htmlspecialchars($_POST['post_title']);
        $_POST['post_author'] = htmlspecialchars($_POST['post_author']);
        $_POST['resume_post'] = htmlspecialchars($_POST['resume_post']);
        $_POST['content'] = htmlspecialchars($_POST['content']);
        $_FILES['image_post'] = htmlspecialchars($_FILES['image_post']);

        if(!array_key_exists('post_author', $_POST) || empty($_POST['post_author']))
        {
            $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
        }

        if(strlen($_POST['post_author'] > 30))
        {
            $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
        }

        if(!array_key_exists('post_title', $_POST) || empty($_POST['post_title']))
        {
            $errors ['post_title'] = "veuillez saisir le titre de l'article";
        }

        if(strlen($_POST['post_title'] > 30))
        {
            $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
        }

        if(!array_key_exists('resume_post', $_POST) || $_POST['resume_post'] == "")
        {
            $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
        }

        if(strlen($_POST['resume_post'] > 200))
        {
            $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
        }

        if(!array_key_exists('content', $_POST) || $_POST['content'] == "")
        {
            $errors ['content'] = "veuillez saisir le contenu de votre article";

        }

        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');


        if (empty($_FILES['image_post']))
        {

            $errors ['image_post'] = "vous n'avez ajouté aucune image";
        }

        if ($_FILES['image_post']['error'] > 0)
        {

            $errors ['image_post'] = "Erreur lors du téléchargement de l'image";

        }

        if ($_FILES['image_post']['size'] > 2097152)
        {

            $errors ['image_post'] = "l'image choisie est trop lourde";

        }

        $imagePost = $_FILES['image_post']['name'];
        $ExtensionPresumee = explode('.', $imagePost);
        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);
        if ($ExtensionPresumee != 'jpg' && $ExtensionPresumee != 'jpeg')
        {

            $errors ['image_post'] = "Veuillez ajouter une image au format Jpeg";

        }

        $imagePost = getimagesize($_FILES['image_post']['tmp_name']);
        if($imagePost['mime'] != $ListeExtension[$ExtensionPresumee]  && $imagePost['mime'] != $ListeExtensionIE[$ExtensionPresumee])
        {

            $errors ['image_post'] = "Veuillez ajouter une image au format jpeg"; 

        }

        if (!is_uploaded_file($_FILES['image_post']['tmp_name'])) 
        {

            $errors ['image_post'] = "aucune image téléchargé"; 


        }


        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=add_article');

        }   


        else
        {

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
            $insertPost->add_post();

            $_SESSION['insert_success'] = 1;
            header('Location: index.php?action=admin_space');
        }
    }

    else
    {    
        require ABSOLUTE_PATH.'/view/view_add_article.php';

    }

}


function delete()
{
        
        $_GET['id'] = htmlspecialchars($_GET['id']);
        
        $delete_post = new NewsManager();
        $delete_post->delete_new($_GET['id']);
        $_SESSION['delete_post'] = 1;

        header('Location: index.php?action=admin_space');

        require ABSOLUTE_PATH.'/view/view_admin_space.php';  
}


function update()
{

     if(!array_key_exists('success_connect', $_SESSION))
    {
        header('Location: index.php');
    }
    
    
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $post = new NewsManager();
    $news = $post->getPostById($_GET['id']);

    if(isset($_POST['add_new']))
    {
        $_POST['add_new'] = htmlspecialchars($_POST['add_new']);
        $_POST['resume_post'] = htmlspecialchars($_POST['resume_post']);
        $_POST['content'] = htmlspecialchars($_POST['content']);
        $_POST['post_author'] = htmlspecialchars($_POST['post_author']);
        $_POST['post_title'] = htmlspecialchars($_POST['post_title']);
        $_FILES['image_post'] = htmlspecialchars($_FILES['image_post']);
        
        
        if(!array_key_exists('post_author', $_POST) || empty($_POST['post_author']))
        {
            $errors ['post_author'] = "veuillez saisir le nom de l'auteur";
        }

        if(strlen($_POST['post_author'] > 30))
        {
            $errors ['post_author'] = "le nom doit être composé au maximum de 30 caractères";
        }

        if(!array_key_exists('post_title', $_POST) || empty($_POST['post_title']))
        {
            $errors ['post_title'] = "veuillez saisir le titre de l'article";
        }

        if(strlen($_POST['post_title'] > 30))
        {
            $errors ['post_title'] = "le titre doit contenir au maximum 30 caractères";
        }

        if(!array_key_exists('resume_post', $_POST) || $_POST['resume_post'] == "")
        {
            $errors ['resume_post'] = "veuillez saisir le résumé de l'article";
        }

        if(strlen($_POST['resume_post'] > 200))
        {
            $errors ['resume_post'] = "le résumé doit contenir au maximum 200 caractères";
        }

        if(!array_key_exists('content', $_POST) || $_POST['content'] == "")
        {
            $errors ['content'] = "veuillez saisir le contenu de votre article";

        }

        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg'=>'image/jpeg');
        $ListeExtensionIE = array('jpg' => 'image/pjpeg', 'jpeg'=>'image/pjpeg');


        if (empty($_FILES['image_post']))
        {

            $errors ['image_post'] = "vous n'avez ajouté aucune image";
        }

        if ($_FILES['image_post']['error'] > 0)
        {

            $errors ['image_post'] = "Erreur lors du téléchargement de l'image";

        }

        if ($_FILES['image_post']['size'] > 2097152)
        {

            $errors ['image_post'] = "l'image choisie est trop lourde";

        }

        $imagePost = $_FILES['image_post']['name'];

        $ExtensionPresumee = explode('.', $imagePost);
        $ExtensionPresumee = strtolower($ExtensionPresumee[count($ExtensionPresumee)-1]);

        if ($ExtensionPresumee != 'jpg' && $ExtensionPresumee != 'jpeg')
        {

            $errors ['image_post'] = "Veuillez ajouter une image au format Jpeg";

        }

        $imagePost = getimagesize($_FILES['image_post']['tmp_name']);
        if($imagePost['mime'] != $ListeExtension[$ExtensionPresumee]  && $imagePost['mime'] != $ListeExtensionIE[$ExtensionPresumee])
        {

            $errors ['image_post'] = "Veuillez ajouter une image au format jpeg"; 

        }

        if (!is_uploaded_file($_FILES['image_post']['tmp_name'])) 
        {

            $errors ['image_post'] = "aucune image téléchargé"; 


        }


        if(!empty($errors))
        {
            $_SESSION['errors'] = $errors;
            header('Location: index.php?action=add_article');

        }   


        else
        {

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
            $updatePost->update_New();

            $_SESSION['success_update'] = 1;
            header('Location: index.php?action=admin_space');
        }
    }

    else
    {
        require ABSOLUTE_PATH.'/view/view_update_post.php';  
    }


}



function manage_comment()
{

    if(!array_key_exists('success_connect', $_SESSION))
    {
        header('Location: index.php');
    }
        
    $showcomment = new CommentManager();
    $showcomment->getListComment();
    require ABSOLUTE_PATH.'/view/view_manage_comment.php';  
}



function approve_comment()
{
    $_GET['id'] = htmlspecialchars($_GET['id']);
        
    $valid_comment = new CommentManager();
    $valid_comment->comment_Validation();
    $_SESSION['comment_approved'] = 1;

    header('Location: index.php?action=manage_comment');


    require ABSOLUTE_PATH.'/view/view_manage_comment.php';  
}


function delete_comment()
{
        
    $_GET['id'] = htmlspecialchars($_GET['id']);
        
    $delete_comment = new CommentManager();
    $delete_comment->delete_Comment($_GET['id']);
    $_SESSION['comment_delete'] = 1;
    header('Location: index.php?action=manage_comment');
    require ABSOLUTE_PATH.'/view/view_manage_comment.php'; 

}



























