##Interface

###Modèle de données
Que ce soit sur le serveur ou sur l'interface client proposée ici, on retrouve le même modèle de données. Celui-ci est relativement simple

![Modèle de données](../interface/model.png)

###Client
Le dossier **testJS** est un test de la lecture sur le port série grâce à Nodejs. Pour cela il faut installer le module serialport

	$ npm install serialport
	
Il faut ensuite renseigner, dans *server.js*, les informations sur le port. Ici, on a testé sur le port **/dev/tty.usbserial-A600eo9b**.

Voici le sketch Arduino envoyé sur la carte:

	void setup() {
	  Serial.begin(9600);
	}

	void loop() {
	  Serial.println("Une ligne");
	  delay(1000);
	}
	
Il faut donc également renseigner le *baudrate*. Ici, **9600**.

Une fois le fichier *server.js* configuré, et la carte Arduino branchée, il faut lancer la comander suivante:

	$ node server.js
	
Cela sert à lancer le script js. On obtient alors la sortie suivante:

	$ node server.js 
		open
		data received: Une ligne
		data received: Une ligne
		data received: Une ligne
		data received: Une ligne
		
Il faut faire Ctrl+C pour arrêter le script.