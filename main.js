document.addEventListener("DOMContentLoaded", function () {
    fetch("datos.php")
        .then(response => response.json())
        .then(data => {
            const labels = data.map(row => row.hora);
            const valores = data.map(row => row.valor);

            const ctx = document.getElementById('solarChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Energía Generada (W)',
                        data: valores,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
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
                                text: 'Energía (Watts)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Hora del Día'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error("Error al cargar los datos:", error));

    // --- Agrega aquí la función para actualizar el voltaje ---
    function actualizarVoltaje() {
        fetch('datos.json')
            .then(res => res.json())
            .then(data => {
                const voltaje = parseFloat(data.voltaje).toFixed(2);
                const porcentaje = Math.min((voltaje / 5) * 100, 100);
                document.getElementById("voltaje").textContent = voltaje;
                const barra = document.getElementById("barraVoltaje");
                barra.style.width = porcentaje + "%";
                barra.textContent = porcentaje.toFixed(0) + "%";
            })
            .catch(err => console.error("Error al cargar voltaje:", err));
    }

    setInterval(actualizarVoltaje, 10000);
    actualizarVoltaje();
});
