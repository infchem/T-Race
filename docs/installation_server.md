# Einrichtung des zentralen Raspberry Pi Zero W
## microSD vorbereiten
1. [Raspian](https://downloads.raspberrypi.org/raspbian_full_latest) herunterladen und
2. mit [Etcher]( https://www.balena.io/etcher/) auf eine leere microSD-Karte schreiben:

## Headless Setup WLAN und SSH
In der ersten (kleineren) Boot-Partition
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

## Installation von RaspAP
    sudo wget -q https://git.io/voEUQ -O /tmp/raspap && bash /tmp/raspap
Installation mit `Y` starten, mit `Y` bestätigen.
Die weiteren Abfragen mit `Y` bestätigen.
Der Webserver lighttpd und PHP werden automatisch mit installliert.

## Installation von sqlite, php-sqlite und php-gd
    sudo apt-get install sqlite php-sqlite3 php-gd

## Konfiguration von mod_rewrite
    sudo lighttpd-enable-mod rewrite    
    sudo nano /etc/lighttpd/lighttpd.conf
Im Abschnitt `server.modules` `"mod_rewrite"` ergänzen.  
Am Ende von lighttpd.conf ergänzen:

    url.rewrite-if-not-file = (
     "^/([^.?]!api[/]*)\?(.*)$" => "/index.php?$1&$2",
     "^/([^.?]!api[/]*)$" => "/index.php?$1",
    )

Abspeichern mit Strg+o und Enter, Beenden mit Strg+x
Webserver neu starten mit `sudo service lighttpd force-reload`.

## RaspAP verschieben
1. `cd /var/www/html`
2. `sudo mkdir raspap`
3. `sudo mv –r !(raspap) raspap`

Fehlermeldung ignorieren.

## Typesetter CMS installieren
1. `sudo wget https://github.com/Typesetter/Typesetter/archive/master.zip`
2. `sudo unzip master.zip`
2. `sudo mv Typesetter-master/* .`
3. `sudo rm master.zip`
3. `sudo rm -r Typesetter-master`
3. `cd ..`
4. `sudo chown -R www-data html`
5. `sudo chgrp -R www-data html`

## Typesetter einrichten
Installation durch Aufruf von **10.3.141.1** im Browser öffnen.
Eintragen folgender Werte in das Formular:
* T-Race
* admin@t-race.de
* admin
* traceadmin
* traceadmin

Auf `View your Website` klicken. Achtung: längere Ladezeit beim ersten Aufruf!

Datei */include/install/install.php* mit `sudo rm -rf /var/www/html/include/install/install.php` löschen.

## T-Race Dateien übertragen
1. In das Homeverzeichnis wechseln mit `cd ~`.
1. Vorbereitetes Typesetter Addon, Seiten, Mediendateien und Datenbank herunterladen mit
   `sudo wget https://github.com/infchem/T-Race/blob/master/Server/t-race.zip?raw=true`
2. Ausführen von `sudo unzip -o t-race.zip -d /var/www/html/`. Letztes / nicht vergessen!.
3. `sudo chown -R www-data /var/www/html`
4. `sudo chgrp -R www-data /var/www/html`

Die Datei t-race.zip nicht löschen, da später durch erneutes Ausführen der Schritte 2-4 T-Race zurückgesetzt werden kann.

## Fertigstellung mit raspi-config

`sudo raspi-config` ausführen und folgende Einstellungen vornehmen:
1. Unter 2, N1 Hostname in `start` ändern.
2. Unter 1 Passwort von `pi` ändern in `traceadmin`.
3. Unter 3 `B1` zwei mal für "Konsole ohne Login" auswählen.
4. Unter 4, I1 `de_DE.UTF-8 UTF-8` auswählen und als default bestätigen.
5. Unter 4, I2 `Europe, Berlin` auswählen.
6. `Finish` und Reboot bestätigen.

## RaspAP einrichten
Verbinden mit Hotspot **raspi-webgui**, Schlüssel: **ChangeMe**.  
Über Putty kann man sich ab jetzt über die IP `10.3.141.1` mit Benutzernamen `pi` und Passwort `traceadmin` verbinden.  
Im Browser **10.3.141.1/raspap** öffnen, Nutzer: **admin**, Passwort: **secret**  

Hotspot einrichten
* SSID: T-Race
* Einstellungen speichern

Sicherheit
* Sicherheitstyp: WPA2
* PSK: tracegame
* Einstellungen speichern

Erweitert
* Ländercode: Germany
* Einstellungen speichern  

DHCP Server einrichten
* Gültigkeit: 2 Hours(s)
* Einstellungen speichern

Authentifizierung einrichten
* Altes Passwort: secret
* Neues Passwort: traceadmin

Danach Hotspot neu starten über System, Neustarten.

## DNS editieren:  
Mit `sudo nano /etc/dnsmasq.conf` folgende Zeile ergänzen:  

    address=/start.t-race/10.3.141.1

Abspeichern mit Strg+o und Enter, Beenden mit Strg+x


    



