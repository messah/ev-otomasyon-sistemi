// Pin8 kombiye bağlı
// Pin10 klimaya bağlı

int ledPins[3] = {8, 10, 12};
int states[2] = {false, false};
int veri = 0;
int lol;
char gelen_veri[5];

int sicaklik_pin = 0;
float gerilim;
float sicaklik;

void setup() 
{
    pinMode(ledPins[0], OUTPUT); // pin will be used to for output
    pinMode(ledPins[1], OUTPUT); // pin will be used to for output

    pinMode(ledPins[2], INPUT);
    
    Serial.begin(9600); // seri haberleşmeyi aktifleştir

    digitalWrite(ledPins[0],LOW);
    digitalWrite(ledPins[1],LOW);

}

void loop() 
{
  

  lol = digitalRead(ledPins[2]);

  if(lol == HIGH) {
    if(states[0] == true) {
      Serial.print("2");
      digitalWrite(ledPins[0], LOW);
      states[0] = false;
    }
    else{
      Serial.print("2");
      digitalWrite(ledPins[0], HIGH);
      states[0] = true;
    }
    delay(1000);
  }

  if (Serial.available() > 0)
  {
    int dataCounter = 0;
    while((veri = Serial.read()) != ':') {
      if(veri!= -1) {
        gelen_veri[dataCounter] = veri;
        ++dataCounter;
      }
    }
    while(Serial.available() > 0) {
      veri = Serial.read();
    }
    processData();
  }

}

void processData()
{
  switch(gelen_veri[0])
    {
      case '0': // Gelen veri 0 se kombiyle ilgili işlem yap
        if(states[0] == false) {    // kombi kapalıysa aç
          digitalWrite(ledPins[0],HIGH);
          states[0] = true;
        }
        else {                      // kombi açıksa kapat
          digitalWrite(ledPins[0],LOW);
          states[0] = false;
        }
        break;
      case '1': // Gelen veri 1 se klimayla ilgili işlem yap
        if(states[1] == false) {    // klima kapalıysa aç
          digitalWrite(ledPins[1],HIGH);
          states[1] = true;
        }
        else {                      // klima açıksa kapat
          digitalWrite(ledPins[1],LOW);
          states[1] = false;
        }
        break;
      case '2': // bir pinin digital değerini oku
        Serial.println(digitalRead(ledPins[gelen_veri[1] - '0']));
        break;
    }
  
}
