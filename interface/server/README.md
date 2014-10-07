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

####/
Cette route renvoie une erreur `404` et affiche toutes les routes existantes

####/projects
Cette route affiche tous les projets dans datas

####/projects/:projectId
Cette route retourne un projet en particulier. Id est l'identifiant du projet en base. La route lève une exception `4202` si l'id n'existe pas en base.

####/projects/:projectId/add
Renvois une erreur `4211` et affiche les options possibles. ProjectId est toujours l'id du projet en base de données.

####/projects/:projectId/add/:what
#####GET
Utilisée en GET, cette route lève une erreur `4212` si l'action *what* est connue. 

Si *what* n'existe pas, la route lève une erreur `4206`.

Si *what* est l'action `step`, la route lève une erreur `4207`.

#####POST
Utilisée en POST, cette route permet de créer une nouvelle étape.

Si la route ne trouve pas la variable `base64` en POST, l'erreur `4207` est levée.

Si l'action *what* est `tool`ou `material`, la route lève l'exception `4209`

####/projects/create/:projectName
Cette route permet d'enregistrer un projet. Elle prends en paramètre le nom du projet. Elle retourne l'id du projet créé.

####/projects/filter/update/:date
Cette route retourne tous les projets qui ont été mis à jour après la date indiquée. Elle lève une exception `4204` si la date n'est pas valide.

`date`doit être un timestamp.

####authors/
Affiche tous les Auteurs

####/authors/:id
Cette route retourne un auteur en particulier. Id est l'identifiant de l'auteur en base. La route lève une exception `4202` si l'id n'existe pas.

####/authors/:id/contribute/:stepId
Cette route permet d'enrengistrer la participation d'un utilisateur à une étape. La route lève une exception `4202` si l'id n'existe pas.

####/authors/create/:name
Cette route permet de créer un auteur avec le nom donner en paramètre. La route retourne l'id de l'auteur créé en base.

####/authors/create/:name/:birth
Cette route permet de créer un auteur avec le nom donner en paramètre, mais en ajoutant la date de naissance de celui-ci. La route retourne l'id de l'auteur créé en base.

####/tools/
Retourne tous les outils

####/tools/:id
Cette route retourne un outils en particulier. Id est l'identifiant de l'outils en base. La route lève une exception `4202` si l'id n'existe pas.

####/tools/create/:name
Cette route permet de créer un outils avec le nom donner en paramètre. La route retourne l'id de l'outils créé en base.

####/materials/
Retourne tous les matériaux

####/materials/:id
Cette route retourne un matériaux en particulier. Id est l'identifiant du matériaux en base. La route lève une exception `4202` si l'id n'existe pas.

####/materials/create/:name
Cette route permet de créer un matériaux avec le nom donner en paramètre. La route retourne l'id de du matériaux créé en base.

####/materials/create/:name/:width
Cette route permet de créer un matériaux avec le nom donner en paramètre, en ajoutant la largeur. La route retourne l'id de du matériaux créé en base.

####/materials/create/:name/:width/:length
Cette route permet de créer un matériaux avec le nom donner en paramètre, en ajoutant la largeur et la longueur. La route retourne l'id de du matériaux créé en base.

####/materials/create/:name/:width/:length/:thickness
Cette route permet de créer un matériaux avec le nom donner en paramètre, en ajoutant la largeur, la longueur et l'épaisseur. La route retourne l'id de du matériaux créé en base.

####404
Si la route n'existe pas, elle renvoie un json de status *404*:

	{
		"datas": [
			"/projects/",
			"/projects/:projectId",
			"/projects/:projectId/add",
			"/projects/:projectId/add/:what",
			"/projects/:projectId/add/:what",
			"/projects/:projectId/add/:what/:id",
			"/projects/create/:projectName",
			"/projects/filter/update/:date",
			"/authors/",
			"/authors/:id",
			"/authors/:id/contribute/:stepId",
			"/authors/create/:name",
			"/authors/create/:name/:birth",
			"/tools/",
			"/tools/:id",
			"/tools/create/:name",
			"/materials/",
			"/materials/:id",
			"/materials/create/:name",
			"/materials/create/:name/:width",
			"/materials/create/:name/:width/:length",
			"/materials/create/:name/:width/:length/:thickness"
		],
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