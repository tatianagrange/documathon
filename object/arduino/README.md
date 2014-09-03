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