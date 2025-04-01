<x-basedashboard active_link="{{$active_link}}" >
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold"> Power </p>
                <h5 class="font-weight-bolder">
                  {{ number_format(isset($data[0]->power) ? $data[0]->power : 0, 2) }}
                </h5>
                {{-- <p class="mb-0">
                  <span class="text-success text-sm font-weight-bolder">+55%</span>
                  since yesterday
                </p> --}}
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Users</p>
                <h5 class="font-weight-bolder">
                  2,300
                </h5>
                <p class="mb-0">
                  <span class="text-success text-sm font-weight-bolder">+3%</span>
                  since last week
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
      
      
  </div>
  <div class="row px-3 mt-3 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Voltage Data</h6>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line" class="chart-canvas" height="400"></canvas>
        </div>
      </div>      
    </div>
  </div>

  <div class="row px-3 mt-3 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Current Data</h6>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line-2" class="chart-canvas" height="400"></canvas>
        </div>
      </div>
    </div>
  </div>


  <div class="row px-3 mt-3 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6>Energy Data</h6>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line-3" class="chart-canvas" height="400"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    let ctx1 = document.getElementById("chart-line").getContext("2d");
    let ctx2 = document.getElementById("chart-line-2").getContext("2d");
    let ctx3 = document.getElementById("chart-line-3").getContext("2d");
    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

  

    @php
$v = [];
$current = [];
$labels = [];
$energy = [];
    @endphp

    @foreach($data as $d)
      @php
  $v[] = $d->voltage;
  $current[] = $d->current;
  $energy[] = $d->energy;
  $labels[] = \Carbon\Carbon::parse($d->time)->format('H:i:s');
      @endphp
    @endforeach

    let labels  = @json($labels);
    let v       = @json($v);
    let current = @json($current);
    let energy  = @json($energy);


    new Chart(ctx1, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "Voltage",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: v,
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });



    new Chart(ctx2, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "Current",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: current,
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
          },
  });



  new Chart(ctx3, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          label: "Energy",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: energy,
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
          },
  });
  </script>
  
</x-basedashboard>