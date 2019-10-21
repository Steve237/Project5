<?php 

// Definition du chemin absolu
define("ABSOLUTE_PATH", dirname(__FILE__));



require ABSOLUTE_PATH.'/controller/frontend.php';
require ABSOLUTE_PATH.'/controller/backend.php';



if (isset($_GET['action']))
{

    $_GET['action'] = htmlspecialchars($_GET['action']);
    
    if ($_GET['action'] == 'listposts') 
    {
        listPosts();

    }

    elseif ($_GET['action'] == 'post') 
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) 
        {
            post();

        }    

    }


    elseif ($_GET['action'] == 'sendmail')
    {
        sendMail();

    }



    elseif ($_GET['action'] == 'inscription')
    {


        Inscription();

    }


    elseif ($_GET['action'] == 'connection')
    {


        Connection();

    }

    elseif ($_GET['action'] == 'recovery_pass')
    {

        Recovery();    

    }


    elseif ($_GET['action'] == 'disconnected')
    {

        Disconnect();    

    }


    elseif ($_GET['action'] == 'admin_space')
    {

        Admin_space();    

    }    

    elseif ($_GET['action'] == 'connect_admin')
    {


        Connection_admin();

    }

    elseif ($_GET['action'] == 'add_article')
    {

        Add_article();   

    }



    elseif ($_GET['action'] == 'delete_post')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {

            delete();
        
        }

    }


    elseif ($_GET['action'] == 'update_post')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {

            update();
        
        }
    
    }



    elseif ($_GET['action'] == 'manage_comment')
    {


        manage_comment();

    }



    elseif ($_GET['action'] == 'approve')
    {


        if (isset($_GET['id']) && $_GET['id'] > 0) 

        {

            approve_comment();   

        }


    }


    elseif ($_GET['action'] == 'delete_comment')
    {

        if (isset($_GET['id']) && $_GET['id'] > 0) 
        {


            delete_comment();

        }

    }

}


else
{

    homePage();

}
