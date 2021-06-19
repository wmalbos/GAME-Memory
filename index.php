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
                <h1 class="menu-title">Jeux de mémoire</h1>
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
                        <li class="item"><?php echo 'Joueur n°' .($key + 1) . ' : ' . $item['player'] . ' avec un score de ' . $item['score']; ?></li>
                    <?php } ?>
                </ul> <!-- /.menu-list -->
            </div> <!-- /.menu-content -->

            <div class="menu-controls">
                <button id="btn_ranking_return" class="btn btn-return">Retour</button>
            </div> <!-- /.menu-controls -->

        </div> <!-- /.menu-container -->
    </div>

    <!-- Plateau - Le plateau du jeu contient toutes les cartes disposées sur la table de jeu -->
    <div id="board" class="board">
        <ul id="cards_list" class="cards-list"></ul> <!-- /.card-list -->
    </div> <!-- /.board -->

</div> <!-- /.game -->
</body>
</html>