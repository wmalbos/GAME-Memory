<?php

// On demande à afficher les erreurs distinctements ( /!\ à retirer en production /!\)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\Statistic;

// On récupère la base de donnée
$database = new Database();

// On récupère toutes les entrées des statistiques
$players = Statistic::getAllStatistics($database);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jeu de mémoire</title>
    <meta name="description" content="">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Rock+Salt&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Javascripts -->
    <script src="assets/js/game.js"></script>
</head>
<body>

<div id="game" class="memory-game">

    <!-- MENU - Nouvelle partie, Classements des joueurs, Github  -->
    <div id="menu" class="menu menu-general active">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Règles du jeu</h2>

                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-github"
                   target="_blank" rel="noopener">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github"
                         class="svg-inline--fa fa-github fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 496 512">
                        <path fill="currentColor"
                              d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path>
                    </svg>
                    Github</a>
            </div> <!-- /.menu-header-->

            <div class="menu-content">
                <ul class="rules-list">
                    <li class="rule">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                    <li class="rule">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pharetra metus
                        libero, eget commodo.
                    </li>
                    <li class="rule">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pharetra metus
                        libero, eget commodo quam dictum efficitur.
                    </li>
                    <li class="rule">Lorem ipsum dolor sit amet, consectetur adipiscing elit quisque pharetra metus.
                    </li>
                </ul>
            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button id="btn_play" class="btn btn-replay">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google-play"
                         class="svg-inline--fa fa-google-play fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512">
                        <path fill="currentColor"
                              d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path>
                    </svg>
                    <span>Nouvelle partie</span>
                </button>
                <button class="btn btn-ranking"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="medal" class="svg-inline--fa fa-medal fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M223.75 130.75L154.62 15.54A31.997 31.997 0 0 0 127.18 0H16.03C3.08 0-4.5 14.57 2.92 25.18l111.27 158.96c29.72-27.77 67.52-46.83 109.56-53.39zM495.97 0H384.82c-11.24 0-21.66 5.9-27.44 15.54l-69.13 115.21c42.04 6.56 79.84 25.62 109.56 53.38L509.08 25.18C516.5 14.57 508.92 0 495.97 0zM256 160c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm92.52 157.26l-37.93 36.96 8.97 52.22c1.6 9.36-8.26 16.51-16.65 12.09L256 393.88l-46.9 24.65c-8.4 4.45-18.25-2.74-16.65-12.09l8.97-52.22-37.93-36.96c-6.82-6.64-3.05-18.23 6.35-19.59l52.43-7.64 23.43-47.52c2.11-4.28 6.19-6.39 10.28-6.39 4.11 0 8.22 2.14 10.33 6.39l23.43 47.52 52.43 7.64c9.4 1.36 13.17 12.95 6.35 19.59z"></path></svg> <span>Classement des joueurs</span></button>

                <button class="menu-close">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                </button>

            </div> <!-- /.menu-list -->
        </div> <!-- /.menu-container -->
    </div> <!-- /.menu -->

    <!-- MENU des classements - Affiche les joueurs par ordre de leurs score -->
    <div id="menu_ranking" class="menu menu-ranking">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Classements</h2>

                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-github"
                   target="_blank" rel="noopener">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github"
                         class="svg-inline--fa fa-github fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 496 512">
                        <path fill="currentColor"
                              d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path>
                    </svg>
                    Github</a>
            </div> <!-- /.menu-header -->

            <div class="menu-content">
                <?php if (count($players) > 0) { ?>
                    <ul class="ranks-list">
                        <?php foreach ($players as $key => $item) { ?>
                            <li class="rank"><?php echo 'Joueur n°' . ($key + 1) . ' : ' . $item->getPlayer() . ' avec un score de ' . $item->getScore() . ' - ' ?></li>
                        <?php } ?>
                    </ul> <!-- /.menu-list -->
                <?php } else { ?>
                    <p class="empty">Aucune donnée disponible</p>
                <?php } ?>
            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button class="menu-close">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                </button>

                <button id="btn_ranking_return" class="btn btn-return">Retour</button>
            </div> <!-- /.menu-controls -->

        </div> <!-- /.menu-container -->
    </div>

    <!-- MENU de victoire -->
    <div id="menu_victory" class="menu menu-victory">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Victoire !</h2>

                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-github"
                   target="_blank" rel="noopener">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github"
                         class="svg-inline--fa fa-github fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 496 512">
                        <path fill="currentColor"
                              d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path>
                    </svg>
                    Github</a>
            </div> <!-- /.menu-header-->

            <div class="menu-content">

                <?php if (count($players) > 0) { ?>
                    <ul class="item-list">
                        <?php foreach ($players as $key => $item) { ?>
                            <li class="item"><?php echo 'Joueur n°' . ($key + 1) . ' : ' . $item->getPlayer() . ' avec un score de ' . $item->getScore() . ' - ' ?></li>
                        <?php } ?>
                    </ul> <!-- /.menu-list -->
                <?php } else { ?>
                    <p class="empty">Aucune donnée disponible</p>
                <?php } ?>

                <form action="action.php" method="post" class="form form-rank">
                    <div class="form-group">
                        <label for="rank_player_name">Nom du joueur :</label>
                        <input type="text" name="rank_player_name" id="rank_player_name">
                        <input type="hidden" name="rank_player_score" id="rank_player_score" value="100">
                    </div> <!-- /.form-group -->
                    <div class="form-controls">
                        <input type="submit" id="rank_player_submit" value="Enregistrer">
                    </div> <!-- /.form-group -->
                </form> <!-- /.form-rank -->
            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button class="menu-close">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                </button>

                <button id="btn_victory_replay" class="btn btn-replay">Rejouer</button>
                <button class="btn btn-ranking">Classement</button>
                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-documentation"
                   target="_blank" rel="noopener">Documentation</a>
            </div> <!-- /.menu-controls -->
        </div> <!-- /.menu-container -->
    </div> <!-- /.menu-victory -->

    <!-- MENU de défaite -->
    <div id="menu_loose" class="menu menu-loose">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Défaite...</h2>

                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-github"
                   target="_blank" rel="noopener">
                    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="github"
                         class="svg-inline--fa fa-github fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 496 512">
                        <path fill="currentColor"
                              d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path>
                    </svg>
                    Github</a>
            </div> <!-- /.menu-header-->

            <div class="menu-content">

            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button class="menu-close">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                </button>

                <button id="btn_loose_replay" class="btn btn-replay">Rejouer</button>
                <button class="btn btn-ranking">Classement</button>
                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-documentation"
                   target="_blank" rel="noopener">Documentation</a>
            </div> <!-- /.menu-controls -->
        </div> <!-- /.menu-container -->
    </div> <!-- /.menu-loose -->

    <!-- Plateau - Le plateau du jeu contient toutes les cartes disposées sur la table de jeu -->
    <div id="board" class="board">

        <div class="board-header">
            <h1 class="board-title">Jeu de mémoire</h1>
            <div class="board-menu">
                <button id="board_menu" class="btn-menu">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars"
                         class="svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 448 512">
                        <path fill="currentColor"
                              d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path>
                    </svg>
                    <span>MENU</span></button>
            </div>
        </div> <!-- /.card-header -->

        <div class="board-content">
            <ul id="cards_list" class="cards-list"></ul> <!-- /.card-list -->
        </div><!-- /.board-content -->

        <div class="board-footer">
            <div class="board-stats">
                <div class="column">
                    <div class="block block-games">
                        <p class="block-label">Nombre de parties : <span id="game_counter" class="block-value">0</span>
                        </p>
                    </div> <!-- /.block -->

                    <div class="block block-counter">
                        <p class="block-label">Nombre de coups : <span id="shots_counter" class="block-value">3</span>
                        </p>
                    </div> <!-- /.block -->

                    <div class="block block-level">
                        <p class="block-label">Difficulté : <span class="block-value">
                                <?php for ($i = 0; $i < 3; $i++) { ?>
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                         data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path fill="currentColor"
                                                          d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                                                </svg>
                                <?php } ?>
                            </span></p>
                    </div> <!-- /.block -->
                </div> <!-- /.column -->

                <div class="column">
                    <div class="block block-time">
                        <p class="block-label">Temps restant : <span class="block-value"><span id="timer_min">0</span> min et <span
                                        id="timer_sec">0</span> sec</span></p>
                        <div class="progress">
                            <div id="progress" class="progress-content"></div>
                        </div> <!-- /.progress -->
                    </div> <!-- /.block -->
                </div> <!-- /.column -->
            </div> <!-- /.board-stats -->
        </div> <!-- /.card-header -->

        <!-- OPTIONNEL - Cette section n'est utilisée que pour rajouter un peu de design -->
        <div class="design-board">
            <div class="corner corner-top-left"></div> <!-- /.corner -->
            <div class="corner corner-top-right"></div> <!-- /.corner -->
            <div class="corner corner-bottom-right"></div> <!-- /.corner -->
            <div class="corner corner-bottom-left"></div> <!-- /.corner -->
        </div> <!-- /.design -->

    </div> <!-- /.board -->

    <!-- OPTIONNEL - Cette section n'est utilisée que pour rajouter un peu de design -->
    <div class="design-game">
        <div class="corner corner-top-right">
            <div class="figure">
                <img src="/assets/images/fruits_1.png" alt="">
            </div>
        </div> <!-- /.corner -->
        <div class="corner corner-bottom-right">
            <div class="figure">
                <img src="/assets/images/fruits_2.png" alt="">
            </div>
        </div> <!-- /.corner -->
        <div class="corner corner-bottom-left">
            <div class="figure">
                <img src="/assets/images/fruits_3.png" alt="">
            </div>
        </div> <!-- /.corner -->
    </div> <!-- /.design -->

</div> <!-- /.game -->

</body>
</html>