[Retourner au sommaire](https://github.com/wmalbos/wmalbos/blob/main/README.md)

# Jeu de mémoire

== Voir la [démo en ligne](https://games.wmalbos.fr/memory) ==

**Objectifs du projet :** _L'objectif du projet est de développer un jeu de société au format numérique._ 

_Le projet pourrais alors être confié en guise d'exemple, à des étudiants pour leur montrer un code de base, pour développer leurs propres mini-jeu (tetris, puissance 4, bataille navale, ...) en utilisant uniquement les bases de la programmation, sans utiliser de framework ni de design pattern spécifiques._

### I) Présentation du jeu

Initialement, le jeu "Mémory" (ou "Jeu de mémoire" en français) est un jeu de société édité par le groupe Ravensburger, sortie en 1959.

Dans cette version numérique à 1 joueur, le jeu se compose d'un certain nombre de paires de cartes portant des illustrations identiques. Les cartes sont mélangées, puis retournées face contre table.

Le joueur dois retourner deux cartes, si elles ne sont pas identiques, elle sont de nouveau retournées face contre table à leur emplacement d'origine. Le jeu ce termine avec une victoire quand toutes les paires de cartes ont été découvertes ou une défaite lorsque le compte à rebours du jeu est arrivé à son terme. 

En savoir plus sur [wikipédia](https://fr.wikipedia.org/wiki/Memory_(jeu))

### II) Propositions de variantes et améliorations

Il est possible de modifier l'expérience de jeu en modifiant quelques règles : 

- On rajoute du temps à chaque fois qu'une paire de carte identique à été découverte, pour simplifier le jeu.
- Un mode "multijoueurs" où le joueur qui découvre le plus grand nombre de pair de carte identique l'emporte, par exemple.
- Sauvegarde des différents score pour créer du challenge, avec un système de difficulté
- On rajoute une couleur unique aux illustrations pour augmenter la difficulté et perturber le joueur, il faut alors découvrire une paire de carte de même illustration et de même couleur, on peut également jouer sur d'autres paramètres comme la taille, le sens, etc...
- Compter les nombres de coups, les nombrse de parties, les nombres d'echecs, etc...
- Ajout d'une musique d'ambiance et de sons ( menu, découvrte d'une paire, victoire, echec, ... )
- Ajout d'un système de pause / reprise lorsque l'on ouvre le menu pour ne pas pardre la partie en cours
- Et pleins d'autres possibilités en fonction de notre imagination

### III) Choix techniques

#### a) Programmation Orienté Objets
##### 1) Le jeu

La structure du jeu suis la forme suivante : 
- Classe "Jeu"
- Classe "Plateau"
- Classe "Carte"

Cette structure générique, est très modulaire, on peut l'utiliser pour inclure une multitude de fonctionnalités, simplement, tel qu'un mode multijoueurs en ayant 2 plateau en même temps sur un jeu par exemple. 

On peut également l'utiliser dans d'autres jeux, comme un tetris. 
- Jeu = Tetris
- Plateau = Grille de jeu
- Carte = Tetrominos (ce sont les pions aux diverses formes du jeu)

ou alors une bataille navale
- Jeu = Bataille Navale
- Plateau = Grille de combat
- Carte = Bateau

Des classes annexes sont utilisées, et réutilisables, comme le Countdown qui gère un décompte de temps (avec des méthodes comme start, stop, pause, resume) 

##### 2) Persistance des données
La classe Database permet de gérer, notamment, la connexion à la base de donnée à l'aide d'un fichier de configuration. 
La classe Statistics permet, quant à elle, de gérer le modèle Statistic mais également les requêtes en base de donnée sur cette table. 

Il est possible, d'améliorer la structure en évoluant vers une structure [Modèle-Vue-Controlleur](https://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur).

#### b) Graphisme et effets audio
Des graphismes simples (images, :before, :after, ..) et quelques effets audio (victoire, echec, ...) ont été ajoutés. L'objectifs est de motiver l'étudiant, en réalisant son propre mini-prototype fonctionnel. On peut lui fournir un code de base pour l'aider à démarrer, si besoin.

#### c) Fichier de configuration
Le fichier de configuration est utilisé pour configurer la base de donnée et séparer la logique du code. En l'incluant dans le .gitignore on peut également en avoir une configuration différente en local et sur le serveur de production.

#### d) Makefile
Le projet comporte un fichier Makefile qui permet de réaliser certaines actions rapidement en utilisant un IDE ([Environnement De Développement](https://fr.wikipedia.org/wiki/Environnement_de_d%C3%A9veloppement)). 

Sans IDE, il reste possible d'utiliser le makefile en utilisant les commandes suivantes : 

- **make composer_install** -- ( Cette commande permet d'installer les dépendances de composer )
- **make composer_update** -- ( Cette commande permet de mettre à jours les dépendances)
- **make sass_dev** -- ( Cette commande permet de compiler de manière automatique les assets du projet )
- **make sass_production** -- ( Cette commande permet de compiler les assets du projet pour la production et de les minifier pour améliorer les performances )

#### e) Outil de déploiement

Il est possible de déployer l'application simplement à l'aide des conteneurs de la technologie [Docker](https://fr.wikipedia.org/wiki/Docker_(logiciel)). Il suffit alors de fournir le conteneur, contenant les diverses dépendances de l'application, base de donnée ect.. pour permettre une installation rapide du projet sur une nouvelle machine (ou pour une mise en production)

----- Rédaction en cours -----


### IV) Prévisualisations

<p float="center">
<img width="330" src="./docs/screen_1.jpg">
<img width="256" src="./docs/screen_2.jpg">
</p>
