Projet 5 du parcours développeur d'application PHP/Symfony, sur OpenClassrooms. 

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/21ef57098f88472294b388417a168687)](https://www.codacy.com/manual/Steve237/Project5?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Steve237/Project5&amp;utm_campaign=Badge_Grade)

Création d'un blog professionel avec une architecture MVC Orienté objet en PHP.

Installation du projet

Etape 1 : vous devez télécharger les fichiers dans la branche Master du repository GitHub du projet et les transmettre dans le dossier web de votre serveur web.  Il s'aggit généralement du dossier "WWW".

Etape 2 : vous devez créer une base de données dans votre SGBD et y importer le fichier blog.sql disponible à la racine des fichiers du projet.

Etape 3 : vous devez configurer le fichier dev.php, accessible dans le dossier config, avec vos identifiants de connexion à la base de données, voici un exemple : 
const HOST = 'localhost';
const DB_NAME = 'monblog';
const CHARSET = 'utf8';
const DB_HOST = 'mysql:host='.HOST.';dbname='.DB_NAME.';charset='.CHARSET;
const DB_USER = 'root';
const DB_PASS = '';

Etape 4 : pour l'envoi de mail en local, vous devez configurer votre server smtp, voici un cours qui illustre comment configurer son server afin de pouvoir envoyer des mails en local si vous utilisez Wamp :

https://www.grafikart.fr/blog/mail-local-wamp

Ensuite, dès que le server est configuré pour l'envoi de mail, vous devez renseigner l'adresse email de l'expéditeur de l'email dans le fichier frontcontroller, accessible dans le dossier src/controller, il s'agit 
alors de se rendre dans la fonction sendmail et d'inscrire l'adresse email de l'expéditeur de l'email dans la variable $to. Il faut faire de même, dans le fichier backcontroller, disponible dans src/controller,
à la ligne 101 pour l'envoi du mail de confirmation d'inscription, puis à la ligne 288 pour l'envoi du mail de récupération du mot de passe. Ainsi, l'envoi de mail depuis l'application se déroulera correctement.

Etape 5 : l'application est désormais correctement installé! 
Si vous avez installé le projet en local sur WampServer, vous pourrez accéder au site via l'url suivante : localhost/public/index.php. 

Sinon le site est aussi accessible via cette url https:\\steveessama.com

Vous pouvez désormais utiliser toutes les fonctionnalités du blog! Vous pouvez désormais vous inscrire et vous connecter à l'espace membre, puis publier un commentaire.
Si vous souhaitez qu'un utilisateur puisse se connecter à l'espace administration, vous devez accéder à la table membres de la base de données, puis entrer la valeur 1 dans la colonne admin de l'utilisateur que vous souhaitez, et enregistrez. Il sera alors possible
de se connecter à l'espace administrateur avec les identifiants de connexion de ce membres.
