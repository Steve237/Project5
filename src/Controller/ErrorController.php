<?php
namespace App\src\Controller;

use App\src\model\View;

class ErrorController 
{   
    private $view;

    public function __construct() {
        $this->view = new View();
    }

    // Permet l'affichage de la page inconnue
    public function unknown()
    {
        $this->view->render('unknown');
    }

    //Permet l'affichage de la page d'erreur
    public function error()
    {
        $this->view->render('error');
    }

}