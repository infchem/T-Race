#Goodies nicht nur für Lehrkräfte

## Admin-Login zum Bearbeiten der Webseiten
http://start.t-race/index.php/Admin
Username: admin
Password: traceadmin

## Zurücksetzen der Datenbank
1. Mit PuTTY auf start.t-race verbinden und mit pi/traceadmin einloggen.
2. Ausführen von `sudo unzip -o t-race.zip -d /var/www/html/`. Letztes / nicht vergessen!.
3. Ausführen von  `sudo chown -R www-data /var/www/html`
4. Ausführen von `sudo chgrp -R www-data /var/www/html`

## Ladenschilder für Shopboxen
Für die Shopboxen in der Ideenfang-Variante gibt es Schilder als STL-Dateien für 3D-Drucker:
- [Bäcker](../Shops/Bäcker/Ladenschild_Bäcker.stl?raw=true)
- [Fanshop](../Shops/Fanshop/Ladenschild_Fanshop.stl?raw=true)
- [Fast Food-Restaurant](../Shops/Fast Food-Restaurant/Ladenschild_Fast Food Restaurant.stl?raw=true)
- [Kasino](../Shops/Kasino/Ladenschild_Kasino.stl?raw=true)
- [Sportladen](../Shops/Sportladen/Ladenschild_Sportladen.stl?raw=true)
- [Supermarkt](../Shops/Supermarkt/Ladenschild_Supermarkt.stl?raw=true)
- [Demo-Shop](../Sonstiges/Ladenschild_Demo.stl?raw=true)

## Screenshots der MakeCode-Skripte
Für die Calliope mini in der Ideenfang-Variante gibt es Screenshots der grafischen MakeCode-Quelltexte:
- [Bäcker](../Shops/Bäcker/MakeCode_Bäcker.png?raw=true)
- [Fanshop](../Shops/Fanshop/MakeCode_Fanshop.png?raw=true)
- [Fast Food-Restaurant](../Shops/Fast Food-Restaurant/MakeCode_FastFood.png?raw=true)
- [Kasino](../Shops/Kasino/MakeCode_Kasino.png?raw=true)
- [Sportladen](../Shops/Sportladen/MakeCode_Sportladen.png?raw=true)
- [Supermarkt](../Shops/Supermarkt/MakeCode_Supermarkt.png?raw=true)

## Artikelauswahlbilder im Foto-Format 10x15
Folgende PPTX-Dateien lassen sich direkt auf Fotopapier im Format 10x15 ausdrucken:
- [Bäcker](../Shops/Bäcker/Bäcker-Auswahl_10x15.pptx?raw=true)
- [Fanshop](../Shops/Fanshop/Fanshop-Auswahl_10x15.pptx?raw=true)
- [Fast Food-Restaurant](../Shops/Fast Food-Restaurant/FastFood-Auswahl_10x15.pptx?raw=true)
- [Kasino](../Shops/Kasino/Kasino-Auswahl_10x15.pptx?raw=true)
- [Sportladen](../Shops/Sportladen/Kasino-Auswahl_10x15.pptx?raw=true)
- [Supermarkt](../Shops/Supermarkt/Supermarkt-Auswahl_10x15.pptx?raw=true)

## Artikelauswahlbilder im Format A4
- [Artikelbilder im PPTX-Format](../Shops/Shop-Artikel.pptx?raw=true)

## Druckvorlage Spielkarte
[Druckvorlage für cardPresso-Software](../Sonstiges/Spielerkarte.card?raw=true)

## Ausmalbilder Dinosaurier
Für jüngere Besucher auf der IdeenExpo wurden folgende Ausmalbilder angeboten.
Die Dinosaurierbilder werden für das Spiel T-Race zur Verfügung gestellt von [Hiltrud Cantauw](http://www.dinosaurier-interesse.de).
- [Brontosaurus](../Sonstiges/Ausmalbilder/Brontosaurus.pdf?raw=true)
- [Lessemsaurus](../Sonstiges/Ausmalbilder/Lessemsaurus.pdf?raw=true)
- [Maiasaura](../Sonstiges/Ausmalbilder/Maiasaura.pdf?raw=true)
- [Oryctodromeus](../Sonstiges/Ausmalbilder/Oryctodromeus.pdf?raw=true)
- [Oviraptor](../Sonstiges/Ausmalbilder/Oviraptor.pdf?raw=true)
- [Tyrannosaurus](../Sonstiges/Ausmalbilder/Tyrannosaurus.pdf?raw=true)
- [Velociraptor](../Sonstiges/Ausmalbilder/Velociraptor.pdf?raw=true)

## Didaktische Materialien
- Präsentation mit Quelltexten (MakeCode, Python, App Inventor) und Datenbank-Tabellen
 im [PDF-Format](../Sonstiges/Cheatcheets.pdf?raw=true) und [PPTX-Format](../Sonstiges/Cheatcheets.pptx?raw=true).
- Datenbank im [SQLITE-Format](../Sonstiges/Datenbank/T-Race.sqlite?raw=true), gut geeignet ist der [DB Browser for SQLite](https://sqlitebrowser.org/)
- ER-Modell der Datenbank als [Bild](../Sonstiges/Datenbank/ERM/T-Race.png?raw=true) und als [XML]()../Sonstiges/Datenbank/ERM/T-Race.xml?raw=true für
 [TerraER](www.terraer.com.br).
- Umfrageergebnisse zum Konsumverhalten von 763 SchülerInnen und LehrerInnen im [CSV-Format](../Sonstiges/Datenbank/umfrage-zum-konsumverhalten-ideenexpo-2019.csv?raw=true).
- Importieren eigener Umfrageergebnisse in die Datenbank mit einem [Python-Skript](../Sonstiges/Datenbank/csvToDatabase.py?raw=true).
- MakeCode-Screenshot zum [Beschreiben der NFC-Karten](../screenshots/Spielkarten_App_Calliope_Blöcke.png?raw=true)
- App Inventor-Screenshots zum [Auslesen der Spielernummer](../screenshots/Spielkarten-App_Blöcke.png?raw=true)
- App Inventor-Screenshots der [Kasino-App](../screenshots/Kasino-App_Blöcke.png?raw=true)

## Sonstiges
- Eine Variante des [Hau den Dino-Projekts](../Shops/Kasino/Hau den Dino_QR.sb3) in Scratch mit einem QR Code, der beim Öffnen des Links den Punktestand in der Datenbank 
speichern lässt.
- Eine kreative DIY-Beamerhalterung für Hau den Dino ist [hier abgebildet](../Sonstiges/Beamerhalterung.jpg?raw=true).



