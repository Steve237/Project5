<?php

class Manager 
{

    protected function dbconnect()
    {

        try
        {
            $dtb = new PDO('mysql:host=localhost;dbname=monblog;charset=utf8', 'root', '');

            $dtb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dtb;
        }

        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }

    }
}