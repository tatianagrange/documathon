const int ok = 2;
const int cancel = 3;

int okState = 0;
int cancelState = 0;
int isPress = 42;

void setup() {
  pinMode(ok, INPUT);
  pinMode(cancel, INPUT);  
  
  Serial.begin(9600);
}

void loop(){  
  if (digitalRead(ok) == HIGH && okState != isPress) {     
      Serial.println("log1337");
      okState = isPress;
  }else if(digitalRead(ok) == LOW){
      okState = 0;
  }
  
  if (digitalRead(cancel) == HIGH && cancelState != isPress) {     
      Serial.println("btncan");
      cancelState = isPress;
  }else if(digitalRead(cancel) == LOW){
      cancelState = 0;
  }
}
