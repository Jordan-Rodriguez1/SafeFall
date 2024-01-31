//LIBRERÌAS
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include "DHT.h"
#include <NewPing.h>
#include <LiquidCrystal_I2C.h>

//PINES
#define DHTPIN 4       // El pin al que está conectado el sensor DHT11 (cambia según tu configuración)
#define DHTTYPE DHT11  // Tipo de sensor DHT (DHT11 o DHT22)
#define TRIGGER_PIN 17  // Pin del ESP32 conectado al pin TRIGGER del sensor HC-SR04
#define ECHO_PIN 5     // Pin del ESP32 conectado al pin ECHO del sensor HC-SR04
#define MAX_DISTANCE 200 // Distancia máxima que deseas medir en centímetros (ajusta según tus necesidades)
#define RELAY_AGUA 16 // Pin del ESP32 conectado al relé (ajusta según tu configuración)
#define RELAY_VENT 18 // Pin del ESP32 conectado al relé (ajusta según tu configuración)
#define RELAY_LUZ 12 // Pin del ESP32 conectado al relé (ajusta según tu configuración)
#define RELAY_SUELO 14 // Pin del ESP32 conectado al relé (ajusta según tu configuración)
#define LDR_PIN 35   // Pin analógico del ESP32 al que está conectada la fotorresistencia
#define SOIL_MOISTURE_SENSOR_PIN 34 // Pin analógico del ESP32 al que está conectado el sensor de humedad del suelo
#define SOIL_DRY_VALUE 4095        // Valor de lectura cuando el suelo está seco
#define SOIL_WET_VALUE 0           // Valor de lectura cuando el suelo está húmedo
#define GAS_SENSOR_PIN 13 // Pin del ESP32 conectado al sensor MQ-4
#define lm35Pin 32 // Pin del ESP32 conectado al sensor LM35

//CLASES
NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE);
DHT dht(DHTPIN, DHTTYPE);
LiquidCrystal_I2C lcd(0x27, 16, 2);

// CONSTANTES
//const char* WIFI_SSID = "MEGACABLE_2.4G_EBC8";
//const char* WIFI_PASSWORD = "J6T7e2M8J4T5D4Z7a2a2";
const char* WIFI_SSID = "Jordan";
const char* WIFI_PASSWORD = "Inception11";
const char* IngresarDatos = "http://192.168.200.222/CulTech/Esp/RegistroDatos";
const char* IngresarAcciones = "http://192.168.200.222/CulTech/Esp/Acciones";
//const char* IngresarDatos = "http://tesis.42web.io/Esp/RegistroDatos";
//const char* IngresarAcciones = "http://tesis.42web.io/Esp/Acciones";
const char* id_placa = "12345678";

void setup() {
  Serial.begin(115200);
  //INICIALIZAMOS SENSOR, WIFI Y LCD
  dht.begin();
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  lcd.init();
  lcd.backlight();

  //CONECTAMOS A INTERNET
  while (WiFi.status() != WL_CONNECTED) {
    Serial.println("Conectando a la red WiFi...");
    //LCD
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Conectando a la");
    lcd.setCursor(0,1);
    lcd.print("red WiFi...");
    delay(1000);
  }
  Serial.println("Conexión WiFi establecida.");
  //LCD
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Conexión WiFi");
  lcd.setCursor(0,1);
  lcd.print("establecida.");

  //PONEMOS LOS RELÉS COMO APAGADOS
  pinMode(RELAY_AGUA, OUTPUT);
  digitalWrite(RELAY_AGUA, LOW); // Apagar el relé al inicio
  pinMode(RELAY_VENT, OUTPUT);
  digitalWrite(RELAY_VENT, LOW); // Apagar el relé al inicio
  pinMode(RELAY_LUZ, OUTPUT);
  digitalWrite(RELAY_LUZ, LOW); // Apagar el relé al inicio
  pinMode(RELAY_SUELO, OUTPUT);
  digitalWrite(RELAY_SUELO, LOW); // Apagar el relé al inicio
}

