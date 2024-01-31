$(document).ready(function () {

  google.charts.load("current", { packages: ["gauge"] });
  google.charts.setOnLoadCallback(drawChart);

  //Mensaje de alerta al inactivar placa
  $(".inact").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de inactivar la placa?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  //Mensaje de alerta al activar placa
  $(".activar").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de activar la placa?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  //Mensaje de alerta al eliminar placa
  $(".elim").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de eliminar permanentemente la placa?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  //Mensaje de alerta al inactivar placa
  $(".inactpla").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de inactivar la plantilla?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  //Mensaje de alerta al activar placa
  $(".activarpla").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de activar la plantilla?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  //Mensaje de alerta al eliminar placa
  $(".elimpla").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de eliminar permanentemente la plantilla?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  //Mensaje de alerta al inactivar placa
  $(".inactcult").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de inactivar el cultivo?, no se podrá activar de nuevo.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });
});

  //Mensaje de alerta al eliminar noti
  $(".elimnoti").submit(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Está seguro de eliminar la notificación?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });


//EDITAR PLACA DESDE MODAL
document.querySelectorAll('[data-toggle="modal"]').forEach(function (element) {
  element.addEventListener("click", function () {
    var nombre = element.getAttribute("data-nombre");
    var identificador = element.getAttribute("data-identificador");
    var id = element.getAttribute("data-id");

    document.getElementById("nombree").value = nombre;
    document.getElementById("keye").value = identificador;
    document.getElementById("ide").value = id;
  });
});

//FUNCION PARA OBTENER ID
function obtenerParametroDeURL(nombreParametro) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(nombreParametro);
}

//OBTIENE LA BASE URL.
const base = document.getElementById("url").value;

//Gráfica de Temperatura
function LineasTemperatura(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/GraficaTemperatura",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var fecha = [];
      var aire = [];
      var suelo = [];
      var lastDay = null; // Variable para realizar un seguimiento de la última fecha procesada
      for (var i = 0; i < data.length; i++) {
        var dateTime = data[i]["fecha"];
        var currentDate = dateTime.split(" ")[0]; // Obtener solo la fecha

        // Comprobar si el día es diferente del último día procesado
        if (currentDate !== lastDay) {
          fecha.push(currentDate);
          lastDay = currentDate; // Actualizar el último día procesado
        } else {
          fecha.push(""); // Si es el mismo día, dejar el campo en blanco
        }

        aire.push(data[i]["tem"]);
        suelo.push(data[i]["stem"]);
      }
      console.log(fecha);
      // Bar Chart Example
      var ctx = document.getElementById("LineasTemperaturaChart");
      const Valor1 = {
        label: "Ambiente",
        data: aire,
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      const Valor2 = {
        label: "Suelo",
        data: suelo,
        borderDash: [3, 5],
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      var myLineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: fecha,
          datasets: [Valor1, Valor2],
        },
        options: {
          tooltips: {
            callbacks: {
              // Esta función se llama cuando se está generando el contenido del tooltip
              label: function (tooltipItem, data) {
                var datasetLabel =
                  data.datasets[tooltipItem.datasetIndex].label || "";
                var value = tooltipItem.yLabel; // El valor en el eje Y
                return datasetLabel + ": " + value + "°C"; // Agrega el texto deseado
              },
            },
          },
        },
      });
    },
  });
}

