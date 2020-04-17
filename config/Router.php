<?php
namespace App\config;

use App\src\Controller\FrontController;
use App\src\Controller\ErrorController;
use App\src\Controller\BackController;


class Router
{

    private $frontController;
    private $errorController;
    private $backController;

    public function __construct() 
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
        $this->backController = new BackController();
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

                elseif($_GET['action'] === 'sendmail') {

                    $this->frontController->sendMail();
                }
                elseif($_GET['action'] === 'inscription') {

                    $this->backController->inscription();
                }
            
                elseif($_GET['action'] === 'confirminscription') {

                    $this->backController->countActivation();
                }
                elseif($_GET['action'] === 'connexion') {

                    $this->backController->connexion();
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

