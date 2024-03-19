<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajando en la página</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }

        #timer {
            font-size: 36px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Estamos trabajando en esta página</h1>
    <p>Volveremos pronto.</p>
    <div id="timer">Tiempo restante: </div>

    <script>
        // Define la fecha de finalización del temporizador (por ejemplo, 7 días desde la carga de la página)
        var endDate = new Date();
        endDate.setDate(endDate.getDate() + 7);

        // Función para actualizar el temporizador
        function updateTimer() {
            var now = new Date();
            var timeDiff = endDate - now;

            if (timeDiff <= 0) {
                clearInterval(timerInterval);
                document.getElementById('timer').innerHTML = "Tiempo expirado";
            } else {
                var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                document.getElementById('timer').innerHTML = "Tiempo restante: " + days + " días " + hours + " horas " +
                    minutes + " minutos " + seconds + " segundos ";
            }
        }

        // Actualizar el temporizador cada segundo
        var timerInterval = setInterval(updateTimer, 1000);
    </script>
</body>

</html>
