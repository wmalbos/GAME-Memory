/**
 * La classe Card gère tous les élements relatifs à une carte de jeu ( Valeur, Image )
 */
export default class Card {

    value = null; // Valeur de la carte
    image = null; // Image associée à la carte
    position = null; // Position de la carte sur le plateau

    constructor(value, image) {
        this.value = value;
        this.image = image;
    }

    /**
     *
     * @returns {Card} : Copie de la carte
     */
    clone() {
        return new Card(this.value, this.image);
    }

    /**
     * Définition de la position de la carte sur le plateau
     *
     * @param position integer : Position de la carte dans la liste
     * @returns {Card} : La carte pour chaîner les appels
     */
    setPosition(position){
        this.position = position;
        return this;
    }
}