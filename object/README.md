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