# Installation Fanshop

![Fanshop in der Ideenfang-Variante](fotos/Fanshop_Ideenfang.jpg?raw=true "Title")

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
* ggf. mit 3D-Drucker ausgedruckte [Dinochip 01]https://github.com/infchem/T-Race/blob/master/Shops/Fanshop/Dinotaler_01.stl), [Dinochip10](https://github.com/infchem/T-Race/blob/master/Shops/Fanshop/Dinotaler_10.stl) und [Dinopfeife](https://github.com/infchem/T-Race/blob/master/Shops/Fanshop/Dinopfeife.stl)

## Vorbereitung der Hardware
Zum Einbau des Shops in eine eine Sortierbox gibt es  eine separate [Anleitung](shopbox_anleitung.md).  
1. Der Pi Zero W wird entsprechend der [Anleitung für alle Shops](ideenfang_installation_shops.md)	 vorbereitet.
2. Mit einem Computer wird die Datei [mini-Fanshop.hex](https://github.com/infchem/T-Race/blob/master/Shops/Fanshop/mini-Fanshop.hex) auf den Calliope mini kopiert.
2. Der Calliope mini wird am linken Grove-Anschluss A0 per Kabel mit dem I2C Hub verbunden.
3. An den Hub werden Grove NFC und Grove I2C Multitouch per Kabel angeschlossen.
4. Der Calliope mini wird per USB-Kabel an den USB-Adapter und dann an den Pi Zero W angeschlossen.
5. Auf dem Pi wird das Blinkt! Modul gesteckt.
6. Die zwei Fühler werden wie folgt hinter die Artikelbilder geklebt:
* Fühler 0: Dinochips
* Fühler 1: Dinopfeife

8. An Pin P0 und dem Minuspol werden zwei Krokoklemmen oder Drähte angeschlossen und mit einem externer Schalter, zum Beispiel [Kartoffelsackschalter](../Sonstiges/Kartoffelsackschalter.pdf), verbunden.