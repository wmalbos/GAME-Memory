<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\Statistic;

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
    <div id="menu" class="menu menu-general">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Jeux de mémoire</h2>
                <div class="menu-figure">
                    <img src="../assets/images/menu-header.png" alt="Menu - Memory">
                </div> <!-- /.menu-figure -->
            </div> <!-- /.menu-header-->

            <div class="menu-controls">
                <button id="btn_play" class="btn btn-replay">Jouer</button>
                <button class="btn btn-ranking">Classement</button>
                <a href="https://github.com/wmalbos/GAME-Memory" class="btn btn-documentation"
                   target="_blank" rel="noopener">Documentation</a>
            </div> <!-- /.menu-list -->
        </div> <!-- /.menu-container -->
    </div> <!-- /.menu -->

    <!-- MENU des classements - Affiche les joueurs par ordre de leurs score -->
    <div id="menu_ranking" class="menu menu-ranking">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Classements</h2>
            </div> <!-- /.menu-header -->

            <div class="menu-content">
                <?php if (count($players) > 0) { ?>
                    <ul class="item-list">
                        <?php foreach ($players as $key => $item) { ?>
                            <li class="item"><?php echo 'Joueur n°' . ($key + 1) . ' : ' . $item->getPlayer() . ' avec un score de ' . $item->getScore() . ' - '  ?></li>
                        <?php } ?>
                    </ul> <!-- /.menu-list -->
                <?php } else { ?>
                    <p class="empty">Aucune donnée disponible</p>
                <?php } ?>
            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button id="btn_ranking_return" class="btn btn-return">Retour</button>
            </div> <!-- /.menu-controls -->

        </div> <!-- /.menu-container -->
    </div>

    <!-- MENU de victoire -->
    <div id="menu_victory" class="menu menu-victory active">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Victoire !</h2>
            </div> <!-- /.menu-header-->

            <div class="menu-content">

                <?php if (count($players) > 0) { ?>
                    <ul class="item-list">
                        <?php foreach ($players as $key => $item) { ?>
                            <li class="item"><?php echo 'Joueur n°' . ($key + 1) . ' : ' . $item->getPlayer() . ' avec un score de ' . $item->getScore() . ' - '  ?></li>
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
            </div> <!-- /.menu-header-->

            <div class="menu-content">

            </div> <!-- /.menu-content -->

            <div class="menu-controls">
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
            <div class="board-stats">
                <div class="block block-games">
                    <p class="block-label">Nombre de parties : <span id="game_counter" class="block-value">0</span></p>
                </div> <!-- /.block -->

                <div class="block block-counter">
                    <p class="block-label">Nombre de coups : <span id="shots_counter" class="block-value">3</span></p>
                </div> <!-- /.block -->

                <div class="block block-level">
                    <p class="block-label">Difficulté : <span class="block-value">1</span></p>
                </div> <!-- /.block -->

                <div class="block block-time">
                    <p class="block-label">Temps restant : <span class="block-value"><span id="timer_min">0</span> min et <span
                                    id="timer_sec">0</span> sec</span></p>
                    <div class="progress">
                        <div id="progress" class="progress-content"></div>
                    </div> <!-- /.progress -->
                </div> <!-- /.block -->
            </div> <!-- /.board-stats -->
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

        <ul id="cards_list" class="cards-list"></ul> <!-- /.card-list -->
    </div> <!-- /.board -->

</div> <!-- /.game -->
</body>
</html>