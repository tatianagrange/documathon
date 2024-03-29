#include "LedButton.h"
#include "SwitchButton.h"
#include "Protocol.h"
#include <Wire.h>
#include <PN532_I2C.h>
#include <PN532.h>
#include <NfcAdapter.h>

////////////////////////////////////////////////
//                Declarations                //
////////////////////////////////////////////////

byte byteRead;
String readString;

/* ************************* */
/*    Share declaration      */
/* ************************* */
LedButton twitter(2,8);
LedButton printbtn(4,6);
LedButton facebook(3,9);
SwitchButton ok(10);
SwitchButton down(12);
SwitchButton up(11);
SwitchButton cancel(13);
SwitchButton share(7);

/* ************************ */
/*    NFC declarations      */
/* ************************ */
PN532_I2C pn532_i2c(Wire);
NfcAdapter nfc = NfcAdapter(pn532_i2c);
boolean previous;

////////////////////////////////////////////////
//                 Base Code                  //
////////////////////////////////////////////////
void setup() {
  Serial.begin(9600);
  nfc.begin(false);
  previous = false;
  readString = "";
}

void loop() {
  
  while (Serial.available()) {
    delay(3);
    if (Serial.available() > 0) {
      char c = Serial.read();
      readString += c;
    } 
  }
  
  if (readString.length() >0) {
    writeNFCTag();
  }
  
  twitter.switchLed();
  printbtn.switchLed();
  facebook.switchLed();
  ok.makeSwitch();
  down.makeSwitch();
  up.makeSwitch();
  cancel.makeSwitch();
  share.makeSwitch();


  //Check to send share
  String toSend = "";
  if(share.canLaunchSignal()){
    toSend += SHARE;
    
    if(facebook.getState() == HIGH){
      toSend += FACEBOOK;
    }
    if(twitter.getState() == HIGH){
      toSend += TWITTER;
    }
      
    Serial.println(toSend);
  }
  
  //Check to send for other buttons
  launchSignal(ok, BUTTON_VALIDATE);
  launchSignal(down, BUTTON_DOWN);
  launchSignal(up, BUTTON_UP);
  launchSignal(cancel, BUTTON_CANCEL);
  
  //Check for NFC tag
  String result = readNfcTag();
  if(result != ""){
    Serial.println(result);
  }
}

////////////////////////////////////////////////
//                 Functions                  //
////////////////////////////////////////////////

void launchSignal(SwitchButton btn, String toSend)
{
  if(btn.canLaunchSignal()){
    Serial.println(toSend);
  }
}

String readNfcTag(){
  boolean hasTag = nfc.tagPresent(40);    //If 40 was 0, the detection is too long and we never catch the buttons.
                                          //This seems to be the correct time to catch the button and the nfc tag.
                                          //You can try to You can try to reduce the time if you want.
  if (hasTag && previous == false)
  {
    NfcTag tag = nfc.read();
    NdefMessage mess = tag.getNdefMessage();
    NdefRecord record = mess.getRecord(0);
    byte payloadCheck[record.getPayloadLength()];
    record.getPayload(payloadCheck);
    
    String toSend = "";
    for(int i = 3 ; i < record.getPayloadLength() ; i++){  // Start at 3. The 3 frists char are for the encoding.
        toSend += (char)payloadCheck[i];
    }
    previous = true;
    return toSend;
    
  }
  else if(!hasTag){
    previous = false;
  }
  return "";
}

String getInstruction(String route){
  String toSend = "";
  for(int i = 0 ; i < 3 ; i++){  
      toSend += (char)route[i];
  }
  return toSend;
}

void writeNFCTag(){
  if (readString.substring(0,3) == "srv") {
    String json = readString.substring(3);
    
    if (nfc.tagPresent(40)) {
      bool success = nfc.erase();
      if (!success) {
        Serial.println(NOTIFICATION + NOT_CANCEL);
        return;
      }
      
      NdefMessage message = NdefMessage();
      message.addTextRecord(json);
      success = nfc.write(message);
      readString = "";
      if (!success) {
        Serial.println(NOTIFICATION + NOT_CANCEL);
      }
      else{
        Serial.println(NOTIFICATION + NOT_WRITE);
      }
    }
  }
  else if (readString.substring(0,3) == "bac") {
    readString = "";
  }
}



