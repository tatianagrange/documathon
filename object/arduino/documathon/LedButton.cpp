#include <Arduino.h>
#include "LedButton.h"

LedButton::LedButton(int ledPin, int btnPin)
{
    _ledPin = ledPin;
    _btnPin = btnPin;
    pinMode(_ledPin, OUTPUT);
    pinMode(_btnPin, INPUT);
    _state = HIGH;
    _previous = LOW;
    _time = 0;
    _debounce = 500;
}


/**
*  This function is used to switch off or switch on a led according to a button.
*  @params btn - It is the input of the button to read
*  @params previous - It is the state of the button in the previous loop
*  @params outPin - It is the output where we have to write
*/
void LedButton::switchLed()
{
    int reading = digitalRead(_btnPin);
    Serial.println(reading);
    if (reading == HIGH && _previous == LOW && millis() - _time > _debounce) {
        if (_state == HIGH){
            _state = LOW;
            Serial.println("LOW");
        }else{
            _state = HIGH;
            Serial.println("HIGH");
        }
        
        _time = millis();
    }
    
    digitalWrite(_ledPin, _state);
    
    _previous = reading;
}
