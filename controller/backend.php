<?php

require_once ABSOLUTE_PATH."/model/UsersManager.php";
require_once ABSOLUTE_PATH."/model/users.php";



function Inscription()
{

if(isset($_POST['inscription']))
{    
   
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
    

if(!array_key_exists('email', $_POST) || empty($_POST['email']) || $nb_email > 0 )
{
    
 $errors ['email'] = "adresse email non renseigné ou déjà utilisé";
}

if(!array_key_exists('password', $_POST) || empty($_POST['password']) || !array_key_exists('password_confirm', $_POST) || empty($_POST['password_confirm']))      {
    
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
        
$_SESSION['success_connect'] = "vous êtes connecté";

$_SESSION['pseudo'] = $_POST["pseudo"];

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
 
$email = htmlspecialchars($_POST['email']);   
    
$errors = array();

$verif_email = new UsersManager();
$nb_email = $verif_email->check_email($_POST['email']);
    
    
if(!array_key_exists('email', $_POST) || empty($_POST['email']) || !$nb_email)
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
                     
                     <div align="center">Bonjour, vous avez indiqué avoir oublié votre mot de passe </div>
                     <p>Cliquez <a href="http://localhost/test/index.php?action=recovery_pass&section=update_password&code='.$recovery_pass.'">
                     ici pour réinitialiser votre mot de passe</a> </br>
                     A bientôt sur <a href="index.php/">Notre blog!</a></p>
                     
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
    

	unset($_SESSION['success_connect']);
 
// On redirige le visiteur vers la page désirée :
	header('Location: index.php');
	exit();
   
}
    

}
    










    
          
    

    

                               



























