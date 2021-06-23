/**
 * La classe CountDown permet de gérer un compte à rebour
 */
export default class Countdown {

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