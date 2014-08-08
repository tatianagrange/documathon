##Raspberry Pi

Le Raspberry est une carte, un peu plus grande qu'une carte de crédit, offrant toutes les possibilités d'un ordinateur. Celui utilisé dans le projet est un Raspberry model B. Il possède deux ports USB et un port ethernet.

###Installation de l'OS
La première étape est d'installer un OS (Opérating système). La documentation de Raspberry [explique bien comment faire](http://www.raspberrypi.org/downloads/).

Pour le projet du Documathon, j'ai installé une distribution Debian, la Raspbian. L'avantage de cette distribution est qu'elle est basée sur Debian. Il s'agit d'un enrironnement qui est souvent utilisé sur les serveurs. C'est une distribution connue et donc sur laquelle on a de grandes chances de retrouver ses marques.

####Mise à jour
On notera qu'une fois l'installation terminée, il convient de mettre à jour l'OS.

	$ sudo apt-get update
	$ sudo apt-get upgrade
	$ sudo apt-get dist-upgrade	
	
####Installations basiques
Pour pouvoir travailler sur le Raspberry Pi, j'ai installé les application suivante:
	
	$ sudo apt-get install vim
	
**Vim** est un éditeur en console. Il existe également nano. C'est ensuite une question de préférence.

	$ sudo apt-get install iceweasel
	
**Iceweasel** est une version de firefox pour Debian.

	$ wget http://node-arm.herokuapp.com/node_latest_armhf.deb
	$ sudo dpkg -i node_latest_armhf.deb
	$ npm install websocket

**Node Js** sera utilisé dans la suite du projet. I est conseillé de l'intallé tout de suite.


###Installation des composants
Il va y avoir plusieurs composants qui tourneront sur le Raspberry. Chacun d'entre eux nécessite une installation plus ou moins difficile.

####La clé wifi
Certaines clés wifi fonctionnent du premier coup. D'autre fonctionnaient du premier coup. C'est le cas de la [TP-Link WN725N](http://www.amazon.fr/gp/product/B008B7PZU4/ref=oh_aui_detailpage_o04_s01?ie=UTF8&psc=1). Elle est relativement peu chère, ce qui en fait la parfaite candidate pour un Raspberry Pie.

J'ai suivit [ce tutoriel](http://www.raspberrypi.org/forums/viewtopic.php?p=462982) pour la faire fonctionner. Voici ce qui a fonctionné pour moi.

	$ uname -a
		Linux raspberrypi 3.12.22+ #691 PREEMPT [...]
	$ wget https://dl.dropboxusercontent.com/u/80256631/8188eu-20140616.tar.gz
	$ sudo install -p -m 644 8188eu.ko /lib/modules/$(uname -r)/kernel/drivers/net/wireless
	$ sudo insmod /lib/modules/$(uname -r)/kernel/drivers/net/wireless/8188eu.ko
	$ sudo depmod -a
	
Suite à celui, la clé fonctionne. Il ne reste plus qu'à configurer le wifi. Et comme conseillé [ici](http://www.framboise314.fr/la-framboise-314-et-le-wifi-ou-comment-se-passer-du-cable-ethernet-avec-le-raspberry-pi/), j'ai installé le soft **wicd**

	$ sudo apt-get install wicd
	
Une fois l'application installée, elle est accessible graphiquement dans Menu | Internet | Wicd. Il faut trouver le réseau auquel se connecter, entre le mot de pass et le type de mot de passe. Et la clé fonctionne.

####La webcam
La webcam [Trust Spotlight](http://www.amazon.fr/gp/product/B0028YR4DW/ref=oh_aui_detailpage_o03_s01?ie=UTF8&psc=1) est une caméra qui est reconnu automatiquement sur Rasbian.

Comme la webcam sera utilisée sur le web, grâce au webRTC, la meilleur façon de tester si elle fonctionne est de faire le test en ligne.

Pour cela, il faut démarer **Iceweaseal** et lancer la page suivante: [https://mozilla.github.io/webrtc-landing/]()

Il s'agit d'exemple de l'utilisation de WebRTC sur Firefox. **getUserMedia example** fait un très bon test.

####Arduino
#####Le code de teste
Pour tester la communication d'Arduino vers le port série, j'ai chargé un skecth Blink légèrement modifié:

	void setup() {
	  // initialize digital pin 13 as an output.
	  pinMode(13, OUTPUT);
	  // initialize the serial port
	  Serial.begin(9600);
	}

	// the loop function runs over and over again forever
	void loop() {
	  digitalWrite(13, HIGH);   // turn the LED on (HIGH is the voltage level)
	  Serial.write("Something");// Write something on the serial port
	  delay(1000);              // wait for a second
	  digitalWrite(13, LOW);    // turn the LED off by making the voltage LOW
	  delay(1000);              // wait for a second
	}
	
Une fois le sketch uploadé sur arduino, brancher la carte sur le Raspberry Pi, en USB. Puis redémarrer le petit ordinateur

	$ sudo reboot

#####La configuration du port série
La carte Arduino va devoir communiquer avec le Raspberry Pi sur le Port Serie. Pour cela, il faut commencer par installer arduino.

	$ sudo apt-get install arduino
	
Ensuite, il faut configurer le port série pour lire ce qu'il s'y affiche. Pour cela, minicom est un outils très pratique.

	$ sudo apt-get install minicom
	
Une fois minicom installé, il faut repérer le port sur lequel communique la carte arduino. Car le Raspberry n'a pas de ports séries. Seulement des ports usb.

	$ dmesg | grep tty
	
Cette commande affiche les sorties comprenant *tty*. Après avoir repéré le port qui émule le port série, dans mon cas **ttyUSB0**, il faut renseigner le port série.

	$ sudo apt-get install setserial
	$ setserial -g /dev/ttyUSB0
	
Puis on peut démarer minicom

	$ sudo minicom -s

Sélectionner **Serial port setup**. Taper **a**, puis écrire **/dev/ttyUSB0** (Dans mon cas). Puis taper entrer.

Le port série est réglé. Reste la définition de ce que l'on envoie sur le port série. Sur Arduino, je définie le porte série sur **9600**. Pour le configurer, taper sur **E**, puis **C**, qui indique 9600. Puis presser entrer.

Appuyer sur echap, puis sélectionner **Save setup as dfl**. Attention, il est possible de sauvegarder cette configuration par défaut uniquement si minicom a été lancé en root. D'où l'utilisation de *sudo* devant la commande.

Sélectionner exit. ET on arrive sur la lecture du port série.

Si **Something** s'écrit en boucle sur l'écran, c'est que la carte arduino communique sur le port série.

Pour quitter minicom, faire Ctrl+A X.









