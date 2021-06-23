document.addEventListener('DOMContentLoaded', function () {

    // MENU
    let menu_general = document.getElementById('menu');
    let menu_ranking = document.getElementById('menu_ranking');
    let menu_victory = document.getElementById('menu_victory');
    let menu_loose = document.getElementById('menu_loose');

    let btn_replay = document.getElementsByClassName('btn-replay');
    let btn_ranking = document.getElementsByClassName('btn-ranking');
    let btn_ranking_return = document.getElementById('btn_ranking_return');
    let btn_board_menu = document.getElementById('board_menu');

    // Jeu Memory
    let game = new Game();

    /**
     * Ecoute l'évènement de clique sur les boutons du menu "Jouer / Rejouer",
     * Démarre une nouvelle partie
     */
    for (let i = 0; i < btn_replay.length; i++) {
        btn_replay[i].addEventListener('click', (event) => {
            event.preventDefault();

            // Changement de fenêtre
            menu_general.classList.remove('active');
            menu_victory.classList.remove('active');
            menu_loose.classList.remove('active');

            // Lancement du jeu
            game.newGame();
        });
    }

    /**
     * Ecoute l'évènement de clique sur les boutons du menu "Classement",
     * Ouvre la fenêtre de classement des joueurs
     */
    for (let i = 0; i < btn_ranking.length; i++) {
        btn_ranking[i].addEventListener('click', (event) => {
            event.preventDefault();

            // Changement de fenêtre
            menu_general.classList.remove('active');
            menu_victory.classList.remove('active');
            menu_loose.classList.remove('active');
            menu_ranking.classList.add('active');
        });
    }

    /**
     * Ecoute l'évènement de clique sur les boutons de retour du menu "Classement",
     * Ferme la fenêtre et affiche celle du menu de base
     */
    btn_ranking_return.addEventListener('click', (event) => {
        event.preventDefault();

        // Changement de fenêtre
        menu_ranking.classList.remove('active');
        menu_general.classList.add('active');
    });

    btn_board_menu.addEventListener('click', (event) => {
        event.preventDefault();

        // Changement de fenêtre
        menu_ranking.classList.remove('active');
        menu_victory.classList.remove('active');
        menu_loose.classList.remove('active');
        menu_general.classList.add('active');

        this.game.stop();
    });

}, false);


/**
 * La classe Game comporte gère les élements généraux du jeu ( Menu, Score, Plateau, ... )
 */
class Game {

    pair_numbers = 9; // Nombre de paires de cartes dans la partie
    game_duration = 120; // Décompte restant avant la fin de la partie en secondes
    countdown = null; // Compte à rebours
    game_counter = 0; // Nombre de parties jouées

    constructor() {
        this.board = new Board(this);

        this.dom_menu_victory = document.getElementById('menu_victory');
        this.dom_menu_loose = document.getElementById('menu_loose');
        this.dom_game_counter = document.getElementById('game_counter');

        // Fichiers audio
        this.audio_error = new Audio('assets/audio/error.mp3');
        this.audio_success = new Audio('assets/audio/success.mp3');
        this.audio_victory = new Audio('assets/audio/victory.mp3');
        this.audio_failed = new Audio('assets/audio/failed.mp3');
        this.audio_flip = new Audio('assets/audio/flip.mp3');

        // Création du compteur de temps
        this.countdown = new Countdown(this);
    }

    // Création d'une nouvelle partie
    newGame() {
        // Nombre de partie jouées
        this.game_counter++;
        this.dom_game_counter.innerText = this.game_counter;

        // On réinitialise le plateau
        this.board.newBoard(this.pair_numbers);

        // Gestion du décompte
        this.countdown.start(this.game_duration);
    }

    // Victoire du joueur
    winGame() {
        this.countdown.stop();
        this.dom_menu_victory.classList.add('active');

        // On joue un son de victoire
        this.audio_victory.volume = 1;
        this.audio_victory.play();
    }

    // Défaite du joueur
    loseGame() {
        this.countdown.stop();
        this.dom_menu_loose.classList.add('active');

        // On joue un son de défaite
        this.audio_failed.volume = 1;
        this.audio_failed.play();
    }
}

