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

/***************************/
/*    Share declaration    */
/***************************/
LedButton twitter(2,8);
LedButton facebook(3,9);
SwitchButton ok(10);
SwitchButton down(11);
SwitchButton up(12);
SwitchButton cancel(13);
SwitchButton share(7);

/**************************/
/*    NFC declarations    */
/**************************/
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
}

void loop() {
  twitter.switchLed();
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
  boolean hasTag = nfc.tagPresent(50);    //If 50 was 0, the detection is too long and we never catch the buttons.
                                          //This seems to be the correct time to catch the button and the nfc tag.
                                          //You can try to You can try to reduce the time if you want.
  if (hasTag && previous == false)
  {
    NfcTag tag = nfc.read();
    String uid = tag.getUidString();
    Serial.println(LOGIN + uid);
    previous = true;
  }
  else if(!hasTag){
    previous = false;
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

