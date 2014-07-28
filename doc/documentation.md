#Documathon
---

##Introduction
###Présentation
Au Faclab, Fablab de l'Université de Cergy-Pontoise à Gennevilliers, le lieu est ouvert à tous, pour peu que l'utilisateur prenne la peine de documenter. Seulement, documenter nécessite la maitrise d'un ordinateur, une aisance à la lecture, ainsi que la capacité de traduire par écrit ce que l'on souhaite partager.

On en arrive donc à la conclusion que le Faclab n'est pas ouvert à tous, car il impose une condition d'entrée qui ne peut être satisfaite par tous.

Le Documathon est un projet qui cherche à répondre à cette question en apportant un moyen simple de documenter.

###Principe de base
Le premier principe du documathon est de pouvoir documenter en se passant au maximum du clavier, sans l'interdire.

Pour cela, l'utilisateur pourra documenter son projet à l'aide de photo. Et à chaque photo qui sera prise, il aura la possibilité, s'il le souhaite, d'ajouter du texte explicatif.

Pour prendre ses photos, l'utilisateur utilisera une boîte qui comporte plusieurs boutons, permettant de passer à l'étape suivante, d'annuler ou de partager le projet. Cette boîte sera reliée à un écran.

C'est donc *"juste"* cela, le Documathon. Un boîte avec des bouton qui permet de prendre des photos.

###Architecture du projet
Le projet est divisé en plusieurs parties, elles même à nouveau divisables en sous parties. Et ainsi de suite.

	.
	├── doc
	├── interface
	└── object
	    ├── arduino
	    │   └── searchs
	    │       ├── box
	    │       ├── multiplexeur
	    │       └── nfc
	    ├── box
	    └── rasp
On trouve dans **doc** toute la documentation des projets. On la retrouve néanmoins dans chaque partie dans les **README**.

Dans **interface** se trouve tout le code lié à ce que vera l'utilisateur à l'écran quand il documentera le projet.

Dans **object** se trouve tout ce qui est lié à l'objet physique. On y retrouve les recherches et les codes arduino, tout ce qui est lié à la boîte et tout ce qui concerne le Raspberry Pie.

##L'objet

###V0.1

####Conception

#####L'exterrieur
Le documathon est une boite de 25cm sur 35cm, épaisse de 6 centimètres.

La boîte a été réalisé grâce au générateur de la cité des science, en précisant les tailles des encoches sur les côtés.

Sur les planches de la boîte, on a rajouté des trous pour les sorties suivante:
* Sortie HDMI
* Sortie usb
* Sortie d'alimentation pour le Raspberry Pie

Il y a également la place sur la planche du dessus pour les quatres leds et les six boutons.

#####L'intérrieur
La raspberry Pie et le hub usb sont maintenues par des cales triangulaires. Il est possible de retirer les deux modules facilement.

Les 3 gros boutons sont soudés sur des plaques de plexiglasse, eux même maintenus à la plaque du dessus.

On trouve également dans la boîte la carte arduino, la carte nfc, deux breadbord et beaucoup de fils. Tout cela n'est pas maintenu pour l'instant.


####A prendre en compte pour la V1

* La carte Arduino sera branchée sur le Raspberry, mais une sortie pour faire passer un cable supplémentaire pourrait être utile.
* Remonter la sortie usb, conçu à l'envers.
* Remplacer les boutons de partage par des switch
* Faire la boite en plexi?

Le matériel suivant a été commandé pour réaliser une meilleur boite
* Pushbutton métalique. Ce bouton rond permettra de remplacer un couple bouton/led pour le partage. Il a l'avantage de pouvoir être maintenu facilement au moyen d'un écrou et d'être éclairé.
* Une grande breadboard, pour pouvoir faire tous les branchements au même endroit.
* Plusieurs puces RFID, au format carte et tag.
* Des fils pour relier le bouton à la carte.

##La boîte
Les fichiers de ce dossier son préfixé par la version de la boîte dessinée.
###V0.1
* Box : Il s'agit de tous les côtés de la boites et des cales nécessaires à tenir le Rasp et le hub usb dans la boite.
* Box - Part 1 & 2 : Le fichier original de la boite est conçu sur une planche plus grande que celles disponnibles au Faclab. Ces deux fichiers sont réorganisés de façon à tennir sur des planche de 60x40cm
* Button fix : Les boutons doivent être soudé afin d'être maintenus et reliés à la carte arduino. Il s'agit ici du modèle de l'écartement des pattes.
* Cales et boutons : Ce sont les cales à mettre entre la planche du dessus et les boutons.

##Arduino
Il y a plusieurs dossiers dans ce dossier.

* **searchs** contient toutes les recherches sur le code Arduino. 
* **src** contient le projet en lui même

###Les recherches
Pour arrivé au premier prototype, il faut tester plusieurs fonctionnalités. D'où la nécessité de garder une trace de ces essais, que l'on regroupe dans le dossier *recherche*

On y trouve un dossier par essai.

* Box : Il s'agit de l'essai permettant de faire clignotter les leds à l'appui sur les boutons
* Nfc : C'est le code de base qui réagit au passage d'un tag
* Multiplexeur: Il s'agit des tests sur le multiplexeur afin de brancher sur la carte arduino le shield nfc et l'ensemble led/bouton.











