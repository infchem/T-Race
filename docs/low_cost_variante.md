# T-Race in der Low-Cost-Variante

Da die Ideenfang-Variante nicht ganz so günstig ist, haben wir eine Low-Cost-Variante zusammengestellt.
Im Wesentlichen wird für die Shops günstigere Hardware verwendet. Statt Pi Zero W und Calliope mini kommen ein ESP8266 und ein Arduino Nano zum Einsatz. Statt Grove NFC und Multitouch Sensoren ein RC522 und einfache Drucktaster. Die Verkabelung erfolgt auf Steckbrettern, die gesamte Hardware wird in einem selbstgedruckten Gehäuse untergebracht, kann aber auch individuell verpackt werden.

Aufgrund des verwendeten Nano bezeichnen wir in dieser Variante die Shops als Nanoshops, um sie von der Ideenfang-Variante zu unterscheiden (da wäre der Name Minishops ganz passend, wegen der Calliope mini...). 


## Materialliste
Ein Spiel besteht aus einem Server, mehreren Shops und den Smartphones der Spieler. In der Low-Cost-Variante werden für Server und Shops insgesamt folgende Dinge benötigt:

### Server
- 1 RaspberryPi Zero W oder RaspberryPi 3 Mod. A+ (beide erfolgreich getestet)
- 1 Gehäuse (z.B. Pibow Case oder RASP 3A+ CASE RW)
- 1 Netzteil mit Micro-USB-Kabel (z.B. mit Ausgang 5V / 2.5A)
- 1 microSD Karte mit 32 GB (z.B. Sandisk Ultra 32GB)

### Nanoshops
- 6 Arduino Nano (oder kompatibel) mit USB/TTL-Chip (z.B. mit CH340)
- 6 ESP-01S mit Breadboard Adapter
- 6 Widerstand 1 kOhm
- 6 Widerstand 2 kOhm
- 6 RC522 RFID-Kartenleser
- 6 Breadboard mini mit Stromschienen, 300/100 Kontakte
- 6 Spannungsversorgungs-Platine 3.3V / 5V für Breadboard (z.B. MB102)
- 6 Netzteil für MB102 (z.B. Rundstecker 5.5mm/2.1mm und mit Ausgang 9V / 660 mA)
- 26 Taster (z.B. Multimec 3FTH9 mit Printanschluss)
- 20 Kappe grün für Artikeltasten (z.B. Mec Switches 1D02)
- 6 Kappe rot für Kauftaste (z.B. Mec Switches 1D08)
- 6 RGB LED (z.B. KY-016)
- 6 "Experimentier-Platine" (79,1X51,1)
- 12 Buchsenleiste 2x5 pol gewinkelt
- 1 Klassensatz RFID-Karten Typ Mifare Classic 1k 
- 1 USB-Kabel mit A-Stecker auf Mini-B-Stecker zum Programmieren der Nanos
- 1 Rolle Schaltdraht, bspw. YV 1X0.2 QMM
- Seitenschneider
- Laptop/PC zum Programmieren
- 3 A4-Seiten Farbausdrucke, am besten mit Laserdrucker auf Aufkleberpapier

### Kasino
- 1 STM32F103C8T6
- 1 Adapter microUSB auf USB Typ A
- 1 USB auf miniUSB-Kabel
- 1 Android Smartphone oder -Tablet
- 1 Laptop
- 1 Beamer
- 1 Hau den Dino-Spiel für das Kasino
- 1 Heißer Dino-Spiel für das Kasino
- ggf. Shopartikel (3D-Druck, Schneideplotter)


## Material vorbereiten
### Server

Für den Server auf Basis eines RaspberryPi Zero W gibt es eine separate [Anleitung](installation_server.md).
Diese funktioniert auch mit einem Raspberry Pi 3 Mod A+.

### Shops

Für die Softwareinstallation gibt es für die RaspberryPi Zero W eine [gemeinsame Anleitung](ideenfang_installation_shops.md).

Die unterschiedlichen Anpassungen an die Calliope mini und sonstige Hardware sind:

- für den [Bäcker](ideenfang_installation_bäcker.md)
- für den [Fanshop](ideenfang_installation_fanshop.md)
- für den [Sportladen](ideenfang_installation_sportladen.md)
- für das [Fast Food-Restaurant](ideenfang_installation_fastfood.md)
- für das [Kasino](ideenfang_installation_kasino.md)
- für den [Supermarkt](ideenfang_installation_supermarkt.md)
- für den [Webshop](ideenfang_installation_webshop.md)

### Shopboxen
ToDo

## T-Race Spielkarten-App
ToDo


