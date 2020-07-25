<?php
namespace App\config;

use Exception;
use App\src\Controller\BackController;
use App\src\Controller\ErrorController;
use App\src\Controller\FrontController;

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
        try {
            
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            
            if (isset($action) AND !empty($action)) {
                
                if ($action === 'article') {
                    
                    if (isset($id) AND $id > 0) {

                        $this->frontController->single($id);

                    } else {
                        
                        $this->errorController->unknown();
                    }
                
                } elseif ($action === 'listposts') {
                    
                    $this->frontController->articles();
                    
                } elseif ($action === 'sendmail') {

                    $this->frontController->sendMail();
                
                } elseif ($action === 'inscription') {

                    $this->backController->inscription();
                
                } elseif ($action === 'confirminscription') {

                    $this->backController->countActivation();
                
                } elseif ($action === 'connexion') {

                    $this->backController->connexion();
                
                } elseif ($action === 'recoverypass') {

                    $this->backController->recoveryPass();
                
                } elseif ($action === 'updatecode') {

                    $this->backController->verifRecoveryCode();
                
                } elseif ($action === 'confirmpass') {

                    $this->backController->confirmPass();
                
                } elseif ($action === 'disconnect') {

                    $this->backController->disconnect();
                
                } elseif ($action === 'adminconnection') {

                    $this->backController->adminConnection();
                
                } elseif ($action === 'adminspace') {

                    $this->backController->adminSpace();
                
                } elseif ($action === 'addarticle') {

                    $this->backController->addArticle();
                
                } elseif ($action === 'updatepost') {

                    $this->backController->updateArticle($id);
                
                } elseif ($action === 'deletepost') {
                    
                    if (isset($id) AND $id > 0) {

                        $this->backController->deleteArticle();

                    } else {
                        
                        $this->errorController->unknown();
                    }
                    
                } elseif ($action === 'managecomment') {

                    $this->backController->manageComment();
                
                } elseif ($action === 'approve') {
                    
                    if (isset($id) AND $id > 0) {
                        
                        $this->backController->approveComment($id);
                    
                    } else {
                        
                        $this->errorController->unknown();
                    }
                
                } elseif ($action === 'deletecomment') {
                    
                    if (isset($id) AND $id > 0) {
                        
                        $this->backController->deleteComment($id);
                    
                    } else {
                        
                        $this->errorController->unknown();
                    }
                
                } else {

                    $this->errorController->unknown();

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

