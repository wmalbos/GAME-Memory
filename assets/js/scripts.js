import Game from './Game.js'

/**
 * Ecoute de la fin de chargement du DOM
 */
document.addEventListener('DOMContentLoaded', function () {

    // Menus
    const menu_general = document.getElementById('menu');
    const menu_ranking = document.getElementById('menu_ranking');
    const menu_victory = document.getElementById('menu_victory');
    const menu_loose = document.getElementById('menu_loose');

    // Boutons
    const btn_replay = document.getElementsByClassName('btn-replay');
    const btn_ranking = document.getElementsByClassName('btn-ranking');
    const btn_ranking_return = document.getElementById('btn_ranking_return');
    const btn_board_menu = document.getElementById('board_menu');
    const btn_menu_close = document.getElementsByClassName('menu-close');

    // Jeu Memory
    const game = new Game();

    /**
     * Ecoute l'évènement de clique sur les boutons "Nouvelle partie" du menu,
     * Démarre une nouvelle partie
     */
    for (let i = 0; i < btn_replay.length; i++) {
        btn_replay[i].addEventListener('click', event => {
            event.preventDefault();

            // Changement de la fenêtre active
            menu_general.classList.remove('active');
            menu_victory.classList.remove('active');
            menu_loose.classList.remove('active');

            // Lancement du jeu
            game.newGame();
        });
    }

    /**
     * Ecoute l'évènement de clique sur les boutons "Classement de joueurs" du menu,
     * Ouvre la fenêtre de classement des joueurs
     */
    for (let i = 0; i < btn_ranking.length; i++) {
        btn_ranking[i].addEventListener('click', event => {
            event.preventDefault();

            // Changement de la fenêtre active
            menu_general.classList.remove('active');
            menu_victory.classList.remove('active');
            menu_loose.classList.remove('active');
            menu_ranking.classList.add('active');
        });
    }

    /**
     * Ecoute l'évènement de clique sur les boutons "Fermer" du menu,
     * Ferme tous les menus
     */
    for (let i = 0; i < btn_menu_close.length; i++) {
        btn_menu_close[i].addEventListener('click', event => {
            event.preventDefault();

            // Fermeture de toutes les fenêtres
            menu_general.classList.remove('active');
            menu_ranking.classList.remove('active');
            menu_victory.classList.remove('active');
            menu_loose.classList.remove('active');
        });
    }

    /**
     * Ecoute l'évènement de clique sur le bouton "Retour" du menu,
     * Ferme la fenêtre et affiche celle du premier menu
     */
    btn_ranking_return.addEventListener('click', event => {
        event.preventDefault();

        // Changement de la fenêtre active
        menu_ranking.classList.remove('active');
        menu_general.classList.add('active');
    });

    /**
     * Ecoute l'évènement de clique sur le bouton "MENU" du plateau de jeu,
     */
    btn_board_menu.addEventListener('click', event => {
        event.preventDefault();

        // Changement de la fenêtre active
        menu_ranking.classList.remove('active');
        menu_victory.classList.remove('active');
        menu_loose.classList.remove('active');
        menu_general.classList.add('active');

        // Arrête la partie en cours
        // Idée d'amélioration : Fonctionnalité pour mettre le jeu en pause / le reprendre
        this.game.stop();
    });

}, false);