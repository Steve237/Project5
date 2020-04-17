<?php
namespace App\src\Controller;

use App\src\model\View;
use App\src\DAO\UsersDAO;

class BackController {

    private $view;
    private $usersDAO;

    public function __construct() {
        
        $this->view = new View();
        $this->usersDAO = new UsersDAO();
    }

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
        
        if ($password != $password_confirm) {
            
            $errors ['password'] = "Veuillez entrer deux mots de passe identiques";
        }
        
        if (!empty($errors)) {
            session_start();
            $_SESSION['errors'] = $errors;
            header('Location: ../public/index.php?action=inscription#formInscription');
            
        }
        
        else {
            
           
            $newmember = new UsersDAO();
            $newmember->addUser($pseudo, $password, $email);

            $confirmkey = md5(microtime(TRUE)*100000);
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $addVerifKey = new UsersDAO();
            $addVerifKey->addKey($confirmkey, $pseudo);
            
            // Préparation du mail contenant le lien d'activation
            $destinataire = $email;
            $sujet = "Activer votre compte" ;
            $entete = "From: inscription@votresite.com" ;
 
            // Le lien d'activation est composé du login(log) et de la clé(cle)
            $message = 'Bienvenue sur VotreSite,
 
            Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
            ou copier/coller dans votre navigateur Internet.
 
            localhost/project5/public/index.php?action=confirminscription&log='.urlencode($pseudo).'&cle='.urlencode($confirmkey).'
 
 
            ---------------
            Ceci est un mail automatique, Merci de ne pas y répondre.';
 
 
            mail($destinataire, $sujet, $message, $entete) ;
            
            session_start();
            $_SESSION['success'] = 1;   

            header('Location: ../public/index.php?action=inscription#formInscription');
            
        }
    } 
    
    else {
        
        $this->view->render('inscription');
    }
    

    }

    public function countActivation() 
    {
        if (isset($_GET['log']) AND isset($_GET['cle']) AND !empty($_GET['log']) 
        AND !empty($_GET['cle'])) {
            
            $pseudo = $_GET['log'];
            $confirmkey = $_GET['cle'];

            $checkCount = new UsersDAO();
            $verifcount = $checkCount->checkConfirmed($pseudo);
            var_dump($verifcount);
            
            $verifKey = new UsersDAO();
            $verif = $verifKey->checkConfirmKey($pseudo);
            

            if($verifcount == 1) {
            session_start();
            $_SESSION['activation'] = 1;

            header('Location: ../public/index.php?action=connexion');
            
            }

            else {
            
                if($verif != null) {
               
                    $confirm = new UsersDAO();
                    $confirm->confirmCount($pseudo);

                    session_start();
                    $_SESSION['confirmation'] = 1;
                
                    header('Location: ../public/index.php?action=connexion');
                }

                else {

                    session_start();
                    $_SESSION['erroractivation'] = 1;
                    header('Location: ../public/index.php?action=connexion');
                }
            }
    
        }
    
        else {    
            
            $this->view->render('connection');
        
        }
        
    }
    
    public function connexion() {


        $this->view->render('connection');
    }

}