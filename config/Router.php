<?php

namespace App\config;

class Router
{
    public function run()
    {
        try{
            if(isset($_GET['action']))
            {
                if($_GET['action'] === 'article'){
                    
                    if(isset($_GET['id']) AND $_GET['id'] > 0){

                        require '../templates/single.php';

                    }
                    else{
                        
                        header('Location: ../public/index.php');


                    }
                    
                    
                }
                elseif($_GET['action'] === 'listposts'){
                    
                    require '../templates/posts.php';
                }
            }
            else{
                require '../templates/homepage.php';
            }
        }
        catch (Exception $e)
        {
            echo 'Erreur';
        }
    }
}

