# Installation Bäcker

## Hardware

* Pi Zero W
* Blinkt! Modul
* Calliope mini
* Grove NFC
* Grove I2C Multitouch mit **vier** Fühlern
* Grove I2C Hub
* Drei Grove Anschlusskabel
* Micro-USB-Kabel
* Micro-USB auf USB-Adapter
* Stromversorgung zu Pi Zero W
* Zwei Krokoklemmen (oder Drähte) und (selbstgebauter) Taster
* ausgedruckte und möglichst laminiertes [Artikelkarte](https://github.com/infchem/T-Race/blob/master/Shops/Shop-Artikel.pdf)
* Panzerband
* ggf. passendes, selbstgebautes Gehäuse

## Vorbereitung der Hardware
1. Der RasPi Zero W wird entsprechend der Anleitung für alle Shops vorbereitet.
2. Mit einem Computer wird die Datei [mini-Bäcker.hex](https://github.com/infchem/T-Race/blob/master/Shops/B%C3%A4cker/mini-B%C3%A4cker.hex) auf den Calliope mini kopiert.
2. Der Calliope mini wird am linken Grove-Anschluss A0 per Kabel mit dem I2C Hub verbunden.
3. An den Hub werden Grove NFC und Grove I2C Multitouch per Kabel angeschlossen.
4. Der Calliope mini wird per USB-Kabel an den USB-Adapter und dann an den Pi Zero W angeschlossen.
5. Auf dem Pi wird das Blinkt! Modul gesteckt.
6. Die vier Fühler werden wie folgt hinter die Artikelbilder mit Panzerband geklebt:
* Fühler 0: Schokocroissant
* Fühler 1: Käsebrötchen
* Fühler 2: Franzbrötchen
* Fühler 3: Salamibrötchen
7. An Pin P0 und dem Minuspol werden zwei Krokoklemmen oder Draht angeschlossen und mit einem Taster verbunden.