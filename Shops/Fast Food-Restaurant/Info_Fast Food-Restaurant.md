# Das Fast Food-Restaurant
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
* ggf. passendes, selbstgebautes Gehäuse

## Vorbereitung der Hardware
1. Der Pi Zero W wird entsprechend der Anleitung für alle Shops vorbereitet.
2. Mit einem Computer wird die Datei mini-Fast-Food-Restaurant.hex auf den Calliope mini kopiert.
2. Der Calliope mini wird am linken Grove-Anschluss A0 per Kabel mit dem I2C Hub verbunden.
3. An den Hub werden Grove NFC und Grove I2C Multitouch per Kabel angeschlossen.
4. Der Calliope mini wird per USB-Kabel an den USB-Adapter und dann an den Pi Zero W angeschlossen.
5. Auf dem Pi wird das Blinkt! Modul gesteckt.
6. Die sechs Fühler werden wie folgt hinter die Artikelbilder geklebt:
* Fühler 0: Pommes
* Fühler 1: Fleischklopsbrötchen 
* Fühler 2: Veganer Salat
* Fühler 3: Dinokeule
* Fühler 4: Currywurst
* Fühler 5: Burger
7. An Pin P0 und dem Minuspol werden zwei Krokoklemmen angeschlossen und mit einem Taster verbunden

## Spielvorbereitung
Zuerst sollte der zentrale Server gestartet werden, um eine hängende Datenübertragung zu vermeiden.
Mit Starten des Pi wird ebenfalls der Calliope mini gestartet.
Die serielle Datenübertragung zwischen Calliope und Pi wird ebenfalls automatisch aktiviert.

## Spielablauf
1. Zuerst muss der gewünschte Fühler berührt werden.
2. Anschließend wird die Spielerkarte auf die NFC-Antenne aufgelegt.
3. Der Kauf wird durch Drücken des Tasters (Verbinden von P0 mit Minuspol) bestätigt.
4. Die Spielernummer wird aus der NFC-Karte ausgelesen und seriell an den Pi übertragen.
  
   Der Pi schickt die Kaufdaten per WLAN an den zentralen Server. Hat die Buchung geklappt, leuchten die LEDs grün auf am Blinkt! Modul und am Calliope mini. Wenn nicht, leuchten sie rot.