//Gráfica de Humedad
function LineasHumedad(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/GraficaTemperatura",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var fecha = [];
      var aire = [];
      var suelo = [];
      var lastDay = null; // Variable para realizar un seguimiento de la última fecha procesada
      for (var i = 0; i < data.length; i++) {
        var dateTime = data[i]["fecha"];
        var currentDate = dateTime.split(" ")[0]; // Obtener solo la fecha

        // Comprobar si el día es diferente del último día procesado
        if (currentDate !== lastDay) {
          fecha.push(currentDate);
          lastDay = currentDate; // Actualizar el último día procesado
        } else {
          fecha.push(""); // Si es el mismo día, dejar el campo en blanco
        }

        aire.push(data[i]["humendad"]);
        suelo.push(data[i]["shumendad"]);
      }
      // Bar Chart Example
      var ctx = document.getElementById("LineasHumedadChart");
      const Valor1 = {
        label: "Ambiente",
        data: aire,
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      const Valor2 = {
        label: "Suelo",
        data: suelo,
        borderDash: [3, 5],
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      var myLineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: fecha,
          datasets: [Valor1, Valor2],
        },
        options: {
          tooltips: {
            callbacks: {
              // Esta función se llama cuando se está generando el contenido del tooltip
              label: function (tooltipItem, data) {
                var datasetLabel =
                  data.datasets[tooltipItem.datasetIndex].label || "";
                var value = tooltipItem.yLabel; // El valor en el eje Y
                return datasetLabel + ": " + value + "%"; // Agrega el texto deseado
              },
            },
          },
        },
      });
    },
  });
}

//Gráfica de Luz PENDIENTE***************************
function LineasLuz(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/GraficaTemperatura",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var fecha = [];
      var aire = [];
      var lastDay = null; // Variable para realizar un seguimiento de la última fecha procesada
      for (var i = 0; i < data.length; i++) {
        var dateTime = data[i]["fecha"];
        var currentDate = dateTime.split(" ")[0]; // Obtener solo la fecha

        // Comprobar si el día es diferente del último día procesado
        if (currentDate !== lastDay) {
          fecha.push(currentDate);
          lastDay = currentDate; // Actualizar el último día procesado
        } else {
          fecha.push(""); // Si es el mismo día, dejar el campo en blanco
        }

        aire.push(data[i]["lum"]);
      }
      // Bar Chart Example
      var ctx = document.getElementById("LineasLuzChart");
      const Valor1 = {
        label: "Luz",
        data: aire,
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      var myLineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: fecha,
          datasets: [Valor1],
        },
        options: {
          tooltips: {
            callbacks: {
              // Esta función se llama cuando se está generando el contenido del tooltip
              label: function (tooltipItem, data) {
                var datasetLabel =
                  data.datasets[tooltipItem.datasetIndex].label || "";
                var value = tooltipItem.yLabel; // El valor en el eje Y
                return datasetLabel + ": " + value + " lum"; // Agrega el texto deseado
              },
            },
          },
        },
      });
    },
  });
}

//Gráfica de CO2
function LineasCO2(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/GraficaTemperatura",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var fecha = [];
      var aire = [];
      var lastDay = null; // Variable para realizar un seguimiento de la última fecha procesada
      for (var i = 0; i < data.length; i++) {
        var dateTime = data[i]["fecha"];
        var currentDate = dateTime.split(" ")[0]; // Obtener solo la fecha

        // Comprobar si el día es diferente del último día procesado
        if (currentDate !== lastDay) {
          fecha.push(currentDate);
          lastDay = currentDate; // Actualizar el último día procesado
        } else {
          fecha.push(""); // Si es el mismo día, dejar el campo en blanco
        }

        aire.push(data[i]["co2"]);
      }
      // Bar Chart Example
      var ctx = document.getElementById("LineasCO2Chart");
      const Valor1 = {
        label: "CO2",
        data: aire,
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      var myLineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: fecha,
          datasets: [Valor1],
        },
        options: {
          tooltips: {
            callbacks: {
              // Esta función se llama cuando se está generando el contenido del tooltip
              label: function (tooltipItem, data) {
                var datasetLabel =
                  data.datasets[tooltipItem.datasetIndex].label || "";
                var value = tooltipItem.yLabel; // El valor en el eje Y
                return datasetLabel + ": " + value + " ppm"; // Agrega el texto deseado
              },
            },
          },
        },
      });
    },
  });
}


