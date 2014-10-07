##Server

La partie serveur est la gestion de tout ce qui est en ligne.

Cette partie est nomée serveur, car il permettra, à terme, de stocker au même endroit tous les projets des labs. C'est pourquoi il y a une api qui permet d'y accéder.

###Configuration
Afin de pouvoir utiliser certains scripts, il est nécessaire de réaliser quelques opération sur le serveur.

Le fichier `server/Util/Config.php.default` est à copier sous le nom de `server/Util/Config.php`. On y renseigne les informations propres au server

####Les Vhost
Le serveur a besoin de deux Vhost. Dans le serveur donné sur ce projet, on a accès à deux sites:

* **api.documathon.tgrange.com** Ce site permet d'aller taper sur l'API décrite ci après
* **images.documathon.tgrange.com** Ce site permet de donner un accès aux images stockées sur le servier

Voici les deux vhost mis en place sur ce serveur:

#####Le vhost de l'api
	<VirtualHost *:80>
        ServerAdmin contact@tgrange.com
        ServerName  api.documathon.tgrange.com
        DocumentRoot /home/tatiana/www/documathon/interface/server
    	AddDefaultCharset utf-8
        ServerSignature Off
        <Directory /home/tatiana/www/documathon/interface/server>
            Options -Indexes
            AllowOverride All
        </Directory>
	</VirtualHost>
	
#####Le vhost des images
	<VirtualHost *:80>
        ServerAdmin contact@tgrange.com
        ServerName  images.documathon.tgrange.com
        DocumentRoot /home/tatiana/www/images
    	AddDefaultCharset utf-8
        ServerSignature Off
        <Directory /home/tatiana/www/images>
            Options -Indexes
            AllowOverride All
        </Directory>
	</VirtualHost>

####Les droits

	sudo chown -R www-data: www/documathon/interface/server/ && sudo chmod 755 www/documathon/interface/server/
	
Cette ligne de commade spécifie que l'utilisateur www-data, utilisé lors de l'execution des scripts sur le server, est le propriétaire de l'interface serveur du projet. Il a également les droits 775 sur cette partie du projet.

Cette commande est nécessaire pour que l'api puisse créer les dossiers manquants dans www/images. Et y enrengistrer une image.

###L'api

D'une manière générale, on retrouve dans chaque réponse de l'API les champs suivants:
* **datas** Il peut s'agir de n'importe quel type de données. C'est ici que l'on récupère les données que l'on souhaitait récupérer grâce à l'API.
* **status** Il s'agit du code du status de réponse de la requête
* **error** Cela précise si on a récupéré une erreur ou un succes
* **msg** Le message permet d'ajouter des information sur la réponse, que ce soit sur le type d'erreur rencontré ou sur l'état des données.

Une version de l'api se trouve à [cette adresse](http://api.documathon.tgrange.com/)

Voici le protocole de l'API:

####/projects
Cette route affiche tous les projets dans datas

####/projects/:id
Cette route retourne un projet en particulier. Id est l'identifiant du projet en base.

####/projects/filter/date/:date
Cette route retourne tous les projets qui ont été mis à jour après la date indiquée

####/projects/filter/start/:date
Cette route retourne tous les projets qui ont été commencé après la date indiquée

####/projects/filter/author/:id
Cette route retourne tous auxquel l'auteur a participé

####/projects/filter/material/:date
Cette route retourne tous les projets après la date indiquée

####/projects/filter/tool/:date
Cette route retourne tous les projets après la date indiquée

####/projects/create/:folderName
Cette route permet d'enregistrer un projet. Il faut donner le nom du dossier où se trouve le projet et l'API se charge de l'entrer en base de donnée. Ainsi, le serveur garde la main sur la base de données, tout en permettant à n'importe quel client d'ajouter des projets Documathon.

####Les Autres routes
#####/projects/create
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
	
#####projects/filter
Cette route ne donne rien, mais indique à l'utilisateur les différents filtres possibles. Il retourne une erreur de type *4205*

	{
		"datas": {
			"/projects/filter/date/:date": "Get the projects update after the date in timestamp",
			"/projects/filter/start/:date": "Get the projects start after the date in timestamp",
			"/projects/filter/author/:id": "Get the projects on which the author participated.",
			"/projects/filter/material/:id": "Get the projects on which use the material.",
			"/projects/filter/tool/:id": "Get the projects on which use the tool."
		},
		"status": 4205,
		"error": true,
		"msg": "ERROR | This is not the correct use of this route."
	}

#####Not Found
Si la route n'existe pas, elle renvoie un json de status *404*:

	{
		"datas": {
			"/projects": "Show all projects",
			"/projects/:id": "Show One project",
			"/projects/create/:folderName": "Create a new project in database, with de folder pass in argument",
			"/projects/filter": "Get all route with filter for projects",
			"/projects/filter/date/:date": "Get the projects update after the date in timestamp",
			"/projects/filter/start/:date": "Get the projects start after the date in timestamp",
			"/projects/filter/author/:id": "Get the projects on which the author participated.",
			"/projects/filter/material/:id": "Get the projects on which use the material.",
			"/projects/filter/tool/:id": "Get the projects on which use the tool."
		},
		"status": 404,
		"error": true,
		"msg": "ERROR | This route dosn't exist. Please try one of them."
	}

####Listing des status
* **200** : Tout est bon.
* **404** : La route n'existe pas.
* **4201**: Il manque le nom du dossier permettant la création d'un projet.
* **4202**: L'id demandé n'existe pas.
* **4203**: Aucun projet n'a été enrengistré depuis la date indiquée.
* **4204**: Le format de la date nest pas valide.
* **4205**: Affichage des filtres possibles pour les projets
* **4206**: Cette action n'existe pas.
* **4207**: L'action `step` necessite de passer la base64 de l'image en paramètre et d'envoyer la requête en POST
* **4208**: L'enrengistrement existe déjà en base de donnée.
* **4209**: Les actions `tool` et `material` necessitent d'envoyer la requête en GET
* **4210**: Le paramètre n'est pas un `int`
* **4299**: Erreur inconnue

###Technologie
L'API est basée sur le micro-framework **Slim Framework**

[http://www.slimframework.com/]()

####Hacks
Il faut ajouter une fonction dans le fichier Router.php
	
    public function getAllRoutes()
    {
        return $this->routes;
    }
    
Cette fonction est utilisée afin de lister toutes les routes disponnibles