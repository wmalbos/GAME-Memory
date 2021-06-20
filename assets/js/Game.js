document.addEventListener('DOMContentLoaded', function () {

    // MENU
    let menu_general = document.getElementById('menu');
    let btn_play = document.getElementById('btn_play');
    let btn_ranking = document.getElementById('btn_ranking');

    let menu_ranking = document.getElementById('menu_ranking');
    let btn_ranking_return = document.getElementById('btn_ranking_return');

    let menu_victory = document.getElementById('menu_victory');
    let btn_replay = document.getElementById('btn_replay');

    // Jeu
    let game = new Game();

    /**
     * Ecoute l'évènement de clique sur le bouton du menu "Jouer",
     * Démarre une nouvelle partie
     */
    btn_play.addEventListener('click', (event) => {
        event.preventDefault();

        // Changement de fenêtre
        menu_general.classList.remove('active');

        // Lancement du jeu
        game.newGame();
    });

    /**
     * Ecoute l'évènement de clique sur le bouton du menu "Classement",
     * Ouvre la fenêtre de classement des joueurs
     */
    btn_ranking.addEventListener('click', (event) => {
        event.preventDefault();

        // Changement de fenêtre
        menu_general.classList.remove('active');
        menu_ranking.classList.add('active');
    });

    /**
     * Ecoute l'évènement de clique sur le bouton de retour du menu "Classement",
     * Ferme la fenêtre et affiche celle du menu de base
     */
    btn_ranking_return.addEventListener('click', (event) => {
        event.preventDefault();

        // Changement de fenêtre
        menu_ranking.classList.remove('active');
        menu_general.classList.add('active');
    });

    /**
     * Ecoute l'évènement de clique sur le bouton du menu "Rejouer",
     * Démarre une nouvelle partie
     */
    btn_replay.addEventListener('click', (event) => {
        event.preventDefault();

        // Changement de fenêtre
        menu_victory.classList.remove('active');

        // Lancement du jeu
        game.restart();
    });

    btn_play.click();

}, false);


/**
 * La classe Game comporte gère les élements généraux du jeu ( Menu, Score, Plateau, ... )
 */
class Game {

    pair_numbers = 1; // Nombre de paires de cartes dans la partie
    timer = null; // Décomtpe restant avant la fin de la partie
    game_counter = 0; // Nombre de parties jouées

    constructor() {
        this.board = new Board(this)

        this.dom_menu_victory = document.getElementById('menu_victory');
        this.dom_game_counter = document.getElementById('game_counter');
    }

    // Création d'une nouvelle partie
    newGame() {
        // Nombre de partie jouées
        this.game_counter++;
        this.dom_game_counter.innerText = this.game_counter;

        // On réinitialise le plateau
        this.board.newBoard(this.pair_numbers);
    }

    // Relance une nouvelle partie
    restart() {
        // Nombre de partie jouées
        this.game_counter++;
        this.dom_game_counter.innerText = this.game_counter;

        // On réinitialise le plateau
        this.board.newBoard(this.pair_numbers);
    }

    // Met en pause la partie en cours
    pause() {

    }

    // Quitte la partie en cours
    stop() {

    }


    // Victoire du joueur
    winGame() {
        this.dom_menu_victory.classList.add('active');
    }

    // Défaite du joueur
    loseGame() {

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
        this.init_cards.push(new Card(1, 'assets/images/card_1.png'));
        this.init_cards.push(new Card(2, 'assets/images/card_2.png'));
        this.init_cards.push(new Card(3, 'assets/images/card_3.png'));
        this.init_cards.push(new Card(4, 'assets/images/card_4.png'));
        this.init_cards.push(new Card(5, 'assets/images/card_5.png'));
        // this.init_cards.push(new Card(6, 'assets/images/card_6.png'));
        // this.init_cards.push(new Card(7, 'assets/images/card_7.png'));
        // this.init_cards.push(new Card(8, 'assets/images/card_8.png'));
        // this.init_cards.push(new Card(9, 'assets/images/card_9.png'));
        // this.init_cards.push(new Card(10, 'assets/images/card_10.png'));
        // this.init_cards.push(new Card(11, 'assets/images/card_11.png'));
        // this.init_cards.push(new Card(12, 'assets/images/card_12.png'));

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

                            board.current_hand = [];
                        }, 750)
                    } else {
                        // Les valeurs sont identiques, on les laisse retourné et on continue
                        board.current_hand = [];

                        // On sauvegarde les cartes retournées
                        board.return_cards.push(first_card);
                        board.return_cards.push(second_card);

                        // On vérifie si le joueur à gagné
                        if( board.checkEndGame()){
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
    clearBoard(){

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