//Gráfica de Temperatura
function LineasAltura(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/GraficaTemperatura",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var fecha = [];
      var aire = [];
      var lastDay = null; // Variable para realizar un seguimiento de la última fecha procesada
      for (var i = 0; i < data.length; i++) {
        var dateTime = data[i]["fecha"];
        var currentDate = dateTime.split(" ")[0]; // Obtener solo la fecha

        // Comprobar si el día es diferente del último día procesado
        if (currentDate !== lastDay) {
          fecha.push(currentDate);
          lastDay = currentDate; // Actualizar el último día procesado
        } else {
          fecha.push(""); // Si es el mismo día, dejar el campo en blanco
        }

        aire.push(data[i]["altura"]);
      }
      // Bar Chart Example
      var ctx = document.getElementById("LineasAlturaChart");
      const Valor1 = {
        label: "Altura",
        data: aire,
        backgroundColor: "rgba(0, 168, 198, 0.0)", // Color de fondo
        borderColor: "rgba(255, 0, 0, 1)", // Color del borde
        borderWidth: 1, // Ancho del borde
        pointRadius: 0, // Configurar el radio de los puntos a cero para hacerlos prácticamente invisibles
      };

      var myLineChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: fecha,
          datasets: [Valor1],
        },
        options: {
          tooltips: {
            callbacks: {
              // Esta función se llama cuando se está generando el contenido del tooltip
              label: function (tooltipItem, data) {
                var datasetLabel =
                  data.datasets[tooltipItem.datasetIndex].label || "";
                var value = tooltipItem.yLabel; // El valor en el eje Y
                return datasetLabel + ": " + value + " CM"; // Agrega el texto deseado
              },
            },
          },
        },
      });
    },
  });
}

//VELOCIMETRO TEMPERATURA
 function TemperaturaAire(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/UltimaMedicion",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var data1 = data.data1; // Acceder a la variable data1 del JSON
      var data2 = data.data2; // Acceder a la variable data2 del JSON
      var variable1 = 0;
      var max = 0;
      var min = 0;

      variable1 = parseInt(data1["tem"]);
      max = parseInt(data2["tem_max"]);
      min = parseInt(data2["tem_min"]);

      var data = google.visualization.arrayToDataTable([
        ["Label", "Value"],
        ["°C", variable1], //AQUI VA EL VALOR ACTUAL
      ]);
      var options = {
        max: 40,
        redFrom: max, //AQUI ES DESDE EL VALOR MAXIMO
        redTo: 40,
        yellowFrom: 0,
        yellowTo: min, //AQUI ES DESDE EL VALOR MINIMO
        minorTicks: 10,
      };
      var chart = new google.visualization.Gauge(
        document.getElementById("TemperaturaAireChart")
      );
      chart.draw(data, options);
    },
  });
};

//VELOCIMETRO HUMEDAD
function HumedadAire(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/UltimaMedicion",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var data1 = data.data1; // Acceder a la variable data1 del JSON
      var data2 = data.data2; // Acceder a la variable data2 del JSON
      var variable1 = 0;
      var max = 0;
      var min = 0;

      variable1 = parseInt(data1["humendad"]);
      max = parseInt(data2["humedad_max"]);
      min = parseInt(data2["humedad_min"]);

      var data = google.visualization.arrayToDataTable([
        ["Label", "Value"],
        ["%", variable1], //AQUI VA EL VALOR ACTUAL
      ]);
      var options = {
        redFrom: max, //AQUI ES DESDE EL VALOR MAXIMO
        redTo: 100,
        yellowFrom: 0,
        yellowTo: min, //AQUI ES DESDE EL VALOR MINIMO
        minorTicks: 5,
      };
      var chart = new google.visualization.Gauge(
        document.getElementById("HumedadAireChart")
      );
      chart.draw(data, options);
    },
  });
};

