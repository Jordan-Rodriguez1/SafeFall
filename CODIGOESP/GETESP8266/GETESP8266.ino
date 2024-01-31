#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>

const char* ssid = "MEGACABLE_2.4G_EBC8";
const char* password = "J6T7e2M8J4T5D4Z7a2a2";
const String url = "http://192.168.1.5/CulTech/Esp/ObtenerConfiguracion";
const char* id_placa = "12345678";

void setup() {
  Serial.begin(115200);
  delay(10);
  
  // Conéctate a la red WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a WiFi...");
  }
  Serial.println("Conexión WiFi establecida");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    http.begin(client, url);

    int httpCode = http.GET();
    if (httpCode > 0) {
      String payload = http.getString();
      // La variable 'payload' contendrá el JSON como una cadena.

      // Ahora puedes utilizar ArduinoJSON para analizar el JSON.
      // Aquí hay un ejemplo sencillo para extraer los valores de 'number1' y 'number2':
      DynamicJsonDocument doc(1024);
      DeserializationError error = deserializeJson(doc, payload);
      if (error) {
        Serial.print("Error al analizar el JSON: ");
        Serial.println(error.c_str());
      } else {
        int number1 = doc["number1"];
        int number2 = doc["number2"];
        Serial.print("number1: ");
        Serial.println(number1);
        Serial.print("number2: ");
        Serial.println(number2);
      }
    } else {
      Serial.print("Error en la solicitud HTTP: ");
      Serial.println(http.errorToString(httpCode).c_str());
    }

    http.end();
  }

  delay(5000); // Espera 5 segundos antes de hacer otra solicitud.
}
