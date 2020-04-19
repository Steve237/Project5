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

        $errors = array();
        
        if(isset($_POST['email']) AND isset($_POST['password'])) {

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
            
                session_start();
                $_SESSION['errors'] = $errors;

                header('Location:../public/index.php?action=connexion');

            }

            else {
            
                session_start();
                $_SESSION['success_connect'] = 1;
                $this->view->render('adminspace');
            
            }
        }  
        
        else {
                
                $this->view->render('connexion');
        }  
            
    }

    public function recoveryPass() {

        $errors = array();

        if (isset($_GET['section'])) {
        
            $section = htmlspecialchars($_GET['section']);   
        }
        
        else {
        
            $section=""; 
        }

        
        if(isset($_POST['recoverysubmit'])) {   
        
            $recoverysubmit = htmlspecialchars($_POST['recoverysubmit']); 
            
            $email = htmlspecialchars($_POST['email']);   
            
            $verifEmail = new UsersDAO();
            $nbEmail = $verifEmail->checkEmail($email);

            if (!array_key_exists('email', $_POST) || empty($email) 
            || $nbEmail == null || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                
                $errors ['email'] = "adresse email non renseigné ou inconnu du système";
                header('Location: index.php?action=recoverypass');
            }

            if (!empty($errors)) {
                
                $_SESSION['errors'] = $errors;
            }     

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
                                                <a href="localhost/project5/public/index.php?action=recoverypass&amp;section=updatepassword&code='.$recoveryPass.'" target="_blank">
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
                $_SESSION['success'] = 1;
                
            }
        }
        
        if (isset($_POST['pass_submit'])) {
        
            sleep(1); 
            $submitPass = htmlspecialchars($_POST['pass_submit']); 
            
            if (isset($_POST['newpass'], $_POST['confirmpass'])) {
                $newPass = htmlspecialchars($_POST['newpass']);
                $confirmPass = htmlspecialchars($_POST['confirmpass']);
                
                if (empty($_POST['newpass']) || empty($_POST['confirmpass'])) {

                    $errors ['newpass'] = "veuillez entrer votre nouveau mot de passe";
                    header('Location: index.php?action=recoverypass&section=updatepassword');
                }
                
                else {
                    
                    if ($newPass == $confirmPass) {
                    
                        $updatePass = new UsersDAO();
                        $updatePass->updatePass($newPass, $email);
                        $_SESSION['success'] = 1;
                        header('Location: index.php?action=connexion');
                    }
                
                    else {
                        
                        $errors ['newpass'] = "Les deux mots de passe ne correspondent pas";
                        header('Location: index.php?action=recoverypass&section=updatepassword');
                        
                    }
                }      
               
            }
            
            if (!empty($errors)) {
                
                $_SESSION['errors'] = $errors;
            }  
               
        }
            
        $this->view->render('recoverypass', ['section' => $section]);
    }
}