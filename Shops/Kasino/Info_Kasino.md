# Das Kasino

## Spielvorbereitung
Zuerst sollte der zentrale Server gestartet werden, um eine hängende Datenübertragung zu vermeiden.
Mit Starten des Pi wird ebenfalls der Calliope mini gestartet.
Die serielle Datenübertragung zwischen Calliope und Pi wird ebenfalls automatisch aktiviert.

## Spielablauf
1. Zuerst muss der gewünschte Fühler berührt werden.
* Fühler 0: Schokocroissant (AID 7)
* Fühler 1: Käsebrötchen (AID 8)
* Fühler 2: Franzbrötchen (AID 9)
* Fühler 3: Salamibrötchen (AID 10)

  Die Ziffer wird nicht auf dem Display angezeigt, da zweistellige AIDs zu lange scrollen.
2. Anschließend wird die Spielerkarte auf die NFC-Antenne aufgelegt.
3. Der Kauf wird durch Drücken des Tasters (Verbinden von P0 mit Minuspol) bestätigt.
4. Die Spielernummer wird aus der NFC-Karte ausgelesen und seriell an den Pi übertragen.
  
   Der Pi schickt die Kaufdaten per WLAN an den zentralen Server. Hat die Buchung geklappt, leuchten die LEDs grün auf am Blinkt! Modul und am Calliope mini. Wenn nicht, leuchten sie rot.
