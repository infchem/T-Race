# Installation Sportladen

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
* ggf. passendes, selbstgebautes Gehäuse
* falls möglich, ausgedruckte [Anziehpuppe](https://github.com/infchem/T-Race/blob/master/Shops/Sportladen/Anziehdino.pdf) und mit Schneideplotter auf Klebefolie ausgeschnittenen [Jogginganzug](https://github.com/infchem/T-Race/blob/master/Shops/Sportladen/Dinopuppe.studio3)
* falls möglich, mit 3D-Drucker ausgedruckte [Flossen](https://github.com/infchem/T-Race/blob/master/Shops/Sportladen/Flosse.stl) und [Taucherbrille](https://github.com/infchem/T-Race/blob/master/Shops/Sportladen/Taucherbrille.stl)

## Vorbereitung der Hardware
1. Der Pi Zero W wird entsprechend der Anleitung für alle Shops vorbereitet.
2. Mit einem Computer wird die Datei [mini-Sportladen.hex](https://github.com/infchem/T-Race/blob/master/Shops/Sportladen/mini-Sportladen.hex) auf den Calliope mini kopiert.
2. Der Calliope mini wird am linken Grove-Anschluss A0 per Kabel mit dem I2C Hub verbunden.
3. An den Hub werden Grove NFC und Grove I2C Multitouch per Kabel angeschlossen.
4. Der Calliope mini wird per USB-Kabel an den USB-Adapter und dann an den Pi Zero W angeschlossen.
5. Auf dem Pi wird das Blinkt! Modul gesteckt.
6. Die zwei Fühler werden wie folgt mit Panzerband hinter die Artikelbilder geklebt:
* Fühler 0: Taucher-Set
* Fühler 1: Anziehpuppe
8. An Pin P0 und dem Minuspol werden zwei Krokoklemmen oder Drähte angeschlossen und mit einem Taster verbunden.
