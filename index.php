<?php

// Liste des 10 meilleurs joueurs
$ranking = [
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
    ['player' => 'John Smith', 'score' => 10],
]

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
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/game.js"></script>
</head>
<body>


<div id="game" class="memory-game">

    <!-- MENU - Nouvelle partie, Classements des joueurs, Github  -->
    <div id="menu" class="menu menu-general active">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Jeux de mémoire</h2>
                <div class="menu-figure">
                    <img src="../assets/images/menu-header.png" alt="Menu - Memory">
                </div> <!-- /.menu-figure -->
            </div> <!-- /.menu-header-->

            <div class="menu-content">
                <button id="btn_play" class="btn btn-play">Jouer</button>
                <button id="btn_ranking" class="btn btn-ranking">Classement</button>
                <a href="https://github.com/wmalbos/GAME-Memory" id="documentation" class="btn btn-documentation"
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
                <ul class="item-list">
                    <?php foreach ($ranking as $key => $item) { ?>
                        <li class="item"><?php echo 'Joueur n°' . ($key + 1) . ' : ' . $item['player'] . ' avec un score de ' . $item['score']; ?></li>
                    <?php } ?>
                </ul> <!-- /.menu-list -->
            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button id="btn_ranking_return" class="btn btn-return">Retour</button>
            </div> <!-- /.menu-controls -->

        </div> <!-- /.menu-container -->
    </div>

    <!-- MENU de victoire -->
    <div id="menu_victory" class="menu menu-victory">
        <div class="menu-container">
            <div class="menu-header">
                <h2 class="menu-title">Victoire !</h2>
            </div> <!-- /.menu-header-->

            <div class="menu-content">

            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button id="btn_replay" class="btn btn-replay">Rejouer</button>
            </div> <!-- /.menu-controls -->
        </div> <!-- /.menu-container -->
    </div> <!-- /.menu-victory -->

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
                    <p class="block-label">Temps restant : <span class="block-value">0 min et 30 sec</span></p>
                </div> <!-- /.block -->
            </div> <!-- /.board-stats -->
        </div> <!-- /.card-header -->

        <ul id="cards_list" class="cards-list"></ul> <!-- /.card-list -->
    </div> <!-- /.board -->

</div> <!-- /.game -->
</body>
</html>