/**
 * La classe Board gère tous les élements relatifs au plateau de jeu ( Cartes, coups, ... )
 */
class Board {

    shots_played = 0; // Nombre de coups joués

    constructor(game) {

        // Sauvegarde du jeu
        this.game = game;

        // Liste des cartes de jeu du DOM
        this.dom_cards_list = document.getElementById('cards_list');
        this.dom_shots_counter = document.getElementById('shots_counter');

        // Création de toutes les cartes utilisables du jeu
        this.init_cards = [];
        for(let i = 1; i <= 12; i++){
            this.init_cards.push(new Card(i, `assets/images/card_${i}.png`));
        }

        // Liste des cartes du plateau
        this.cards = [];

        // Liste des cartes retournées du plateau
        this.return_cards = [];

        // Main courrante
        this.current_hand = [];

    }

    // Création d'un nouveau plateau de jeu
    newBoard(pair_numbers) {

        // Remise à zéro du plateau de jeu
        this.clearBoard();

        // Création de X paires de cartes
        for (let i = 0; i < pair_numbers; i++) {
            this.newCardPair();
        }

        // Mélange des cartes de jeu
        this.shuffleCards();

        // Insertion des cartes sur le plateau de jeu
        for (let i = 0; i < this.cards.length; i++) {

            // Création du nouveau noeuds
            var new_node = document.createElement("li");
            new_node.classList.add('card');
            new_node.id = `card_${i}`;
            new_node.dataset.position = i;
            new_node.dataset.type = this.cards[i].value;

            // Ajout d'une face avant
            var front_face = document.createElement("div");
            front_face.classList.add('back-face');
            new_node.appendChild(front_face);

            // Ajout d'une face arrière
            var back_face = document.createElement("div");
            back_face.classList.add('front-face');

            var image = document.createElement("img");
            image.src = this.cards[i].image;
            image.alt = 'Carte n°' + this.cards[i].value;
            back_face.appendChild(image);

            new_node.appendChild(back_face);

            // Ajout de la carte sur le plateau
            this.dom_cards_list.appendChild(new_node);
        }

        // Listener lors du click sur une carte
        for (let i = 0; i < this.cards.length; i++) {
            let card = document.getElementById(`card_${i}`);
            let board = this; // On met le plateau de côté car "this" deviendra la carte dans le listener

            card.addEventListener('click', function (event) {
                event.preventDefault();

                let position = this.dataset.position;
                let value = this.dataset.type;

                // On retourne la carte
                let element = document.getElementById(`card_${position}`)
                element.classList.add('active')

                // On joue un son
                board.game.audio_flip.volume = 1;
                board.game.audio_flip.play();

                // On ajoute la carte choisie à la main courante
                board.current_hand.push(position);

                // On vérifie si les cartes retourner sont égales
                if (board.current_hand.length === 2) {

                    // On incrémente le compteur de coups
                    board.shots_played++;
                    board.dom_shots_counter.innerText = board.shots_played;

                    let first_card = board.cards[board.current_hand[0]];
                    let second_card = board.cards[board.current_hand[1]];

                    if (first_card.value !== second_card.value) {
                        // Les valeurs sont différentes, on attends quelques millisecondes, et on retourne les cartes
                        setTimeout(function () {
                            // Les valeurs sont différentes, on remet les cartes face cachés
                            let dom_first_card = document.getElementById(`card_${board.current_hand[0]}`)
                            dom_first_card.classList.remove('active')

                            let dom_second_card = document.getElementById(`card_${board.current_hand[1]}`)
                            dom_second_card.classList.remove('active')

                            // On joue un son d'echec
                            board.game.audio_error.volume = 0.4;
                            board.game.audio_error.play();

                            board.current_hand = [];
                        }, 750)
                    } else {
                        // Les valeurs sont identiques, on les laisse retourné et on continue
                        board.current_hand = [];

                        // On sauvegarde les cartes retournées
                        board.return_cards.push(first_card);
                        board.return_cards.push(second_card);

                        // On joue un son de success
                        board.game.audio_success.volume = 1;
                        board.game.audio_success.play();

                        // On vérifie si le joueur à gagné
                        if (board.checkEndGame()) {
                            setTimeout(function () {
                                board.game.winGame();
                            }, 750)
                        }
                    }

                }
            });
        }
    }

