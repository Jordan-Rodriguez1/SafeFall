#include <WiFi.h>
#include <HTTPClient.h>

// Puente acceso Wifi
const char* WIFI_SSID = "MEGACABLE_2.4G_EBC8";
const char* WIFI_PASSWORD = "J6T7e2M8J4T5D4Z7a2a2";
const char* serverURL = "http://192.168.1.5/CulTech/Esp/RegistroDatos";
const char* id_placa = "12345678";


void setup() {
  Serial.begin(115200);
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a la red WiFi...");
  }
  Serial.println("Conexión WiFi establecida.");
}

void loop() {
  while (WiFi.status() == WL_CONNECTED) {

    float pulso = 80;
    float estado = 1;

    //CONFIGURAMOS PARA HACER POST
    WiFiClient client;
    HTTPClient http;
    http.begin(client, IngresarDatos);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    //GUARDAMOS LOS DATOS EN UNA VARIABLE
    String data = "id_placa=" + String(id_placa)+"&pulso=" + String(pulso)+"&estado=" + String(estado);

    //HACEMOS EL POST
    int httpResponseCode = http.POST(data);

    if (httpResponseCode > 0) {
      Serial.print("Respuesta del servidor: ");
      Serial.println(httpResponseCode);

      String response = http.getString();
      Serial.println(response);

    } else {
      Serial.print("Error en la solicitud. Código de respuesta: ");
      Serial.println(httpResponseCode);
    }

    http.end();

    delay(30000); // Espera 30 segundos antes de enviar la siguiente solicitud POST
  }
}
