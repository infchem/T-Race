# Verkabelung des Arduino Nano

## Kartenleser
| RFID RC522 | Arduino Nano |
|---|---|
|SDA	|10|
|SCK	|13|
|MOSI|	11|
|MISO|	12|
|GND|	GND an Stromschiene|
|RST	|9|
|3.3V	|3.3V aus Stromschiene|

## RGB LED
|RGB LED | Arduino Nano|
|---|---|
|R	| 4|
|G	| 5|
|B	| 6|
|GND	|GND an Stromschiene|

## ESP8266
| ESP8266 | Arduino Nano (SoftwareSerial) |
|---|---|
|TXD| RX0 3|
|RXD|	TX1 2|
|GND|	GND an Stromschiene|
|VCC|	3.3V an Stromschiene|
|RST|-	|
|CHP0|	VCC selbst|

## Taster
|Taster | Arduino Nano|
|---|---|
|Artikel 1|	A1|
|Artikel 2|	A2|
|Artikel 3|	A3|
|Artikel 4|	A4|
|Artikel 5|	A5|
|Artikel 6|	A6|
|Kauf|	A0|
|GND|	GND an Stromschiene|

## Stromversorgung
|Stromschiene|Arduino Nano|
|---|---|
|-|GND|
|+ (5V)|VIN|
