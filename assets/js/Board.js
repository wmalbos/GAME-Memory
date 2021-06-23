import Card from './Card.js'

/**
 * La classe Board gère tous les elements relatifs au plateau de jeu ( Cartes, nombre de coups, ... )
 */
export default class Board {

    shots_played = 0; // Nombre de coups joués

    total_cards_length = 12; // Nombre total de cartes de jeu utilisables
    init_cards = []; // Cartes de jeu utilisables

    cards = []; // Liste des cartes du plateau
    return_cards = []; // Liste des cartes retournées du plateau
    current_hand = []; // Main courrante

    constructor(game) {
        // Lien vers l'objet Game
        this.game = game;

        // Elements du DOM
        this.dom_cards_list = document.getElementById('cards_list');
        this.dom_shots_counter = document.getElementById('shots_counter');

        // Création de toutes les cartes utilisables du jeu
        for (let i = 1; i <= this.total_cards_length; i++) {
            this.init_cards.push(new Card(i, `assets/images/card_${i}.png`));
        }
    }

    /**
     * Création d'un nouveau plateau de jeu
     *
     * @param pair_numbers integer : Nombre de paires de cartes à ajouter au plateau de jeu
     */
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
        // Ajout du listener au clique sur les nouvelles cartes
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

            // Ajout de l'image correspondante à la valeur de la carte
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

            card.addEventListener('click', function (event)  {
                event.preventDefault();

                let position = this.dataset.position; // Position de la carte dans la liste

                // On vérifie que la carte n'est pas déjà retournée
                for(let k = 0; k < board.return_cards.length; k++){
                    if(board.return_cards[k] == position){
                        return false; // Carte déjà retournée, on stop
                    }
                }

                // On retourne la carte
                let element = document.getElementById(`card_${position}`);
                element.classList.add('active');

                // On joue un son lorsque l'on retourne la carte
                board.game.audioManager('flip', 1);

                // On ajoute la carte choisie à la main courante
                board.current_hand.push(position);

                // On vérifie si les cartes retournées sont égales
                if (board.current_hand.length === 2) {

                    // On incrémente le compteur de coups
                    board.shots_played++;

                    // Mise à jours de l'interface
                    board.dom_shots_counter.innerText = board.shots_played;

                    let first_card = board.cards[board.current_hand[0]]; // Première carte retournée
                    let second_card = board.cards[board.current_hand[1]]; // Secinde carte retournée

                    if (first_card.value !== second_card.value) {
                        // Les valeurs sont différentes, on attends quelques millisecondes, et on retourne les cartes
                        setTimeout(function () {
                            // Les valeurs sont différentes, on remet les cartes face cachés
                            let dom_first_card = document.getElementById(`card_${board.current_hand[0]}`)
                            dom_first_card.classList.remove('active')

                            let dom_second_card = document.getElementById(`card_${board.current_hand[1]}`)
                            dom_second_card.classList.remove('active')

                            // On joue un son d'echec
                            board.game.audioManager('error', 0.3);

                            // On réinitialise la liste des cartes retournées
                            board.current_hand = [];
                        }, 750)
                    } else {
                        // Les valeurs sont identiques, on les laisse retournées et on continue
                        board.current_hand = [];

                        // On sauvegarde les cartes retournées
                        board.return_cards.push(first_card.position);
                        board.return_cards.push(second_card.position);

                        // On joue un son de success
                        board.game.audioManager('success', 1);

                        // On vérifie si le joueur à gagné
                        if (board.checkEndGame()) {
                            setTimeout(function(){
                                board.game.winGame();
                            }, 750)
                        }
                    }

                }
            });
        }
    }

    /**
     * Réinitialise le plateau de jeu
     */
    clearBoard() {
        // On réinitialise les listes et statistiques
        this.shots_played = 0;
        this.cards = [];
        this.return_cards = [];

        // Mise à jours des elements du DOM
        this.dom_cards_list.innerHTML = '';
        this.dom_shots_counter.innerText = '0';
    }

    /**
     * Création d'une nouvelle paire de cartes
     * que l'on ajoutes à la liste de toutes les cartes
     */
    newCardPair() {
        // Retourne un nombre aléatoire compris entre 0 et le nombre maximum de cartes disponibles
        let random_value = Math.random() * (this.init_cards.length - 1);
        // Retourne la partie entière de la valeur
        random_value = Math.trunc(random_value);

        // Copies de la carte sélectionnée
        this.cards.push(this.init_cards[random_value].clone());
        this.cards.push(this.init_cards[random_value].clone());
    }

    /**
     * Mélange toutes les cartes du jeu
     */
    shuffleCards() {
        // Parcours des cartes dans le sens inverse
        for(let i = this.cards.length - 1; i >= 0; i--){
            // On récupère la partie entière d'un nombre aléatoire
            let random = Math.floor(Math.random() * i);

            // On échange les deux cartes à l'aide d'une valeur temporaire
            let tmp = this.cards[i];
            this.cards[i] = this.cards[random];
            this.cards[random] = tmp;

            // On met à jours les position des cartes
            this.cards[i].setPosition(i);
            this.cards[random].setPosition(random);
        }
    }

    /**
     * Vérification de fin de partie
     *
     * @returns {boolean} : true = fin de partie / false = la partie continue
     */
    checkEndGame() {
        // On compte s'il y a autant de carte retournée que de carte total sur le plateau
        if (this.cards.length === this.return_cards.length) {
            return true;
        }

        return false;

        // A la place, on peu aussi écrire
        // "return (this.cards.length === this.return_cards.length)"
    }
}