document.addEventListener('DOMContentLoaded', function () {

    // MENU
    let menu_general = document.getElementById('menu');
    let btn_play = document.getElementById('btn_play');
    let btn_ranking = document.getElementById('btn_ranking');

    let menu_ranking = document.getElementById('menu_ranking');
    let btn_ranking_return = document.getElementById('btn_ranking_return');

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


    btn_play.click();

}, false);


class Game {

    constructor() {
        this.board = new Board()
    }

    // Création d'une nouvelle partie
    newGame() {
        this.board.newBoard(10);
    }


}

class Board {

    dom_board = document.getElementById('board'); // Plateau de jeu du DOM
    dom_cards_list = document.getElementById('cards_list'); // Liste des cartes de jeu du DOM

    constructor() {

        // Création de toutes les cartes utilisables du jeu
        this.init_cards = [];
        this.init_cards.push(new Card(1, 'assets/images/'));
        this.init_cards.push(new Card(2, 'assets/images/'));
        this.init_cards.push(new Card(3, 'assets/images/'));
        this.init_cards.push(new Card(4, 'assets/images/'));
        this.init_cards.push(new Card(5, 'assets/images/'));

        // Liste des cartes du plateau
        this.cards = [];

    }

    // Création d'un nouveau plateau de jeu
    newBoard(pair_numbers) {

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

            // Ajout d'une face avant
            var front_face = document.createElement("div");
            front_face.classList.add('front-face');
            new_node.appendChild(front_face);

            // Ajout d'une face arrière
            var back_face = document.createElement("div");
            back_face.classList.add('back-face');

            var image = document.createElement("img");
            image.src = this.cards[i].image;
            image.alt = 'Carte n°' + this.cards[i].value;
            back_face.appendChild(image);
            new_node.appendChild(back_face);

            // Ajout de la carte sur le plateau
            this.dom_cards_list.appendChild(new_node);
        }
    }

    // Création d'une nouvelle paire de cartes
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

    }


}

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