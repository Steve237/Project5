<?php
namespace App\src\DAO;

use PDO;

abstract class DAO
{
   

    private $connection;

    /**
     * Permet de vérifier l'état de la connexion.
     */
    private function checkConnection()
    {
        //Vérifie si la connexion est nulle et fait appel à getConnection()
        if ($this->connection === null) {
            
            return $this->getConnection();
        }
        //Si la connexion existe, elle est renvoyée, inutile de refaire une connexion
        
        
        return $this->connection;
    }
    
    /**
     * Méthode pour gérer les requêtes à la base de données.
     */
    protected function sql($sql, $parameters = null)
    {
        if ($parameters)
        {
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);
            return $result;
        
        } else {
            
            $result = $this->checkConnection()->query($sql);
            return $result;
        }
    }
    
    /**
     * Fonction de connexion à la base de données
     */
    public function getConnection()
    {
        //Tentative de connexion à la base de données
        try{
            $connection = new PDO(DB_HOST, DB_USER , DB_PASS);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        }
        //On lève une erreur si la connexion échoue
        catch(Exception $errorConnection)
        {
            die ('Erreur de connection :'.$errorConnection->getMessage());
        }

    }
}
