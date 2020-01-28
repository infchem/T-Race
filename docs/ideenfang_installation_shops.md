# Installation und Einrichtung der Shops

## microSD vorbereiten
1. [Raspian](https://downloads.raspberrypi.org/raspbian_full_latest) herunterladen und
2. mit [Etcher]( https://www.balena.io/etcher/) auf eine leere microSD-Karte schreiben:

## Headless Setup WLAN und SSH
In der ersten, kleineren Boot-Partition
1. eine leere Datei mit dem Namen `ssh` anlegen und
2. eine Datei `wpa_supplicant.conf` anlegen mit folgendem Inhalt:  

        country=DE  
        ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev  
        update_config=1  
        network={  
           ssid="wlan-bezeichnung"  
           psk="passwort"  
           key_mgmt=WPA-PSK  
         }  
Die Werte bei `ssid` und `psk` entsprechend anpassen.
Weitere Hinweise hierzu: https://pi-buch.info/wlan-schon-vor-der-installation-konfigurieren/

## Remote-Zugriff unter Windows starten
Mit [PuTTY](https://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html) eine SSH-Verbindung zu `raspberrypi` herstellen, Benutzer ist `pi`, Passwort ist `raspberry`.  

### Aktualisieren von Raspian
       sudo apt-get update
       sudo apt-get upgrade
	   
## Installation von screen (optional)
Hilfreich, wenn die Verbindung zum Pi mal abbrechen sollte. Weitere Hinweise hierzu: https://wiki.ubuntuusers.de/Screen/
       sudo apt-get install screen

## Installation von Blinkt!
    curl https://get.pimoroni.com/blinkt | bash
	
## T-Race Datei übertragen
Vorbereitetes Python-Skript zur Kommunikation zwischen Calliope mini und zentralem Server herunterladen mit
   `sudo wget https://github.com/infchem/T-Race/blob/master/Shops/liesCalliope.py?raw=true`
Den Pi Zero so konfigurieren, dass das Skript automatisch beim Booten ausgeführt wird:
	sudo nano /etc/rc.local
Am Ende von rc.local ergänzen:
	sudo python /home/pi/liesCalliope.py &
Abspeichern mit Strg+o und Enter, Beenden mit Strg+x

## T-Race Hotspot einrichten
Die Datei wpa_supplicant im Editor öffnen mit
	sudo nano /etc/wpa_supplicant/wpa_supplicant.conf
	
Im Abschnitt `network` die Einträge für `ssid`und `psk` wie folgt ändern:
	network={  
        ssid="T-Race"  
        psk="tracegame"  
        key_mgmt=WPA-PSK  
    } 
Abspeichern mit Strg+o und Enter, Beenden mit Strg+x	

## Fertigstellung mit raspi-config

`sudo raspi-config` ausführen und folgende Einstellungen vornehmen:
1. Unter 2, N1 Hostname in `<geschäftsname>` ändern.
2. Unter 1 Passwort von `pi` ändern in `traceadmin`.
3. Unter 3 `B1` zwei mal für "Konsole ohne Login" auswählen.
4. Unter 4, I1 `de_DE.UTF-8 UTF-8` auswählen und als default bestätigen.
5. Unter 4, I2 `Europe, Berlin` auswählen.
6. `Finish` und Reboot bestätigen.
