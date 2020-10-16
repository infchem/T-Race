//Kasino

#include <SPI.h>
#include <MFRC522.h>
#include <SoftwareSerial.h>

static const uint8_t artikel_pins[] = {A1, A2};

MFRC522 mfrc522(10, 9);   //  SS, RST
MFRC522::StatusCode status;
MFRC522::MIFARE_Key key;

// Pins für ESP8266
const byte rxPin = 2, txPin = 3;
SoftwareSerial ESP8266 (rxPin, txPin);

// Daten für Kaufübertragung
String spielerNr;
short artikelNr;

//Daten zum Karten auslesen
byte block;
byte len;
byte buffer2[18];

//RGB Ansteuerung
void setRGBLED(bool, bool, bool);
void setRGBLED(bool red, bool green, bool blue) {
  digitalWrite(4, red);
  digitalWrite(5, green);
  digitalWrite(6, blue);
}

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

  // Tasten
  pinMode(A0, INPUT_PULLUP); // Kauf
  pinMode(A1, INPUT_PULLUP); // Artikel 11
  pinMode(A2, INPUT_PULLUP); // Artikel 12

  sendData("AT+RST\r\n", 2000); // reset module
  sendData("AT+CWMODE=1\r\n", 2000); // configure as client
  //fehlendes Modul: Hostnamen setzten
  sendData("AT+CWJAP=\"T-Race\",\"tracegame\"\r\n", 5000); // connect to t-race AP
  sendData("AT+CIPMUX=1\r\n", 2000); // multichannel mode
}

void loop()
{
  for (int i = 0; i < 2; i++) {
    if (digitalRead(artikel_pins[i]) == LOW) {
      artikelNr = i + 11;
      setRGBLED(0, 0, 1);
    }
  }

  // Kauftaste gedrückt
  if (digitalRead(A0) == LOW) delay(5); //einfacher Prellschutz
  if (digitalRead(A0) == LOW) {

    if (artikelNr == 0)
      return;  // Keine Artikelnummer ausgewählt --> abbrechen
    else {
      digitalWrite(4, LOW);
      block = 1;
      len = 18;

      status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, 1, &key, &(mfrc522.uid));
      if (status != MFRC522::STATUS_OK)
        return;

      status = mfrc522.MIFARE_Read(block, buffer2, &len);
      if (status != MFRC522::STATUS_OK)
        return;

      for (uint8_t i = 1; i < 16; i++)
        spielerNr += (buffer2[i]);

      Serial.println(spielerNr);

      if (spielerNr != "")
        setRGBLED(1, 0, 1);

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
        setRGBLED(0, 1, 0);
        delay(500);
        setRGBLED(0, 0, 0);
      }
    }

  }
  Serial.println(response);
  return response;
}
