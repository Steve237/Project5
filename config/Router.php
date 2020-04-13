<?php

namespace App\config;
use App\src\Controller\FrontController;
use App\src\Controller\ErrorController;


class Router
{

    private $frontController;
    private $errorController;

    public function __construct() 
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }

    public function run()
    {
        try{
            if(isset($_GET['action']))
            {
                if($_GET['action'] === 'article'){
                    
                    if(isset($_GET['id']) AND $_GET['id'] > 0){

                        $this->frontController->single($_GET['id']);

                    }
                    else{
                        
                        $this->errorController->unknown();


                    }
                    
                    
                }
                elseif($_GET['action'] === 'listposts') {
                    
                    $this->frontController->articles();
                    
                }
            }
            else{
                
                $this->frontController->home();
            }
        }
        
        catch (Exception $e)
        {
            $this->errorController->error();
        }
    }
}

