  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-10">
              <div class="page-header-title">
                <h5 class="m-b-10">Beranda</h5>
              </div>
            </div>
            <div class="col-md-2">
              <div class="page-header-title">
              <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                  data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                  aria-selected="false">Status ESP Kontaktor: <?= esc($kontaktor_status) ?></button>
              </li>
            </ul>
             </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->


        <div class="col-md-12 col-xl-12">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Suhu dan Kelembapan</h5>
          </div>
          <div class="card">
            <div class="card-body">
                  <div id="utama"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-12">
          <h5 class="mb-3">Tegangan, Daya, Arus, dan CO2</h5>
          <div class="card">
            <div class="card-body">
              <div id="kedua"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

    // Area chart untuk Suhu dan Kelembapan menggunakan ApexCharts (lebih hidup dengan animasi, interaktivitas, dan efek visual)
    var optionsArea = {
      series: [{
        name: 'Suhu (°C)',
        data: suhu
      }, {
        name: 'Kelembapan (%)',
        data: kelembapan
      }],
      chart: {
        type: 'area',
        height: 450,
        toolbar: {
          show: true,
          tools: {
            download: true,
            selection: true,
            zoom: true,
            zoomin: true,
            zoomout: true,
            pan: true,
            reset: true
          }
        },
        zoom: {
          enabled: true,
          type: 'x',
          autoScaleYaxis: true
        },
        animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 800,
          animateGradually: {
            enabled: true,
            delay: 100
          },
          dynamicAnimation: {
            enabled: true,
            speed: 300
          }
        },
        selection: {
          enabled: true,
          type: 'x',
          fill: {
            color: '#24292e',
            opacity: 0.1
          },
          stroke: {
            width: 1,
            dashArray: 3,
            color: '#24292e',
            opacity: 0.4
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 5,
        colors: ['#FF4560', '#00E396'],
        dashArray: [0, 0],
        shadow: {
          enabled: true,
          color: '#000',
          top: 20,
          left: 10,
          blur: 15,
          opacity: 0.3
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'light',
          type: 'vertical',
          shadeIntensity: 0.4,
          gradientToColors: ['#FF4560', '#00E396'],
          inverseColors: false,
          opacityFrom: 0.8,
          opacityTo: 0.2,
          stops: [0, 50, 100]
        },
        pattern: {
          style: ['verticalLines', 'horizontalLines'],
          width: 8,
          height: 8,
          strokeWidth: 1
        }
      },
      markers: {
        size: 8,
        colors: ['#FF4560', '#00E396'],
        strokeColors: '#fff',
        strokeWidth: 4,
        hover: {
          size: 12,
          sizeOffset: 3
        },
        shape: 'circle',
        radius: 2
      },
      xaxis: {
        categories: labels,
        title: {
          text: 'Waktu',
          style: {
            color: '#333',
            fontSize: '14px'
          }
        },
        labels: {
          style: {
            colors: '#666',
            fontSize: '12px'
          },
          rotate: -45
        },
        axisBorder: {
          show: true,
          color: '#333'
        },
        axisTicks: {
          show: true,
          color: '#333'
        }
      },
      yaxis: {
        title: {
          text: 'Nilai',
          style: {
            color: '#333',
            fontSize: '14px'
          }
        },
        labels: {
          style: {
            colors: '#666',
            fontSize: '12px'
          }
        },
        axisBorder: {
          show: true,
          color: '#333'
        },
        axisTicks: {
          show: true,
          color: '#333'
        }
      },
      grid: {
        borderColor: '#e7e7e7',
        row: {
          colors: ['#f8f9fa', 'transparent'],
          opacity: 0.5
        },
        column: {
          colors: ['#f8f9fa', 'transparent'],
          opacity: 0.5
        },
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: true
          }
        }
      },
      colors: ['#FF4560', '#00E396'],
      tooltip: {
        shared: true,
        intersect: false,
        theme: 'light',
        x: {
          format: 'dd MMM yyyy'
        },
        y: {
          formatter: function(val, opts) {
            if (opts.seriesIndex === 0) return val + " °C";
            if (opts.seriesIndex === 1) return val + " %";
            return val;
          }
        }
      },
      legend: {
        position: 'top',
        horizontalAlign: 'center',
        floating: false,
        offsetY: 0,
        offsetX: 0
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            height: 300
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };
    var chartArea = new ApexCharts(document.querySelector("#utama"), optionsArea);
    chartArea.render();

    // Bar chart untuk Tegangan, Arus, Daya, dan Sensor Bau menggunakan ApexCharts (4 batang terpisah per label tanggal)
    var optionsBar = {
      series: [{
        name: 'Tegangan',
        data: tegangan
      }, {
        name: 'Arus',
        data: arus
      }, {
        name: 'Daya',
        data: power
      }, {
        name: 'Bau (CO2)',
        data: bau
      }],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: {
          show: true
        }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: labels,
        title: {
          text: 'Tanggal'
        }
      },
      yaxis: {
        title: {
          text: 'Nilai'
        }
      },
      colors: ['#FF4560', '#00E396', '#FEB019', '#775DD0'],
      tooltip: {
        shared: true,
        intersect: false
      }
    };
    var chartBar = new ApexCharts(document.querySelector("#kedua"), optionsBar);
    chartBar.render();
  } else {
    console.error(sensorData.error);
  }
</script>

