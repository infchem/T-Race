# Installation Supermarkt

![Supermarkt in der Ideenfang-Variante](fotos/Supermarkt_Ideenfang.jpg?raw=true "Title")

## Hardware

* Pi Zero W
* Blinkt! Modul
* Calliope mini
* Grove NFC
* Grove I2C Multitouch mit sechs Fühlern
* Grove I2C Hub
* Drei Grove Anschlusskabel
* Micro-USB-Kabel
* Micro-USB auf USB-Adapter
* Stromversorgung zu Pi Zero W
* Zwei Krokoklemmen (oder Drähte) und (selbstgebauter) Taster
* ausgedruckte und möglichst laminierte [Artikelkarte](https://github.com/infchem/T-Race/blob/master/Shops/Shop-Artikel.pdf)
* Panzerband
* ggf. passendes, selbstgebautes Gehäuse
* falls möglich, mit 3D-Drucker ausgedruckte [Dinoaufkleber](https://github.com/infchem/T-Race/blob/master/Shops/Supermarkt/DinoSticker.studio3) in verschiedenen Farben (siehe unten)

## Vorbereitung der Hardware
Zum Einbau des Shops in eine eine Sortierbox gibt es  eine separate [Anleitung](shopbox_anleitung.md).  
1. Der Pi Zero W wird entsprechend der [Anleitung für alle Shops](ideenfang_installation_shops.md) vorbereitet.
2. Mit einem Computer wird die Datei [mini-Supermarkt.hex](https://github.com/infchem/T-Race/blob/master/Shops/Supermarkt/mini-Supermarkt.hex) auf den Calliope mini kopiert.
2. Der Calliope mini wird am linken Grove-Anschluss A0 per Kabel mit dem I2C Hub verbunden.
3. An den Hub werden Grove NFC und Grove I2C Multitouch per Kabel angeschlossen.
4. Der Calliope mini wird per USB-Kabel an den USB-Adapter und dann an den Pi Zero W angeschlossen.
5. Auf dem Pi wird das Blinkt! Modul gesteckt.
6. Die sechs Fühler werden wie folgt hinter die Artikelbilder geklebt:
* Fühler 0: Aufkleber rot
* Fühler 1: Aufkleber blau
* Fühler 2: Aufkleber gelb
* Fühler 3: Aufkleber grün
* Fühler 4: Aufkleber schwarz
* Fühler 5: Aufkleber violett
8. An Pin P0 und dem Minuspol werden zwei Krokoklemmen oder Drähte angeschlossen und mit einem externer Schalter, zum Beispiel [Kartoffelsackschalter](../Sonstiges/Kartoffelsackschalter.pdf), verbunden.
