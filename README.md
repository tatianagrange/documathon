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
	├── hooks
	├── interface
	│   ├── javaClient
	│   ├── nodeClient
	│   ├── server
	│   └── tests
	├── object
	│   ├── arduino
	│   ├── box
	│   └── rasp
	└──
	
On trouve dans **doc** toute la documentation des projets. On la retrouve néanmoins dans chaque partie dans les **README**.

Dans **interface** se trouve tout le code lié à l'interface, que ce soit au niveau du serveur ou de l'application que l'utilisateur aura en face de lui. Il y a deux type de client. Un client node et un client Java. C'est le client en java qui est utilisé actuellement.

Dans **object** se trouve tout ce qui est lié à l'objet physique. On y retrouve les recherches et les codes arduino, tout ce qui est lié à la boîte et tout ce qui concerne le Raspberry Pie.

**hooks** est un dossier à part. On y liste les hooks qui permettent de simplifier la production sur le projet. Par exemple, pre-commit est appellé juste avant chaque commit. On y recompile la documentation qui se trouve dans doc, afin qu'elle soit à jour dès que l'on change l'un des fichiers README référencés comme faisant partie de la documentation.

###Photos
Les photos et vidéos du projet sont [ici](http://goo.gl/cmwZ7Z). Chaque image comporte une légende qui donne la version du Documathon sur la photo, ainsi qu'une explication. 