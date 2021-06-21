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
    const DB_USERNAME = 'root';
    const DB_PASSWORD = 'root';
    const DB_HOST = '127.0.0.1';
    const DB_PORT = '8889';
    const DB_NAME = 'memory_game';

    private $connexion;

    /**
     * Connexion à la base de donnée
     */
    public function connect()
    {
        try {
            $this->connexion = new \PDO('mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST . ':'.self::DB_PORT.';charset=utf8', self::DB_USERNAME, self::DB_PASSWORD);
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
