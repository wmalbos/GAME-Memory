<?php

namespace App;


/**
 * La classe Database permet de gérer l'accès à la base de donnée
 *
 * Pour aller plus loin : Il est possible d'utiliser ici le patron de conception nommé "Singleton"
 * Il permet de restreindre l'instanciation de cette classe à un seul objet
 * Lien : https://fr.wikipedia.org/wiki/Singleton_(patron_de_conception)
 *
 */
class Database
{
    /**
     * Tableau de la configuration de la base de donnée
     */
    private $configuration;

    /**
     * Connexion à la base de donnée
     */
    private $connexion;

    public function __construct()
    {
        $this->configuration = include 'assets/config/database.php';
    }

    /**
     * Connexion à la base de donnée
     */
    public function connect()
    {
        try {
            $this->connexion = new \PDO('mysql:dbname=' . $this->configuration['db_name'] . ';host=' . $this->configuration['db_host'] . ':' . $this->configuration['db_port'] . ';charset=utf8', $this->configuration['db_username'], $this->configuration['db_password']);
        } catch (\PDOException $e) {
            printf('Échec de la connexion : %s\n', $e->getMessage());
            exit();
        }
    }

    /**
     * @return mixed
     */
    public function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * @param mixed $connexion
     */
    public function setConnexion($connexion)
    {
        $this->connexion = $connexion;
    }

}
