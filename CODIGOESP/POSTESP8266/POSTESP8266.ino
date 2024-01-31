#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

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
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    http.begin(client, serverURL);

    // Configura el encabezado HTTP
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Crea los datos a enviar en el cuerpo POST
    String data = "id_placa=12345678&tem=30.5&humendad=90&stem=25&shumendad=100&luz=100&co2=100&altura=5"; // Puedes agregar más datos según tus necesidades

    // Realiza la solicitud POST
    int httpResponseCode = http.POST(data);

    // Verifica la respuesta del servidor
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
  }

  delay(60000); // Espera 60 segundos antes de enviar otra solicitud POST
}