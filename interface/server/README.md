##Server

La partie serveur est la gestion de tout ce qui est en ligne.

Cette partie est nomée serveur, car il permettra, à terme, de stocker au même endroit tous les projets des labs. C'est pourquoi il y a une api qui permet d'y accéder.

D'une manière générale, on retrouve dans chaque réponse de l'API les champs suivants:
* **datas** Il peut s'agir de n'importe quel type de données. C'est ici que l'on récupère les données que l'on souhaitait récupérer grâce à l'API.
* **status** Il s'agit du code du status de réponse de la requête
* **error** Cela précise si on a récupéré une erreur ou un succes
* **msg** Le message permet d'ajouter des information sur la réponse, que ce soit sur le type d'erreur rencontré ou sur l'état des données.

Voici le protocole de l'API:

###/projects
Cette route affiche tous les projets dans datas

###/projects/:id
Cette route retourne un projet en particulier. Id est l'identifiant du projet en base.

On notera qu'il est envisageable, à l'avenir, de définir plusieurs filtres de projets, directement dans l'API.

###/projects/create/:folderName
Cette route permet d'enregistrer un projet. Il faut donner le nom du dossier où se trouve le projet et l'API se charge de l'entrer en base de donnée. Ainsi, le serveur garde la main sur la base de données, tout en permettant à n'importe quel client d'ajouter des projets Documathon.

###Les Autres routes
####/projects/create
Cette route ne donne rien, mais précise à l'utilisateur qu'il se trompe dans l'utilisation de la fonction. Il retourne une erreur de type *4201*

La route retourn le json suivant:

	{
		"datas": {
			"/projects/create/:folderName": "Create a new project in database, with de folder pass in argument"
		},
		"status": 4201,
		"error": true,
		"msg": "ERROR | This is not the correct use of this route. Please use this"
	}

####Not Found
Si la route n'existe pas, elle renvoie un json de status *404*:

	{
		"datas": {
			"/projects": "Show all projects",
			"/projects/:id": "Show One project",
			"/projects/create/:folderName": "Create a new project in database, with de folder pass in argument"
		},
		"status": 404,
		"error": true,
		"msg": "ERROR | This route dosn't exist. Please try one of them."
	}

###Listing des status
* **200** : Tout est bon
* **404** : La route n'existe pas
* **4201**: Il manque le nom du dossier permettant la création d'un projet