#include "LedButton.h"

////////////////////////////////////////////////
//                Declarations                //
////////////////////////////////////////////////

/***************************/
/*    Share declaration    */
/***************************/
LedButton twitter(2,8);
LedButton facebook(3,9);

/****************************/
/*    Other declarations    */
/****************************/
//Read values
int reading;

////////////////////////////////////////////////
//                    Code                    //
////////////////////////////////////////////////

/**
*  This function is used to initiate all inputs and output functions
*/
void setup() {
  Serial.begin(9600);
}

/**
*  This function is call in loop
*/
void loop() {
  twitter.switchLed();
  facebook.switchLed();
}