void loop() {
  int ciclo = 0;
  while (WiFi.status() == WL_CONNECTED) {
    //LCD
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Ciclo: "+String(ciclo));
    Serial.print("Ciclo: ");
    Serial.println(ciclo);
    delay(5000); //5 SEGUNDOS ACUMULADOS
    //LCD
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Leyendo datos...");

    //DEFINIMOS TODAS LAS VARIABLES
    //Lee Distancia
    unsigned int distance = sonar.ping_cm();
    distance = 10 - distance; //AQUI DEBE SER 100 cm-------------------------------------------------------------
    // Lee el valor analógico luz
    int lightValue = analogRead(LDR_PIN);
    String estadoluz = "";
    // Lee el valor analógico de humedad suelo
    int soilMoisture = analogRead(SOIL_MOISTURE_SENSOR_PIN);
    float hsuelo = map(soilMoisture, SOIL_DRY_VALUE, SOIL_WET_VALUE, 0, 100);
    // Lee el valor analógico del gas
    pinMode(GAS_SENSOR_PIN, INPUT);
    int gasValue = analogRead(GAS_SENSOR_PIN);
    // Lee el valor analógico del sensor LM35
    int rawValue = analogRead(lm35Pin);
    // Convierte el valor leído a temperatura en grados Celsius
    float temperatureC = (rawValue * 330) / 4095;
    // Lee el valor DHT
    float temperature = dht.readTemperature();
    float humidity = dht.readHumidity();
    //TIEMPO ENTRE CICLO
    //int tiempoDeRetardo = 1780000; //30 MIN - 20S
    int tiempoDeRetardo = 300000; //5MIN -------------------------------------------------------------
    //CICLOS
    if (ciclo == 48) {
      ciclo = 0;
    }
    delay(5000); //10 SEGUNDOS ACUMULADOS

    //SERIAL
    Serial.print("Valor de luz: ");
    Serial.println(lightValue);
    Serial.print("Distancia: ");
    Serial.print(distance);
    Serial.println(" cm");
    Serial.print("Temperatura: ");
    Serial.print(temperature);
    Serial.println(" °C");
    Serial.print("Humedad: ");
    Serial.print(humidity);
    Serial.println(" %");
    Serial.print("Humedad del suelo: ");
    Serial.print(hsuelo);
    Serial.println("%");
    Serial.print("Lectura del sensor de gas: ");
    Serial.println(gasValue);
    Serial.print("Temperatura del suelo: ");
    Serial.print(temperatureC);
    Serial.println(" °C");

    //LCD
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Mandando datos...");

    //CONFIGURAMOS PARA HACER POST
    WiFiClient client;
    HTTPClient http;
    http.begin(client, IngresarDatos);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    //GUARDAMOS LOS DATOS EN UNA VARIABLE
    String data = "id_placa=" + String(id_placa)+"&tem=" + String(temperature)+"&humendad=" + String(humidity)+"&stem=" + String(temperatureC)+"&shumendad=" + String(hsuelo)+"&luz=" + String(lightValue)+"&co2=" + String(gasValue)+"&altura=" + String(distance);

    //HACEMOS EL POST
    int httpResponseCode = http.POST(data);
    delay(5000); //15 SEGUNDOS ACUMULADOS

    if (httpResponseCode > 0) {
      Serial.print("Respuesta del servidor: ");
      Serial.println(httpResponseCode);
      String response = http.getString();

      //LCD
      lcd.clear();
      lcd.setCursor(0,0);
      lcd.print("Analizando datos");

      // Procesa la respuesta JSON
      DynamicJsonDocument doc(1024); // Ajusta el tamaño según tus necesidades
      DeserializationError error = deserializeJson(doc, response);

      if (error) {
        Serial.println("Error al analizar JSON");
        //LCD
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("Error al");
        lcd.setCursor(0,1);
        lcd.print("analizar JSON.");
        delay(20000);
      } else {
        // Extrae los datos de configuración del JSON y guárdalos en variables
        float tem_max = doc["tem_max"];
        float tem_min = doc["tem_min"];
        float humedad_max = doc["humedad_max"];
        float humedad_min = doc["humedad_min"];
        float stem_max = doc["stem_max"];
        float stem_min = doc["stem_min"];
        float shumedad_max = doc["shumedad_max"];
        float shumedad_min = doc["shumedad_min"];
        float co2_max = doc["co2_max"];
        float luz = doc["luz"];
        delay(5000); //20 SEGUNDOS ACUMULADOS

        //AHORA ANALIZAMOS LOS DATOS TOMANDO EN CUENTA LA CONFIGURACIÓN
        //LUZ
        if (ciclo < (luz*2)) {
          if (lightValue > 500) {
            digitalWrite(RELAY_LUZ, HIGH);
            lightValue = analogRead(LDR_PIN);
            if (lightValue > 500) {
              estadoluz = "ERR";
            } else {
              estadoluz = "ON";
            }
          } else {
            estadoluz = "ON";
          }
        } else {
          if (lightValue < 500) {
            digitalWrite(RELAY_LUZ, LOW);
            lightValue = analogRead(LDR_PIN);
            if (lightValue < 500) {
              estadoluz = "ERR";
            } else {
              estadoluz = "OFF";
            }
          } else {
            estadoluz = "OFF";
          }
        }

        //AGUA - FALTA HUMEDAD
        float rango =  (shumedad_max - shumedad_min) * 0.3;
        if (hsuelo < (shumedad_min + rango)){ 
          while (hsuelo < (shumedad_min + rango + rango) && tiempoDeRetardo > 120000) { //AQUI DEBE SER 5 MIN (300000)-------------------------------------------------------------
            digitalWrite(RELAY_AGUA, HIGH);
            tiempoDeRetardo -= 60000;
            //LCD
            lcd.clear();
            lcd.setCursor(0,0);
            lcd.print("Regando Cultivo");
            lcd.setCursor(0,1);
            lcd.print("Hum Suelo=" + String(hsuelo) + "%");

            http.begin(client, IngresarAcciones);
            http.addHeader("Content-Type", "application/x-www-form-urlencoded");

            String accion = "id_placa=" + String(id_placa)+"&codigo=1001";
            //HACEMOS EL POST
            int httpResponseCode = http.POST(accion);
            delay(55000); // Espera 55 segundos
            if (httpResponseCode > 0) {
              Serial.print("Respuesta del servidor: ");
              Serial.println(httpResponseCode);

              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Accion");
              lcd.setCursor(0,1);
              lcd.print("registrada...");
            } else {
              Serial.print("Error en la solicitud. Código de respuesta: ");
              Serial.println(httpResponseCode);
              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Error al mandar");
              lcd.setCursor(0,1);
              lcd.print("los datos...");
            }
            delay(5000); // Espera 5 segundos
            soilMoisture = analogRead(SOIL_MOISTURE_SENSOR_PIN);
            hsuelo = map(soilMoisture, SOIL_DRY_VALUE, SOIL_WET_VALUE, 0, 100);
          }
          digitalWrite(RELAY_AGUA, LOW); // Apaga el relé
        }

        //FALTA TEMPERATURA
        float rangoT =  (stem_max - stem_min) * 0.3;
        if (temperatureC < (stem_min + rangoT)){ 
          while (temperatureC < (stem_min + rangoT + rangoT) && tiempoDeRetardo > 120000) { //AQUI DEBE SER 5 MIN (300000)-------------------------------------------------------------
            digitalWrite(RELAY_SUELO, HIGH);
            tiempoDeRetardo -= 60000;
            //LCD
            lcd.clear();
            lcd.setCursor(0,0);
            lcd.print("Calentador ON");
            lcd.setCursor(0,1);
            lcd.print("Temp Suelo=" + String(temperatureC) + " C");

            http.begin(client, IngresarAcciones);
            http.addHeader("Content-Type", "application/x-www-form-urlencoded");

            String accion = "id_placa=" + String(id_placa)+"&codigo=1002";
            //HACEMOS EL POST
            int httpResponseCode = http.POST(accion);
            delay(55000); // Espera 55 segundos
            if (httpResponseCode > 0) {
              Serial.print("Respuesta del servidor: ");
              Serial.println(httpResponseCode);

              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Accion");
              lcd.setCursor(0,1);
              lcd.print("registrada...");
            } else {
              Serial.print("Error en la solicitud. Código de respuesta: ");
              Serial.println(httpResponseCode);
              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Error al mandar");
              lcd.setCursor(0,1);
              lcd.print("los datos...");
            }
            delay(5000); // Espera 5 segundos

            rawValue = analogRead(lm35Pin);
            temperatureC = (rawValue * 330) / 4095;
          }
          digitalWrite(RELAY_SUELO, LOW); // Apaga el relé
        }

        //SOBRA TEMP o CO2 MAX
        float rangoG =  co2_max - co2_max * 0.3;
        if ((temperatureC > (stem_max - rangoT) || gasValue > (co2_max - rangoG))){ 
          while ((temperatureC > (stem_max - rangoT - rangoT) || gasValue > (co2_max - rangoG - rangoG)) && tiempoDeRetardo > 120000) { //AQUI DEBE SER 5 MIN (300000)-------------------------------------------------------------
            digitalWrite(RELAY_VENT, HIGH);
            tiempoDeRetardo -= 60000;
            //LCD
            lcd.clear();
            lcd.setCursor(0,0);
            lcd.print("Ventilacion ON");
            lcd.setCursor(0,1);
            lcd.print("T=" + String(temperatureC) + " C G=" + String(gasValue) + " PPM");

            http.begin(client, IngresarAcciones);
            http.addHeader("Content-Type", "application/x-www-form-urlencoded");

            String accion = "id_placa=" + String(id_placa)+"&codigo=1003";
            //HACEMOS EL POST
            int httpResponseCode = http.POST(accion);
            delay(55000); // Espera 55 segundos
            if (httpResponseCode > 0) {
              Serial.print("Respuesta del servidor: ");
              Serial.println(httpResponseCode);

              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Accion");
              lcd.setCursor(0,1);
              lcd.print("registrada...");
            } else {
              Serial.print("Error en la solicitud. Código de respuesta: ");
              Serial.println(httpResponseCode);
              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Error al mandar");
              lcd.setCursor(0,1);
              lcd.print("los datos...");
            }
            delay(5000); // Espera 5 segundos
            rawValue = analogRead(lm35Pin);
            temperatureC = (rawValue * 330) / 4095;
            gasValue = analogRead(GAS_SENSOR_PIN);
          }
          digitalWrite(RELAY_VENT, LOW); // Apaga el relé
        }

        //SOBRA HUMEDAD
        if (hsuelo > (shumedad_max - rango) && shumedad_max != 100){ 
          while (hsuelo > (shumedad_max - rango - rango) && tiempoDeRetardo > 120000) { //AQUI DEBE SER 5 MIN (300000)-------------------------------------------------------------
            digitalWrite(RELAY_VENT, HIGH);
            digitalWrite(RELAY_SUELO, HIGH);
            tiempoDeRetardo -= 60000;
            //LCD
            lcd.clear();
            lcd.setCursor(0,0);
            lcd.print("Exceso Humedad");
            lcd.setCursor(0,1);
            lcd.print("Hum Suelo=" + String(hsuelo) + "%");

            http.begin(client, IngresarAcciones);
            http.addHeader("Content-Type", "application/x-www-form-urlencoded");

            String accion = "id_placa=" + String(id_placa)+"&codigo=1004";
            //HACEMOS EL POST
            int httpResponseCode = http.POST(accion);
            delay(55000); // Espera 55 segundos
            if (httpResponseCode > 0) {
              Serial.print("Respuesta del servidor: ");
              Serial.println(httpResponseCode);

              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Accion");
              lcd.setCursor(0,1);
              lcd.print("registrada...");
            } else {
              Serial.print("Error en la solicitud. Código de respuesta: ");
              Serial.println(httpResponseCode);
              //LCD
              lcd.clear();
              lcd.setCursor(0,0);
              lcd.print("Error al mandar");
              lcd.setCursor(0,1);
              lcd.print("los datos...");
            }
            delay(5000); // Espera 5 segundos
            soilMoisture = analogRead(SOIL_MOISTURE_SENSOR_PIN);
            hsuelo = map(soilMoisture, SOIL_DRY_VALUE, SOIL_WET_VALUE, 0, 100);
          }
          digitalWrite(RELAY_VENT, LOW); // Apaga el relé
          digitalWrite(RELAY_SUELO, LOW); // Apaga el relé
        }

      }

      //MUESTRA LOS DATOS EN PANTALLA
      while (tiempoDeRetardo > 5000) { //AQUI DEBE SER 5 SEC (5000)
        tiempoDeRetardo -= 20000;
        //LCD
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("T=" + String(temperature) + " C H=" + String(humidity) + "%");
        lcd.setCursor(0, 1);
        lcd.print("SH=" + String(hsuelo) + "% L=" + String(estadoluz));
        delay(10000); // Espera 10 segundos (10000 ms)
        //LCD
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("ST=" + String(temperatureC) + " C");
        lcd.setCursor(0, 1);
        lcd.print("G=" + String(gasValue) + " PPM A=" + String(distance) + " CM");
        delay(10000); // Espera 10 segundos (10000 ms)
      }

    } else {
      Serial.print("Error en la solicitud. Código de respuesta: ");
      Serial.println(httpResponseCode);
      //LCD
      lcd.clear();
      lcd.setCursor(0,0);
      lcd.print("Error al mandar");
      lcd.setCursor(0,1);
      lcd.print("datos de cultivo");
    }

    http.end();
    ciclo++;
    delay(tiempoDeRetardo); //
  }
}
