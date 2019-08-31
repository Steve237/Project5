<?php

class Manager 
{

protected function dbconnect()
{

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=monblog;charset=utf8', 'root', '');
        
        return $db;
    }
    
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

}

}