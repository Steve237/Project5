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
            
            if(isset($_GET['action'])) {
                
                if($_GET['action'] === 'article') {
                    
                    if(isset($_GET['id']) AND $_GET['id'] > 0) {

                        $this->frontController->single($_GET['id']);

                    } else {
                        
                        $this->errorController->unknown();
                    }
                
                } elseif($_GET['action'] === 'listposts') {
                    
                    $this->frontController->articles();
                    
                } elseif($_GET['action'] === 'sendmail') {

                    $this->frontController->sendMail();
                
                } elseif($_GET['action'] === 'inscription') {

                    $this->backController->inscription();
                
                } elseif($_GET['action'] === 'confirminscription') {

                    $this->backController->countActivation();
                
                } elseif($_GET['action'] === 'connexion') {

                    $this->backController->connexion();
                
                } elseif($_GET['action'] === 'recoverypass') {

                    $this->backController->recoveryPass();
                
                } elseif($_GET['action'] === 'updatepass') {

                    $this->backController->updatePass();
                
                } elseif($_GET['action'] === 'disconnect') {

                    $this->backController->disconnect();
                
                } elseif($_GET['action'] === 'adminconnection') {

                    $this->backController->adminConnection();
                
                } elseif($_GET['action'] === 'adminspace') {

                    $this->backController->adminSpace();
                
                } elseif($_GET['action'] === 'addarticle') {

                    $this->backController->addArticle();
                
                } elseif($_GET['action'] === 'updatepost') {

                    $this->backController->updateArticle($_GET['id']);
                
                } elseif($_GET['action'] === 'deletepost') {
                    
                    if(isset($_GET['id']) AND $_GET['id'] > 0) {

                        $this->backController->deleteArticle();

                    } else {
                        
                        $this->errorController->unknown();
                    }
                    
                } elseif($_GET['action'] === 'managecomment') {

                    $this->backController->manageComment();
                
                } elseif($_GET['action'] === 'approve') {
                    
                    if(isset($_GET['id']) AND $_GET['id'] > 0) {
                        
                        $this->backController->approveComment($_GET['id']);
                    
                    } else {
                        
                        $this->errorController->unknown();
                    }
                
                } elseif($_GET['action'] === 'deletecomment') {
                    
                    if(isset($_GET['id']) AND $_GET['id'] > 0) {
                        
                        $this->backController->deleteComment($_GET['id']);
                    
                    } else {
                        
                        $this->errorController->unknown();
                    }
                }
            
            } else {
                
                $this->frontController->home();
            }
        }
        
        catch (Exception $e)
        {
            $this->errorController->error();
        }
    }
}

