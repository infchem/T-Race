# Installation Kasino

![Kasino in der Ideenfang-Variante](fotos/Kasino_Ideenfang.jpg?raw=true "Title")

## Hardware

* Pi Zero W
* Blinkt! Modul
* Calliope mini
* Grove NFC
* Grove I2C Multitouch mit **zwei** Fühlern
* Grove I2C Hub
* Drei Grove Anschlusskabel
* Micro-USB-Kabel
* Micro-USB auf USB-Adapter
* Stromversorgung zu Pi Zero W
* Zwei Krokoklemmen (oder Drähte) und (selbstgebauter) Taster
* ausgedruckte und möglichst laminierte [Artikelkarte](https://github.com/infchem/T-Race/blob/master/Shops/Shop-Artikel.pdf)
* Panzerband
* Hau den Dino-Spiel
* Heißer Dino-Spiel
* Laptop mit Beamer
* MakeyMakey
* Android-Smartphone oder -Tablet
* ggf. passendes, selbstgebautes Gehäuse

## Vorbereitung der Hardware
Zum Einbau des Shops in eine eine Sortierbox gibt es  eine separate [Anleitung](shopbox_anleitung.md).  
1. Der Pi Zero W wird entsprechend der [Anleitung für alle Shops](ideenfang_installation_shops.md) vorbereitet.
2. Mit einem Computer wird die Datei [mini-Kasino.hex](https://github.com/infchem/T-Race/blob/master/Shops/Kasino/mini-Kasino.hex) auf den Calliope mini kopiert.
2. Der Calliope mini wird am linken Grove-Anschluss A0 per Kabel mit dem I2C Hub verbunden.
3. An den Hub werden Grove NFC und Grove I2C Multitouch per Kabel angeschlossen.
4. Der Calliope mini wird per USB-Kabel an den USB-Adapter und dann an den Pi Zero W angeschlossen.
5. Auf dem Pi wird das Blinkt! Modul gesteckt.
6. Die zwei Fühler werden wie folgt hinter die Artikelbilder geklebt:
* Fühler 0: Hau den Dino-Spiel
* Fühler 1: Heißer Dino-Spiel
8. An Pin P0 und dem Minuspol werden zwei Krokoklemmen oder Dähte angeschlossen und mit einem externer Schalter, zum Beispiel [Kartoffelsackschalter](Kartoffelsackschalter.pdf), verbunden.

## Vorbereiten der Spiele
### Hau den Dino-Spiel
1. Das Laptop wird mit dem Beamer verbunden.
2. In [Scratch 3](https://scratch.mit.edu) das [Hau den Dino-Spiel](https://github.com/infchem/T-Race/blob/master/Shops/Kasino/Hau%20den%20Dino.sb3) öffnen. Am besten den Offline Editor nutzen.
3. Am Laptop den MakeyMakey anschließen und mit den Anschlüssen am Spielfeld verkabeln. Siehe auch [Hau den Dino-Spiel](hau-den-dino.md).
4. Scratch in den Präsentatiosmodus schalten und mit dem Beamer auf das Spielfeld projizieren.

### Heißer Dino
1. Den Metall-Dino mit Pin P1 am Calliope mini verbinden.
2. Die Reset-Schraube mit Pin P2 am Calliope mini verbinden.

## Vorbereitung des Android-Geräts
1. In den Systemeinstellungen unter Sicherheit die Installation Apps aus unbekannten Quellen zulassen.
2. Die [Kasino App](https://github.com/infchem/T-Race/blob/master/Shops/Kasino/T_Race_Kasino.apk) mit dem Smartphone oder Tablet herunterladen und installieren.
