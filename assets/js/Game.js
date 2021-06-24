import Board from './Board.js'
import Countdown from './Countdown.js'

/**
 * La classe Game  gère les elements généraux du jeu ( Menu, Score, Plateau, ... )
 */
export default class Game {

    pair_numbers = 1; // Nombre de paires de cartes dans la partie
    game_duration = 120; // Décompte restant en secondes avant la fin de la partie
    countdown = null; // Objet compte à rebours utilisé pour le décompte de temps
    game_counter = 0; // Nombre de parties jouées
    audios = []; // Liste des fichiers audios

    constructor() {
        // Plateau de jeu
        this.board = new Board(this);

        // Elements du DOM
        this.dom_menu_victory = document.getElementById('menu_victory');
        this.dom_menu_loose = document.getElementById('menu_loose');
        this.dom_game_counter = document.getElementById('game_counter');
        this.dom_menu_victory_score = document.getElementById('rank_player_score');

        // Fichiers audio
        this.audios['error'] = new Audio('assets/audio/error.mp3');
        this.audios['success'] = new Audio('assets/audio/success.mp3');
        this.audios['victory'] = new Audio('assets/audio/victory.mp3');
        this.audios['failed'] = new Audio('assets/audio/failed.mp3');
        this.audios['flip'] = new Audio('assets/audio/flip.mp3');

        // Création du compteur de temps
        this.countdown = new Countdown(this);
    }

    /**
     * Création d'une nouvelle partie
     */
    newGame() {
        // Nombre de partie jouées
        this.game_counter++;
        this.dom_game_counter.innerText = this.game_counter;

        // On réinitialise le plateau
        this.board.newBoard(this.pair_numbers);

        // Gestion du décompte
        this.countdown.start(this.game_duration);
    }

    /**
     * Victoire du joueur
     */
    winGame() {
        // On arrête le décompte
        this.countdown.stop();

        // On affiche le menu de victoire
        this.dom_menu_victory.classList.add('active');

        // On joue un son de victoire
        this.audioManager('victory', 1);

        // Sauvegarde du score
        this.dom_menu_victory_score.value = this.countdown.getRemainTime();
    }

    /**
     * Défaite du joueur
     */
    loseGame() {
        // On arrête le décompte
        this.countdown.stop();

        // On affiche le menu de défaite
        this.dom_menu_loose.classList.add('active');

        // On joue un son de défaite
        this.audioManager('failed', 1);
    }

    /**
     * Gestion de l'audio du jeu
     * Idée d'amélioration : En faire une classe à parts pour pouvoir la réutiliser dans d'autres projets
     *
     * @param file string : Nom du fichier audio à jouer
     * @param volume float : Volume du son à jouer
     */
    audioManager(file, volume){
        this.audios[file].pause(); // On arrête le son s'il est déjà en cours de lecture
        this.audios[file].currentTime = 0; // On réinitialise la lecture au début
        this.audios[file].volume = volume; // On définit le volume
        this.audios[file].play(); // On (re)lance la lecture
    }
}