//VELOCIMETRO TEMPERATURA SUELO
function TemperaturaSuelo(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/UltimaMedicion",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var data1 = data.data1; // Acceder a la variable data1 del JSON
      var data2 = data.data2; // Acceder a la variable data2 del JSON
      var variable1 = 0;
      var max = 0;
      var min = 0;

      variable1 = parseInt(data1["stem"]);
      max = parseInt(data2["stem_max"]);
      min = parseInt(data2["stem_min"]);

      console.log(variable1);
      console.log(max);
      console.log(min);
      var data = google.visualization.arrayToDataTable([
        ["Label", "Value"],
        ["°C", variable1], //AQUI VA EL VALOR ACTUAL
      ]);
      var options = {
        max: 40,
        redFrom: max, //AQUI ES DESDE EL VALOR MAXIMO
        redTo: 40,
        yellowFrom: 0,
        yellowTo: min, //AQUI ES DESDE EL VALOR MINIMO
        minorTicks: 10,
      };
      var chart = new google.visualization.Gauge(
        document.getElementById("TemperaturaSueloChart")
      );
      chart.draw(data, options);
    },
  });
};

//VELOCIMETRO HUMEDAD SUELO
function HumedadSuelo(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/UltimaMedicion",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var data1 = data.data1; // Acceder a la variable data1 del JSON
      var data2 = data.data2; // Acceder a la variable data2 del JSON
      var variable1 = 0;
      var max = 0;
      var min = 0;

      variable1 = parseInt(data1["shumendad"]);
      max = parseInt(data2["shumedad_max"]);
      min = parseInt(data2["shumedad_min"]);

      var data = google.visualization.arrayToDataTable([
        ["Label", "Value"],
        ["%", variable1], //AQUI VA EL VALOR ACTUAL
      ]);
      var options = {
        redFrom: max, //AQUI ES DESDE EL VALOR MAXIMO
        redTo: 100,
        yellowFrom: 0,
        yellowTo: min, //AQUI ES DESDE EL VALOR MINIMO
        minorTicks: 5,
      };
      var chart = new google.visualization.Gauge(
        document.getElementById("HumedadSueloChart")
      );
      chart.draw(data, options);
    },
  });
};

//VELOCIMETRO CO2
function CO2(elementId) {
  var requestData = {
    id: elementId,
  };
  $.ajax({
    url: base + "Cultivos/UltimaMedicion",
    type: "POST",
    data: requestData, // Envía los datos como parte de la solicitud
    success: function (response) {
      var data = JSON.parse(response);
      var data1 = data.data1; // Acceder a la variable data1 del JSON
      var data2 = data.data2; // Acceder a la variable data2 del JSON
      var variable1 = 0;
      var max = 0;
      var min = 0;

      variable1 = parseInt(data1["co2"]);
      max = parseInt(data2["co2_max"]);
      min = max - max * 0.1;

      var data = google.visualization.arrayToDataTable([
        ["Label", "Value"],
        ["ppm", variable1], //AQUI VA EL VALOR ACTUAL
      ]);
      var options = {
        max: 1000, //INVESTIGAR RANGOS
        redFrom: max, //AQUI ES DESDE EL VALOR MAXIMO
        redTo: 1000,
        yellowFrom: min,
        yellowTo: max, //AQUI ES DESDE EL VALOR MINIMO
        minorTicks: 5,
      };
      var chart = new google.visualization.Gauge(
        document.getElementById("CO2Chart")
      );
      chart.draw(data, options);
    },
  });
};


//-----------------
function PastelMateriales6() {
  $.ajax({
    url: base + "Reportes/PastelMateriales6",
    type: "POST",
    success: function (response) {
      var data = JSON.parse(response);
      var nombre = [];
      var total = [];
      for (var i = 0; i < data.length; i++) {
        nombre.push(data[i]["nombre"]);
        total.push(data[i]["total"]);
      }
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily =
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = "#292b2c";

      // Pie Chart Example
      var ctx = document.getElementById("Materiales6");
      var myPieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: nombre,
          datasets: [
            {
              data: total,
              backgroundColor: [
                "#C2258E",
                "Blue",
                "Salmon",
                "Wheat",
                "Peru",
                "CadetBlue",
                "Navy",
                "SandyBrown",
                "LimeGreen",
                "SpringGreen",
              ],
            },
          ],
        },
      });
    },
  });
}