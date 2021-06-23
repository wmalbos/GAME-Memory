<?php

namespace App;

/**
 * La classe statistique permet de représenter une ligne du classement de joueur
 *
 * Pour aller plus loin : Pour améliorer la structure, il faudrait dissocier le modèle des requêtes
 * Pour cela il faudrait ce diriger vers une structure MVC ( Modèle Vue Controlleur )
 * Lien : https://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur
 */
class Statistic
{
    /**
     * Identifiant unique
     * @var integer
     */
    private $id;

    /**
     * Dénomination du joueur
     * @var string
     */
    private $player;

    /**
     * Score du joueur
     * @var integer
     */
    private $score;

    /**
     * Date de création de la donnée
     * @var \DateTime
     */
    private $created_at;

    /**
     * Requête sur la base de donnée pour récupérer toutes les statistiques
     *
     * Informations : Ici on utilise le mot clé "static", ainsi nous ne sommes
     * pas obligé d'instancier un objet pour pouvoir l'utiliser
     */
    public static function getTopStatistics($database)
    {
        // Liste des statistiques
        $statistics = [];

        // Connexion à la base de donnée
        $database->connect();

        // On execute une requête
        $query = 'SELECT * FROM memory_statistics';
        $response = $database->getConnexion()->query($query);

        // On récupère les résultats, puis on créer un objet pour chaque résultat
        while ($statistic = $response->fetchObject(__CLASS__)) {
            $statistics[] = $statistic;
        }

        // On termine le traitement de la requête
        $response->closeCursor();

        return $statistics;
    }

    public static function insertStatistic($database, $statistic)
    {

        // Connexion à la base de donnée
        $database->connect();

        // Préparation de la requête
        $query = 'INSERT INTO memory_statistics (player, score, created_at) VALUES (:player_name, :player_score, :created_at)';
        $stmt = $database->getConnexion()->prepare($query);

        // Execution de la requête
        $stmt->execute([
            'player_name' => $statistic->getPlayer(),
            'player_score' => $statistic->getScore(),
            'created_at' => $statistic->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPlayer(): ?string
    {
        return $this->player;
    }

    /**
     * @param string $player
     */
    public function setPlayer(?string $player): void
    {
        $this->player = $player;
    }

    /**
     * @return int
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(?int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return \DateTime|null
     * @throws \Exception
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(?\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
