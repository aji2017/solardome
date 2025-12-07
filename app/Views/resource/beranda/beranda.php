<div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="page-header d-flex justify-content-between align-items-center">
                                    <h2 class="pageheader-title">Beranda</h2>
                                    <span class="badge badge-<?= esc($kontaktor_warna) ?>">
                                        Status ESP Kontaktor: <?= esc($kontaktor_status) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Suhu dan Kelembapan</h5>
                                    <div class="card-body">
                                        <canvas id="chartjs_line"></canvas>
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Tengangan</h5>
                                <div class="card-body">
                                    <canvas id="gauge1"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Arus</h5>
                                <div class="card-body">
                                    <canvas id="gauge2"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Daya</h5>
                                <div class="card-body">
                                    <canvas id="gauge3"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Sensor Bau</h5>
                                <div class="card-body">
                                    <canvas id="gauge4" width="200" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
<script src="../assets/vendor/charts/charts-bundle/chartjs.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const sensorData = <?= json_encode($sensor_data); ?>;

    if (!sensorData.error) {
        const labels = sensorData.map(d => d.waktu);
        const suhu = sensorData.map(d => parseFloat(d.suhu));
        const kelembapan = sensorData.map(d => parseFloat(d.kelembapan));
        const tegangan = sensorData.map(d => parseFloat(d.tegangan));
        const arus = sensorData.map(d => parseFloat(d.arus));
        const power = sensorData.map(d => parseFloat(d.power));
        const bau = sensorData.map(d => parseFloat(d.co2)); 

        // Line chart: suhu & kelembapan
        new Chart(document.getElementById("chartjs_line"), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Suhu (°C)",
                        data: suhu,
                        borderColor: "rgba(255,99,132,1)",
                        fill: false
                    },
                    {
                        label: "Kelembapan (%)",
                        data: kelembapan,
                        borderColor: "rgba(54, 162, 235, 1)",
                        fill: false
                    }
                ]
            }
        });

        // Gauge chart simulasi untuk tegangan, arus, daya, bau
        const drawGauge = (id, value, label, max = 100) => {
            new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: {
                    labels: [label, ""],
                    datasets: [{
                        data: [value, max - value],
                        backgroundColor: ['#28a745', '#e9ecef'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    plugins: {
                        tooltip: { enabled: false },
                        legend: { display: false },
                        title: {
                            display: true,
                            text: label + ": " + value,
                            font: { size: 14 }
                        }
                    }
                }
            });
        };

        drawGauge("gauge1", parseFloat(tegangan), "Tegangan");
        drawGauge("gauge2", parseFloat(arus), "Arus");
        drawGauge("gauge3", parseFloat(power), "Daya");
        drawGauge("gauge4", parseFloat(bau), "Bau (CO2)");
    } else {
        console.error(sensorData.error);
    }
    setInterval(drawGauge, 5000);
    setInterval(Chart, 5000);
</script>