#ifndef LedButton_h
#define LedButton_h

#include <Arduino.h>

class LedButton
{
private:
    int _ledPin;
    int _btnPin;
    int _state;
    int _previous;
    unsigned long _time;
    long _debounce;
    
public:
    LedButton(int led, int btn);
    void switchLed();
};

#endif
