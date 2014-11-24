https://github.com/scream3r/java-simple-serial-connector/releases

https://code.google.com/p/java-simple-serial-connector/

http://www.javaprogrammingforums.com/java-se-api-tutorials/5603-jssc-library-easy-work-serial-ports.html

http://maven-guide-fr.erwan-alliaume.com/maven-guide-fr/site/reference/installation-sect-maven-install.html

https://www.youtube.com/watch?v=mnH8II3K6R0

https://wiki.matthiasbock.net/index.php/Hardware-accelerated_video_playback_on_the_Raspberry_Pi

#Archlinux
##Log
Le nom de l'utilisateur est `root`, pareil pour le mot de passe.

##Keyboard
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

##Mettre à jour l'OS
http://www.fanninger.at/thomas/blog/2014/04/installing-archlinux-on-raspberry-pi/

	$ pacman -Syu
	$ sync
	$ reboot
	$ systemctl enable ntpd
	$ systemctl restart ntpd
	
##Agrandir la partition
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

##vim
	$ pacman -S vim

##Desktop
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

install fonts:
pacman -S fontconfig
pacman -S ttf-dejavu