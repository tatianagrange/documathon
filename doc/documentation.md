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

![V0.1 du documathon - exterrieur](http://goo.gl/xyPW8W)


#####L'intérrieur
La raspberry Pie et le hub usb sont maintenues par des cales triangulaires. Il est possible de retirer les deux modules facilement.

Les 3 gros boutons sont soudés sur des plaques de plexiglasse, eux même maintenus à la plaque du dessus.

On trouve également dans la boîte la carte arduino, la carte nfc, deux breadbord et beaucoup de fils. Tout cela n'est pas maintenu pour l'instant.

![V0.1 du documathon - intérrieur](http://goo.gl/28NxT6)
![V0.1 du documathon - intérrieur - Carte](http://goo.gl/tpgVMo)


####A prendre en compte pour la V0.1

* La carte Arduino sera branchée sur le Raspberry, mais une sortie pour faire passer un cable supplémentaire pourrait être utile.
* Remonter la sortie usb, conçu à l'envers.
* Remplacer les boutons de partage par des switch
* Retirer le bouton wordpress, le mettre en partage automatique
* Faire la boite en plexi
* Remplacer le bouton *next* par *ok*
* Ajouter des boutons de flèches

Le matériel suivant a été commandé pour réaliser une meilleur boite
* Pushbutton métalique. Ce bouton rond permettra de remplacer un couple bouton/led pour le partage. Il a l'avantage de pouvoir être maintenu facilement au moyen d'un écrou et d'être éclairé.
* Une grande breadboard, pour pouvoir faire tous les branchements au même endroit.
* Plusieurs puces RFID, au format carte et tag.
* Des fils pour relier le bouton à la carte.

###V0.2

####Test
Voici un test du système d'attache des boutons/leds sur du Plexi Blanc de 3mm:
![V0.2 - Bouton](http://goo.gl/Jq5Ooa) 
![V0.2 - Bouton](http://goo.gl/GaooIX) 

####Conception
#####L'exterrieur
Le documathon a été rapetitie, pour que la largeur soit, à peu de chose prêt, celle d'un ordinateur 13 pouces.

![V0.2 - Boîte et ordinateur](http://goo.gl/alxIcJ)

Elle fait désormais 20x3cm et est épaisse de 5 centimètres.

des boutons de directions (haut et bas) ont été ajouté afin de pouvoir faire des sélections à l'écran. Un bouton aide a également été placé en haut à droite. Il remplace la led d'information.

#####L'intérieur
Tous les branchements ont été mit en place. Le montage est maintenant fonctionnel.

![V0.2 - Intérieur](http://goo.gl/VoeRp5)

Si la Raspbery et le hub ne sont pas encore maintenu dans la boîte, cette fois la carte Arduino et la carte NFC ont été fixé, directement sur le couvercle du Documathon.

Deux petites breadboards permettent de relier chaque composant à la carte Arduino.

Les deux cartes sont fixées au moyen de boulons, collés au couvercle, et de petites vis, vissées dedans.

![V0.2 - Carte NFC fixée](http://goo.gl/XO05S6)

La même méthode de support de boutons que sur la V0.1 a été appliqué.

![V0.2 - Boutons](http://goo.gl/of8U7v)

####A prendre en compte pour la V0.2
* Espacer les boutons Led, trop proches.
* Retirer le bouton d'aide, qui ne sert pas.
* Ne pas coller les boulons avec les vis... La colle remonte et on se retrouve avec une vis immobile.
* Remonter légèrement la hauteur de la boîte, pour laisser la place aux fils.
* Faire une ouverture derière, permettant de soulever le couvercle sans problèmes.
* Agrandir le hub USB.

##La boîte
Les fichiers de ce dossier son préfixé par la version de la boîte dessinée. Ils sont également rangé dans le dossier correspondant

###V0.1
* Box : Il s'agit de tous les côtés de la boites et des cales nécessaires à tenir le Rasp et le hub usb dans la boite.
* Box - Part 1 & 2 : Le fichier original de la boite est conçu sur une planche plus grande que celles disponnibles au Faclab. Ces deux fichiers sont réorganisés de façon à tennir sur des planche de 60x40cm
* Button fix : Les boutons doivent être soudé afin d'être maintenus et reliés à la carte arduino. Il s'agit ici du modèle de l'écartement des pattes.
* Cales et boutons : Ce sont les cales à mettre entre la planche du dessus et les boutons.

###V0.2
* V0.2 - Box decoupe - Support.svg: Contient les supports de boutons.
* V0.2 - Box decoupe.svg: Découpe de la boite en elle même
* V0.2 - Box.png: Image de la boite.
* V0.2 - Box.svg: C'est le fichier dont vient *V0.2 - Box decoupe.svg*
* V0.2 - Cales et boutons: Support pour un seul bouton

###V0.3

####Le dossier
* V0.3 - Box: Découpe de la boîte dans le plexi blanc
* V0.3 - Buttons fixation: Toutes les fixations dans la boîte
* V0.3 - Buttons: Les boutons à découper dans le plexi noir

####Assemblage
#####Le Cadre et le dessous
La partie la plus simple est celle qui consiste à assembler le cadre et le dessous de la boîte. Il suffit de positionner chaque côté de cette façon:

![V0.3 - Assemblage](http://goo.gl/5WuFaj)

La planche du cadre vierge de tout trait de découpe est la face avant.

#####Assemblage du couvercle
![V0.3 - Assemblage](http://goo.gl/Luiwbd )
Le symbole NFC n'est pas un bouton, tout comme les signes twitter, facebook et print. Sur la V0.2, le point d'interrogation dans une bulle de dialogue n'en est pas un non plus.

On trouve aussi deux ronds noirs, sur la V0.3, qui symbolisent la possibilité d'ajouter des boutons supplémentaires.

Dans les prototype, le tout est collé à l'arrière avec du scotch et une très légère goutte de colle.

![V0.3 - Assemblage](http://goo.gl/4gr3k1)

##Arduino
Il y a plusieurs dossiers dans ce dossier.

* **searchs** contient toutes les recherches sur le code Arduino. 
* **documathon** le code source arduino du documathon.

###Les recherches
Pour arrivé au premier prototype, il faut tester plusieurs fonctionnalités. D'où la nécessité de garder une trace de ces essais, que l'on regroupe dans le dossier *recherche*

On y trouve un dossier par essai.

* Box : Il s'agit de l'essai permettant de faire clignotter les leds à l'appui sur les boutons
* Nfc : C'est le code de base qui réagit au passage d'un tag, avec une carte [PN512  Adafruit](https://learn.adafruit.com/adafruit-pn532-rfid-nfc)
* Multiplexeur: Il s'agit des tests sur le multiplexeur afin de brancher sur la carte arduino le shield nfc et l'ensemble led/bouton.
* NfcSmall : La carte [Adafruit](https://learn.adafruit.com/adafruit-pn532-rfid-nfc) utilisée pour le test NFC avait une trop longue portée et la façon de la branchée n'était pas propre. NfcSmall utilise une autre carte, [Seeed](http://cgi.ebay.fr/ws/eBayISAPI.dll?ViewItem&item=190822896368), et d'autres librairies.

####Les leds
La V0.2 du documathon utilise des boutons/led.

Afin d'être utilisés correctements, plusieurs tests ont été effectué, notemment à propos des branchement. 

Voici le shéma fonctionnel du composant:

![Composant](http://goo.gl/9auw1K)

Le composant est à brancher ainsi

![Composant](http://goo.gl/KQTnf8)

###Projet Documathon (V0.2)

####Prérequis
Les librairies suivantes doivent être installée pour que le code fonctionne:

* [PN532](https://github.com/Seeed-Studio/PN532)
* [NDEF](https://github.com/don/NDEF)

Pour installer ces librairies, il faut télécharger le zip sur github, puis ajouter les dossiers dans le dossier *Arduino/libraries* 

Le matériel suivant est utilisé:

* Des boutons/led, achetés sur [Adafruit](https://www.adafruit.com/products/481)
* Une crate Arduino Uno
* Une carte PN532 NFC RFID Reader/Writer Module Seeed, achetée sur [ebay](http://cgi.ebay.fr/ws/eBayISAPI.dll?ViewItem&item=190822896368)
* Cinq boutons
* 7 résistances

![Montage](http://goo.gl/KsdmrO)

####Les classes
Deux classes ont été créé pour clarifier le code. 

* **SwitchButton**, qui permet de récupérer l'état *HIGHT* d'un bouton une seule fois, peut importe le temps où l'on reste appuyé.
* **LedButton**, qui hérite de **SwitchButton**. Celle classe permet de spécifier une led à allumer pour marquer un fonctionnement on/off.

Le header **Protocol.h** permet simplement de stocker les définition du protocol.

####Détails
Il n'y a pour l'instant aucune différenciation entre les tag de login et les tag de projets. Pour cela, il faut encoder les tag (NDEF sur du Mifare Classic tag)


###Protocole
Le protocole applicatif permet de définir l’organisation des données envoyées entre la carte Arduino et le Raspberry Pi. Il est très important que ce protocole soit clairement défini afin qu’il ne puisse y avoir aucune ambiguïté dans les instructions données.

Chaque donnée qui transitera entre les deux carte sera défini comme suit :

	Instruction | Donnée relative à l'instruction
	
####Les instructions
Habituellement, les protocoles sont définis en hexadécimal. Afin que le projet reste lisible, on foncionnera par mots clés de 3 caractères.
#####log
*Instruction d'identification* Cette instruction est suivit de l'id du badge nfc qui sert à s'identifier. Par exemple

	log426422

#####prj
*Instruction de projet* Permet d'identifier sur quel projet on travail. Que ce soit un nouveau projet ou non. Cette instruction est suivit de l'id du badge nfc qui sert à identifier le projet. Par exemple

	prj133789
	
#####too
*Instruction d'outils* Permet d'identifier un outils utilisé sur le projet.

#####mat
*Instruction de matéreil* Permet de renseigner un type de matériaux utilisé sur le projet.

> Attention! Les instructions **log**, **prj**, **too** et **mat** sont encodés directement sur les tags que l'on passe sur arduino.

#####btn
Cette instruction signifie que l'on a appuyé sur un des boutons de navigation. Elle est suivit d'une seconde instruction
* **can** Annuler
* **top** Flèche du haut
* **bot** Flèche du bas
* **val** Valider

Ainsi, quand l'utilisateur cliquera sur le bouton annuler, la carte Arduino envera

	btncan
	
#####shr
Cette instruction signifie que l'on a appuyé sur *share*. Elle est suivit des instructions des plateformes sur lesquels l'utilisateur souhaite partager

* **twi** pour twitter
* **fac** pour facebook

Ainsi, si quelqu'un a choisit de partager le projet sur twitter mais pas sur facebook, on obtient

	shrtwi
	
Rien n'empèche de ne pas spécifier de site de partage. Par défaut, le projet est envoyé sur le serveur commun à tous les projets et sur la wordpress du faclab. Cela permet d'avoir un lien à partager.

#####not
Cette instruction envoi une **notification** à l'interface web. Elle est suivit de la nature de la notification

* **can** relève une erreur.
* **wri** indique qu'arduino a écrit sur le tag ce qui lui était demandé

#####srv
Les instruction srv servent à indiquer les instruction d'écriture allant de l'interface web vers la carte arduino.

##Raspberry Pi - Raspbian

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

## Problèmes rencontrés avec Raspbian
Debian est une distribution qui n'est pas habituellement utilisé sur de l'ARM (Raspberry). Il y a certains problèmes de compatibilité avec des drivers vidéo, en java, et notemment avec la librairie `webcam-capture`. Une nouvelle solution a donc était testée

##Raspberry Pi - Archlinux

Voici tous les tutoriaux qui ont été utilisés

[https://github.com/scream3r/java-simple-serial-connector/releases](https://github.com/scream3r/java-simple-serial-connector/releases)

[https://code.google.com/p/java-simple-serial-connector/](https://code.google.com/p/java-simple-serial-connector/)

[http://www.javaprogrammingforums.com/java-se-api-tutorials/5603-jssc-library-easy-work-serial-ports.html](http://www.javaprogrammingforums.com/java-se-api-tutorials/5603-jssc-library-easy-work-serial-ports.html)

[http://maven-guide-fr.erwan-alliaume.com/maven-guide-fr/site/reference/installation-sect-maven-install.html](http://maven-guide-fr.erwan-alliaume.com/maven-guide-fr/site/reference/installation-sect-maven-install.html)

[https://www.youtube.com/watch?v=mnH8II3K6R0](https://www.youtube.com/watch?v=mnH8II3K6R0)

[https://wiki.matthiasbock.net/index.php/Hardware-accelerated_video_playback_on_the_Raspberry_Pi](https://wiki.matthiasbock.net/index.php/Hardware-accelerated_video_playback_on_the_Raspberry_Pi)


###Log
Le nom de l'utilisateur est `root`, pareil pour le mot de passe.

###Keyboard
Le première chose à faire est de changer la langue du clavier. Pour cela, le [wiki](https://wiki.archlinux.org/index.php/Keyboard_configuration_in_console) de archlinux est très utile.

On commance par configurer le fichier qui sera lu au démarage de l'OS:

	$ nano /etc/vconsole.conf

Une fois dans nano, il faut écrire:

 	KEYMAP=fr

Pour sortir de nano, il faut faire `CTRL+X`, puis `Y` pour confirmer que l'on enrengistre, puis taper sur `entrer`

Entrer ensuite les commandes suivante

	$ localectl set-keymap --no-convert fr
	$ loadkeys fr
	$ reboot
	
Une fois le système redémaré, le clavier sera en français.

Attention. Quand on tape sur un clavier en mode `qwerty`, il faut retrouver ses lettres.

###Mettre à jour l'OS
http://www.fanninger.at/thomas/blog/2014/04/installing-archlinux-on-raspberry-pi/

	$ pacman -Syu
	$ sync
	$ reboot
	$ systemctl enable ntpd
	$ systemctl restart ntpd
	
###Agrandir la partition
Le tutoriel se trouve [ici](http://www.azurs.net/carnet/2013/03/arch-linux-sur-raspberry-pi-installation/#redimp2). Voici la marche à suivre

*Attention, les commandes précédées de `$` sont à taper dans le terminale directement, les commande précédées de `>` sont à taper dans l'utilitaire fdisk. Il n'y a pas nécessairement de chevrons visible.*

On lance fdisk :

	$ fdisk -c -u /dev/mmcblk0

	Welcome to fdisk (util-linux 2.23.1).

	Changes will remain in memory only, until you decide to write them.
	Be careful before using the write command.

	Command (m for help):

Commande p pour lister les partitions :

	> p

	Disk /dev/mmcblk0: 3957 MB, 3957325824 bytes, 7729152 sectors
	Units = sectors of 1 * 512 = 512 bytes
	Sector size (logical/physical): 512 bytes / 512 bytes
	I/O size (minimum/optimal): 512 bytes / 512 bytes
	Disk label type: dos
	Disk identifier: 0x00057540

	Device Boot Start End Blocks Id System
	/dev/mmcblk0p1 2048 186367 92160 c W95 FAT32 (LBA)
	/dev/mmcblk0p2 186368 3667967 1740800 5 Extended
	/dev/mmcblk0p5 188416 3667967 1739776 83 Linux

	Command (m for help):

On commence par effacer la partition logique (d puis 5) :

	> d

	Partition number (1,2,5, default 5):

	> 5

	Partition 5 is deleted

	Command (m for help):

Puis on efface la partition étendue (d puis 2) :

	> d

	Partition number (1,2, default 2):

	> 2

	Partition 2 is deleted

	Command (m for help):

On recrée la partition étendue (n puis e, puis 2) :

	> n

	Partition type:
	p primary (1 primary, 0 extended, 3 free)
	e extended
	Select (default p):

	> e

	Partition number (2-4, default 2):

	> 2

On la fait démarrer au même endroit (186368, ce qui est ici proposé par défaut) :

	First sector (186368-7729151, default 186368):

**Entrée**

Et elle finit au maximum possible (7729151, ce qui es tproposé ici par défaut) :

	Using default value 186368
	Last sector, +sectors or +size{K,M,G} (186368-7729151, default 7729151):

**Entrée**

	Using default value 7729151
	Partition 2 of type Extended and of size 3.6 GiB is set

	Command (m for help):

On recrée ensuite la partition logique (n puis l puis 5) :

	> n

	Partition type:
	p primary (1 primary, 1 extended, 2 free)
	l logical (numbered from 5)
	Select (default p):

	> l

La nouvelle partition 5 commence au même secteur que l’ancienne (188416) :

	Adding logical partition 5
	First sector (188416-7729151, default 188416):

**Entrée**

Et finit au maximum possible (7729151, valeur proposée par défaut) :

	Using default value 188416
	Last sector, +sectors or +size{K,M,G} (188416-7729151, default 7729151):

**Entrée**

	Using default value 7729151
	Partition 5 of type Linux and of size 3.6 GiB is set

	Command (m for help):
	
On écrit les changements sur la carte :

	> w

	The partition table has been altered!

	Calling ioctl() to re-read partition table.

	WARNING: Re-reading the partition table failed with error 16: Device or resource busy.
	The kernel still uses the old table. The new table will be used at the next reboot or after you run partprobe(8) or kpartx(8) Syncing disks.

Redémarrage du Raspberry Pi :

	$ shutdown -r now

On met le système de fichiers à la dimension de la partition 5 :

	$ resize2fs /dev/mmcblk0p5

	resize2fs 1.42.7 (21-Jan-2013)
	Filesystem at /dev/mmcblk0p5 is mounted on /; on-line resizing required
	old_desc_blocks = 1, new_desc_blocks = 1
	The filesystem on /dev/mmcblk0p5 is now 942592 blocks long.

Et on vérifie que tout s’est bien passé :

	$ df -h

	Filesystem Size Used Avail Use% Mounted on
	/dev/root 3.6G 467M 3.0G 14% /
	devtmpfs 83M 0 83M 0% /dev
	tmpfs 231M 0 231M 0% /dev/shm
	tmpfs 231M 264K 231M 1% /run
	tmpfs 231M 0 231M 0% /sys/fs/cgroup
	tmpfs 231M 0 231M 0% /tmp
	/dev/mmcblk0p1 90M 24M 67M 27% /boot
	
`/dev/root`doit avoir une taille suppérieur à 2G pour que cela ai fonctionné.

###vim
	$ pacman -S vim

###Desktop
Il faut ensuite installer une interface graphique. De base, Archlinux n'en possède pas.

On trouve des informations sur de nombreux sites. Comme [ce post](http://www.raspberrypi.org/forums/viewtopic.php?f=53&t=36552&p=306464&hilit=lxde#p306464) et sur [celui-ci](https://raspberrypi.stackexchange.com/questions/5257/does-arch-come-with-a-gui-preinstalled).

Voici les commande à entrer en lisant ces deux tutoriels.

	$ pacman -S xf86-video-fbdev lxde xorg-xinit
	$ pacman -S openbox lxde gamin dbus
	$ pacman -S xorg-server xorg-xinit xorg-server-utils
	$ pacman -S mesa xf86-video-fbdev xf86-video-vesa
	$ echo “exec startlxde” >> ~/.xinitrc
	$ startx
	
En ouvrant le terminal, le clavier est à nouveau en `qwerty`. Taper `setxkbmap fr`dans l'invite de commande pour passer en `azerty`.

Attention. La commande `startx` sera à utiliser à chaque démarage.

### Installation des polices de caractère

Java a besoin de polices de caractère par défaut pour pouvoir se lancer.

	$ pacman -S fontconfig
	$ pacman -S ttf-dejavu










##Interface

###Modèle de données
Que ce soit sur le serveur ou sur l'interface client proposée ici, on retrouve le même modèle de données. Celui-ci est relativement simple

![Modèle de données](../interface/model.png)

###Client

####testJS
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

####testUIJS
Ce dossier est un test de lecture sur le port série avec interaction au niveau d'une interface web. Pour faire fonctionner cet exemple, il faut installer plusieurs modules:

	$ npm install serialport
	$ npm install socket.io


Voici le sketch Arduino envoyé sur la carte:

	int i = 0;

	void setup() {
	  Serial.begin(9600);
	}

	void loop() {
	  Serial.println(0x0100);
	  digitalWrite(13, HIGH);
	  delay(3000);              
	  Serial.println(0x0101);
	  digitalWrite(13, LOW);    
	  delay(3000);              
	}

L'envoi de commande en hexadécimale est destiné à vérifier que cela fonctionne bien pour réaliser le protocole de communication entre le Raspberry et la carte Arduino.

Il faut ensuite démarrer le server:

	$ node server.js 
	
Puis se rendre sur l'adresse **localhost:8080**. Il ne faut pas oublier de préciser le *port* et le *baudrate*, comme dans l'exemple ci-dessus.

### Les problèmes rencontrés

L'utilisation du WebRTC sur des navigateurs ARM (Raspberry Pi) est assez lourd. L'utilisation de la webcam sur cet interface fait frizzer le navigateur. Une nouvelle solution a été envisagée.

### Une interface java

Java est un langage très utilisé dans l'industrie. Plusieurs librairies sont donc disponnibles pour l'utilisation du port série.

C'est la librairie a `jssc`qui est utilisée pour la communication avec le port série.

La librairie `webcam-capture` est utilisée pour l'affichage de la caméra.


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

