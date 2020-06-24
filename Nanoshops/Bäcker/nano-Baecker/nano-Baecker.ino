/*
   Bäcker-Shop
*/

#include <SPI.h>
#include <MFRC522.h>
#include <SoftwareSerial.h>

static const uint8_t artikel_pins[] = {A1, A2, A3, A4}; // Pinanzahl anpassen!

MFRC522 mfrc522(10, 9);   //  SS, RST
MFRC522::StatusCode status;
MFRC522::MIFARE_Key key;

// Pins für ESP8266
const byte rxPin = 2;
const byte txPin = 3;
SoftwareSerial ESP8266 (rxPin, txPin);

// Daten für Kaufübertragung
String spielerNr;
int artikelNr;

//Daten zum Karten auslesen
byte block;
byte len;
byte buffer2[18];

void setup()
{

  Serial.begin(9600);  // USB-Debug Baudrate
  ESP8266.begin(9600); // ESP8266 Baudrate

  SPI.begin();      // Init SPI bus
  mfrc522.PCD_Init(); // Init RC522

//  Prepare key - all keys are set to FFFFFFFFFFFFh at chip delivery from the factory.
  for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;

  spielerNr = "";
  artikelNr = 0;

  // RGB LED
  pinMode(4, OUTPUT); // Rot
  pinMode(5, OUTPUT); // Grün
  pinMode(6, OUTPUT); // Blau

  // Tasten
  pinMode(A0, INPUT_PULLUP); // Kauf
  pinMode(A1, INPUT_PULLUP); // Artikel 7
  pinMode(A2, INPUT_PULLUP); // Artikel 8
  pinMode(A3, INPUT_PULLUP); // Artikel 9
  pinMode(A4, INPUT_PULLUP); // Artikel 10
  //  pinMode(A5, INPUT_PULLUP); // unbenutzt
  //  pinMode(A6, INPUT_PULLUP); // unbenutzt

  sendData("AT+RST\r\n", 2000); // reset module
  sendData("AT+CWMODE=1\r\n", 2000); // configure as client
  sendData("AT+CWJAP=\"T-Race\",\"tracegame\"\r\n", 5000); // connect to t-race AP
  sendData("AT+CIPMUX=1\r\n", 2000); // mnultichannel mode
}

void loop()
{
  for (int i = 0; i < 4; i++) {             // 4 an Artikelanzahl anpassen!
    if (digitalRead(artikel_pins[i]) == LOW) {
      artikelNr = i + 7;                    // 7 an erste ArtikelNr anpassen!

      digitalWrite(4, LOW);
      digitalWrite(5, LOW);
      digitalWrite(6, HIGH);
    }
  }


  // Kauftaste gedrückt

  if (digitalRead(A0) == LOW) delay(5); //einfacher Prellschutz

  if (digitalRead(A0) == LOW) {

    if (artikelNr == 0) {
      // Keine Artikelnummer ausgewählt, abbrechen
      return;
    } else {
      digitalWrite(4, LOW);
      block = 1;
      len = 18;

      status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, 1, &key, &(mfrc522.uid));
      if (status != MFRC522::STATUS_OK) {
        return;
      }

      status = mfrc522.MIFARE_Read(block, buffer2, &len);
      if (status != MFRC522::STATUS_OK) {
        return;
      }

      for (uint8_t i = 1; i < 16; i++) {
        spielerNr += (buffer2[i]);
      }
      Serial.println(spielerNr);

      if (spielerNr != "") {
        digitalWrite(4, LOW);
        digitalWrite(5, HIGH);
        digitalWrite(6, LOW);
      }

      delay(500); //change value if you want to read cards faster

      mfrc522.PICC_HaltA();
      mfrc522.PCD_StopCrypto1();




      String openCommand = "AT+CIPSTART=4,\"TCP\",\"10.3.141.1\",80";
      openCommand += "\r\n";
      sendData(openCommand, 3000);

      // URL zur Kaufübertragung
      String cmd = "GET /api/v1.php?players/";
      cmd += spielerNr;
      cmd += "/buy/";
      cmd += artikelNr;
      cmd += " HTTP/1.0\r\n";
      cmd += "Host: 10.3.141.1\r\n";
      cmd += "Connection: close\r\n";
      cmd += "Cache-Control: no-cache\r\n\r\n";

      espsend(cmd);
    }
  }
}

void espsend(String d)
{
  String cipSend = " AT+CIPSEND=4";
  cipSend += ",";
  cipSend += String(d.length());
  cipSend += "\r\n";
  sendData(cipSend, 1000);
  sendData(d, 3000);
  // sendData("\r\n",1000);
}

String sendData(String command, const int timeout)
{
  String response = "";
  Serial.println(command);
  ESP8266.print(command);
  long int time = millis();
  while ( (time + timeout) > millis())
  {
    while (ESP8266.available())
    {
      char c = ESP8266.read(); // read the next character.
      response += c;

    }


    if ((response.indexOf("OK") > 0) || (response.indexOf("true") > 0)) {
      
      for (int i = 0; i < 4; i++) {
      digitalWrite(4, LOW);
        digitalWrite(5, HIGH);
        digitalWrite(6, LOW);
        delay(500);
        digitalWrite(4, LOW);
        digitalWrite(5, LOW);
        digitalWrite(6, LOW);
      }
    }

  }
  Serial.println(response);
  return response;
}
