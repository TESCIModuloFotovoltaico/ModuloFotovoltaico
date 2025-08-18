<?php
$conexion = new mysqli("localhost", "usuario", "contraseña", "nombre_base_datos");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$sql = "SELECT fecha, voltaje FROM voltaje_panel ORDER BY fecha ASC";
$resultado = $conexion->query($sql);

$datos = [];

while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Historial de Voltaje</h2>
    <canvas id="voltajeChart" height="100"></canvas>
</div>

<script>
fetch('voltaje.php')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(row => row.fecha);
        const valores = data.map(row => row.voltaje);

        const ctx = document.getElementById('voltajeChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Voltaje (V)',
                    data: valores,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Voltaje (V)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha y Hora'
                        }
                    }
                }
            }
        });
    })
    .catch(error => console.error("Error al cargar los datos de voltaje:", error));
</script>
