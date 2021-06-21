<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\Statistic;

if (isset($_POST['rank_player_name']) && isset($_POST['rank_player_score'])) {

    // On nettoie les données pour éviter des failles
    $player_name = htmlspecialchars($_POST['rank_player_name']);
    $player_score = htmlspecialchars($_POST['rank_player_score']);

    // Création d'une nouvelle statistic
    $statistic = new Statistic();
    $statistic->setPlayer($player_name);
    $statistic->setScore($player_score);
    $statistic->setCreatedAt(new \DateTime('NOW'));

    // Sauvegarde de la statistic
    $database = new Database();

    Statistic::insertStatistic($database, $statistic);

}

header('Location: index.php');
die();