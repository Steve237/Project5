<?php 

session_start();

// Definition du chemin absolu
define("ABSOLUTE_PATH", dirname(__FILE__));

require ABSOLUTE_PATH.'/autoload.php';
require ABSOLUTE_PATH.'/controller/frontend.php';
require ABSOLUTE_PATH.'/controller/backend.php';


if (isset($_GET['action'])) {

    $_GET['action'] = htmlspecialchars($_GET['action']);
    
    if ($_GET['action'] == 'listposts') {
        
        listPosts();

    }

    elseif ($_GET['action'] == 'post') {
        
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            
            post();

        }    

    }


    elseif ($_GET['action'] == 'sendmail') {
        
        sendMail();

    }



    elseif ($_GET['action'] == 'inscription') {


        inscription();

    }


    elseif ($_GET['action'] == 'connection') {


        connection();
    
    }

    elseif ($_GET['action'] == 'recovery_pass') {

        recovery();    

    }


    elseif ($_GET['action'] == 'disconnected') {

        disconnect();    

    }


    elseif ($_GET['action'] == 'admin_space') {

        adminSpace();    

    }    

    elseif ($_GET['action'] == 'connect_admin') {


        connectionAdmin();

    }

    elseif ($_GET['action'] == 'add_article') {

        addArticle();   

    }


    elseif ($_GET['action'] == 'delete_post') {
        
        if (isset($_GET['id']) && $_GET['id'] > 0) {

            delete();
        
        }

    }


    elseif ($_GET['action'] == 'update_post') {
        
        if (isset($_GET['id']) && $_GET['id'] > 0) {

            update();
        
        }
    
    }


    elseif ($_GET['action'] == 'manage_comment') {


        manageComment();

    }



    elseif ($_GET['action'] == 'approve') {


        if (isset($_GET['id']) && $_GET['id'] > 0) {

            approveComment();   

        }


    }


    elseif ($_GET['action'] == 'delete_comment') {

        if (isset($_GET['id']) && $_GET['id'] > 0) {


            deleteComment();

        }

    }

    
    else {
        
        error();    
    
    }

}


else
{

    homePage();

}