    // Réinitialise le plateau de jeu
    clearBoard() {

        // On réinitialise les listes
        this.cards = [];
        this.return_cards = [];

        // Suppression des elements du DOM
        this.dom_cards_list.innerHTML = '';
        this.dom_shots_counter.innerText = '0';

    }

    // Création d'une nouvelle paire de cartes
    // que l'on ajoutes à la liste de toutes les cartes
    newCardPair() {

        // Retourne une nombre aléatoire compris entre 0 et le nombre maximum de cartes disponibles
        let random_value = Math.random() * (this.init_cards.length - 1);
        // Retourne la partie entière de la valeur
        random_value = Math.trunc(random_value);

        // Copies de la carte sélectionnée
        this.cards.push(this.init_cards[random_value].clone());
        this.cards.push(this.init_cards[random_value].clone());
    }

    // Mélange toutes les cartes du jeu
    shuffleCards() {
        var currentIndex = this.cards.length, temporaryValue, randomIndex;

        while (currentIndex !== 0) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;
            temporaryValue = this.cards[currentIndex];
            this.cards[currentIndex] = this.cards[randomIndex];
            this.cards[randomIndex] = temporaryValue;
        }
    }

    // Vérification de fin de partie
    checkEndGame() {

        // On compte s'il y a autant de carte retournée que de carte total sur le plateau
        if (this.cards.length === this.return_cards.length) {
            return true;
        }

        return false;

        // A la place, on peu aussi écrire une condition ternaire
        // "return (this.cards.length === this.return_cards.length)"
    }
}

/**
 * La classe Card gère tous les élements relatifs à une carte de jeu ( Valeur, Image )
 */
class Card {
    constructor(value, image) {
        this.value = value;
        this.image = image;
    }

    // Créer une réplique de la carte
    clone() {
        return new Card(this.value, this.image);
    }
}

/**
 * La classe CountDown permet de gérer un compte à rebour
 */
class Countdown {

    time_total = null; // Temps initial du décompte en secondes
    time_duration = null; // Temps restant du décompte en secondes
    time_transition = 1000; // Interval du timer en millisecondes
    is_running = false; // Le timer est en cours de décompte ?
    is_finished = false; // Le timer est terminé ?
    timer_timeout = null; // Objet setTimeout, il faut penser à le supprimer une fois utilisé

    constructor(game) {
        this.game = game;

        this.dom_minutes = document.getElementById('timer_min');
        this.dom_secondes = document.getElementById('timer_sec');
        this.dom_progress = document.getElementById('progress');
    }

    // Démarrage du timer
    start(secondes) {
        this.stop();

        this.time_total = secondes;
        this.time_duration = this.time_total;

        this.is_running = true;
        this.update_gui();
        this.update();
    }

    // Mise à jours du timer
    update() {
        if (this.is_running) {
            if (this.time_duration > 0) {
                let timer = this;
                this.timer_timeout = setTimeout(function () {
                    timer.time_duration -= (timer.time_transition / 1000);
                    timer.update_gui();
                    timer.update();
                }, this.time_transition);
            } else {
                this.is_finished = true;
                clearTimeout(this.timer_timeout);
                this.game.loseGame();
            }
        }
    }

    // Arrête le décompte
    stop() {
        this.is_running = false;
        clearTimeout(this.timer_timeout);
    }

    // Mise à jour de l'interface utilisateur
    update_gui() {
        this.dom_minutes.innerText = Math.trunc(this.time_duration / 60);
        this.dom_secondes.innerText = this.time_duration % 60;

        let percent = this.time_duration * 100 / this.time_total;

        this.dom_progress.classList.remove('default')
        this.dom_progress.classList.remove('warning')
        this.dom_progress.classList.remove('danger')

        if (percent < 10) {
            this.dom_progress.classList.add('danger')
        } else if (percent < 25) {
            this.dom_progress.classList.add('warning')
        } else {
            this.dom_progress.classList.add('default')
        }

        this.dom_progress.style.width = `${100 - percent}%`
    }
}