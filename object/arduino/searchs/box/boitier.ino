// Name convention:
//        type_detail1_detail2_detail3...
// Each separation is in camel case and start with a small letter
// Exemple:
//        btn_share_mySpace
//        led_notif_withBigLight

// Define pins needed
const int btn_share = 2;
const int btn_share_twitter = 3;
const int btn_share_facebook = 4;
const int btn_share_wordpress = 5;
const int btn_next = 6;
const int btn_cancel = 7;

const int led_twitter_blue = 8;
const int led_facebook_blue = 9;
const int led_wordpress_blue = 10;
//const int led_notif_blue = 11;
const int led_notif_red = 12;
const int led_notif_green = 13;

// Define variables
int state_twitter = 0;
int state_facebook = 0;
int state_wordpress = 0;
int state_led_twitter = LOW;
int state_led_facebook = LOW;
int state_led_wordpress = HIGH;
int state_notif = 0;
int state = 0;  

void setup() {
  Serial.begin(9600);
  // Initialize Output:
  pinMode(led_twitter_blue, OUTPUT);
  pinMode(led_facebook_blue, OUTPUT);
  pinMode(led_wordpress_blue, OUTPUT);
  //pinMode(led_notif_blue, OUTPUT);
  pinMode(led_notif_red, OUTPUT);
  pinMode(led_notif_green, OUTPUT);  
  
  // Initialize Input:
  pinMode(btn_share, INPUT);
  pinMode(btn_share_twitter, INPUT);
  pinMode(btn_share_facebook, INPUT);
  pinMode(btn_share_wordpress, INPUT);
  pinMode(btn_next, INPUT);
  pinMode(btn_cancel, INPUT);  
  
}

void loop(){
  /* /!\DIRTY CODE/!\ */

  //Share
  state = digitalRead(btn_share);
  if (state == HIGH) {     
    state_notif = 500; 
    digitalWrite(led_notif_green, HIGH);  
  } 
  else if (state_notif > 0){
    Serial.print(state_notif);
    state_notif--;  
  }
  else{
    state_notif = 0;
    digitalWrite(led_notif_green, LOW); 
  }
  
  //Cancel
  state = digitalRead(btn_cancel);
  if (state == HIGH) {     
    state_notif = 500; 
    digitalWrite(led_notif_red, HIGH);  
  } 
  else if (state_notif > 0){
    Serial.print(state_notif);
    state_notif--;  
  }
  else{
    state_notif = 0;
    digitalWrite(led_notif_red, LOW); 
  }
  
  //Next
  state = digitalRead(btn_next);
  if (state == HIGH) {     
    state_notif = 500; 
    digitalWrite(led_notif_green, HIGH);
    digitalWrite(led_notif_red, HIGH);  
  } 
  else if (state_notif > 0){
    Serial.print(state_notif);
    state_notif--;  
  }
  else{
    state_notif = 0;
    digitalWrite(led_notif_green, LOW); 
    digitalWrite(led_notif_red, LOW);
  }
  
  
  //Twitter
  state = digitalRead(btn_share_twitter);
  if (state == HIGH && state_twitter == 1) {
    state_twitter = 0;   
    state_led_twitter = (state_led_twitter == HIGH) ? LOW : HIGH; 
    digitalWrite(led_twitter_blue, state_led_twitter);  
  } 
  else if (state == LOW){
    state_twitter = 1;
  }
  
  //Facebook
  state = digitalRead(btn_share_facebook);
  if (state == HIGH && state_facebook == 1) {
    state_facebook = 0;   
    state_led_facebook = (state_led_facebook == HIGH) ? LOW : HIGH; 
    digitalWrite(led_facebook_blue, state_led_facebook);  
  } 
  else if (state == LOW){
    state_facebook = 1;
  }
  
  //Wordpress
  state = digitalRead(btn_share_wordpress);
  if (state == HIGH && state_wordpress == 1) {
    state_wordpress = 0;   
    state_led_wordpress = (state_led_wordpress == HIGH) ? LOW : HIGH; 
    digitalWrite(led_wordpress_blue, state_led_wordpress);  
  } 
  else if (state == LOW){
    state_wordpress = 1;
  }
}
