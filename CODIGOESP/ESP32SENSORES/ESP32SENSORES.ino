#include "DHT.h"
#include <NewPing.h>
#include <LiquidCrystal_I2C.h>

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

NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE);

DHT dht(DHTPIN, DHTTYPE);

LiquidCrystal_I2C lcd(0x27, 16, 2);

void setup() {
  Serial.begin(115200);
  dht.begin();
  pinMode(RELAY_AGUA, OUTPUT);
  digitalWrite(RELAY_AGUA, LOW); // Apagar el relé al inicio
  pinMode(RELAY_VENT, OUTPUT);
  digitalWrite(RELAY_VENT, LOW); // Apagar el relé al inicio
  pinMode(RELAY_LUZ, OUTPUT);
  digitalWrite(RELAY_LUZ, LOW); // Apagar el relé al inicio
  pinMode(RELAY_SUELO, OUTPUT);
  digitalWrite(RELAY_SUELO, LOW); // Apagar el relé al inicio

  lcd.init();
  lcd.backlight();
}

void loop() {
  delay(5000);  // Espera 15 segundos entre lecturas

  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();

  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Error al leer el sensor DHT11");
    return;
  }

  //LCD
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Activando rele...");
  // Activa el relé durante 5 segundos
  digitalWrite(RELAY_AGUA, HIGH);
  delay(1000); // Espera 5 segundos (5000 ms)
  digitalWrite(RELAY_AGUA, LOW); // Apaga el relé
  // Activa el relé durante 5 segundos
  digitalWrite(RELAY_VENT, HIGH);
  delay(1000); // Espera 5 segundos (5000 ms)
  digitalWrite(RELAY_VENT, LOW); // Apaga el relé
  // Activa el relé durante 5 segundos
  digitalWrite(RELAY_LUZ, HIGH);
  delay(1000); // Espera 5 segundos (5000 ms)
  digitalWrite(RELAY_LUZ, LOW); // Apaga el relé
  // Activa el relé durante 5 segundos
  digitalWrite(RELAY_SUELO, HIGH);
  delay(1000); // Espera 5 segundos (5000 ms)
  digitalWrite(RELAY_SUELO, LOW); // Apaga el relé

  pinMode(GAS_SENSOR_PIN, INPUT);

  //LCD
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Leyendo datos...");
  delay(1000);
// Lee Distancia
  unsigned int distance = sonar.ping_cm();
  // Lee el valor analógico luz
  int lightValue = analogRead(LDR_PIN);
  // Lee el valor analógico de humedad suelo
  int soilMoisture = analogRead(SOIL_MOISTURE_SENSOR_PIN);
  // Lee el valor analógico del gas
  int gasValue = analogRead(GAS_SENSOR_PIN);
  // Lee el valor analógico del sensor LM35
  int rawValue = analogRead(lm35Pin);
  // Convierte el valor leído a temperatura en grados Celsius
  float voltage = (rawValue * 3.3) / 4095;
  float temperatureC = (voltage) * 100;

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
  Serial.print("Humedad del suelo valor: ");
  Serial.println(soilMoisture);
  Serial.print("Humedad del suelo: ");
  Serial.print(map(soilMoisture, SOIL_DRY_VALUE, SOIL_WET_VALUE, 0, 100));
  Serial.println("%");
  Serial.print("Lectura del sensor de gas: ");
  Serial.println(gasValue);
  Serial.print("Temperatura del suelo: ");
  Serial.print(temperatureC);
  Serial.println(" °C");

  //LCD
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Datos...");
  lcd.setCursor(0,1);
  lcd.print("Datos...");

}