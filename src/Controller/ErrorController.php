<?php

namespace App\src\Controller;

class ErrorController 
{   
    
    public function unknown()
    {
        require '../templates/unknown.php';
    }

    public function error()
    {
        require '../templates/error.php';
    }

}