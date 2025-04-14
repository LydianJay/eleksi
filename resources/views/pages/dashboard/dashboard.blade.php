<x-basedashboard active_link="{{$active_link}}" >
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Energy </p>
                                <h5 class="font-weight-bolder" id="max_energy">
                                    {{ number_format(isset($max_energy) ? $max_energy : 0, 2) }} KWH
                                </h5>
                                
                                <p class="mb-0">
                                    <span class="text-sm font-weight-bolder {{ $dif <= 100 ? 'text-success' : 'text-danger' }} ">{{ $dif <= 100 ? '-' : '+' }}{{  number_format($dif, 2) }}%</span>
                                    since yesterday
                                </p>
                               
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
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Power</p>
                                <h5 class="font-weight-bolder">
                                    {{ number_format(isset($data[count($data) - 1]->power) ? $data[count($data) - 1]->power : 0, 2) }} W
                                </h5>
                               
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
        </div>
       
    </div>
    <div class="row px-3 mt-3 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Energy Data</h6>
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
          <h6>Power Data</h6>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line-3" class="chart-canvas" height="400"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row px-3 mt-3 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Voltage Data</h6>
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line-4" class="chart-canvas" height="400"></canvas>
          </div>
        </div>
      </div>
    </div>
    <script>

      let canvasArry = [];
      
      @php
$v = [];
$current = [];
$labels = [];
$energy = [];
      @endphp

      @foreach($data as $d)
        @php
  $id[] = $d->id;
  $v[] = $d->voltage;
  $current[] = $d->current;
  $energy[] = $d->energy;
  $power[] = $d->power;
  $labels[] = \Carbon\Carbon::parse($d->date)->format('H:i:s');
        @endphp
      @endforeach            
        let labels    = @json($labels);
        let v         = @json($v);
        let current   = @json($current);
        let energy    = @json($energy);
        let power     = @json($power);  
        let maxID     = {{ $max_id }};
        let maxEnergy = {{ $max_energy }}
        console.log(labels);

      function formatTimestamp(timestamp) {
          const date = new Date(timestamp); // Create a Date object

          const hours = String(date.getHours()).padStart(2, '0');
          const minutes = String(date.getMinutes()).padStart(2, '0');
          const seconds = String(date.getSeconds()).padStart(2, '0');

          return `${hours}:${minutes}:${seconds}`;
      }



      function renderCharts() {
        
        let titles    = ['Energy', 'Current', 'Power', 'Voltage'];
        let elemsID   = ['chart-line', 'chart-line-2', 'chart-line-3', 'chart-line-4'];
        let dataAry   = [energy, current, power, v];
        console.log(dataAry);

        for(let i = 0; i < dataAry.length; i++) {
          let ctx1 = document.getElementById(elemsID[i]).getContext("2d");
          var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
          
          let stepSize = 10;
          let max = {{ $max_energy }} * 5;
          switch(i) {
            case 0:
              stepSize = 2;
            break;
            case 1:
              stepSize = 0.2;
              max = current[current.length - 1] * 10;
            break;
            case 2:
              stepSize = 20;
              max = 2000;
            break;
            case 3:
              stepSize = 10;
              max = 500;
            break;
          }


          canvasArry.push(

            new Chart(ctx1,
              {
                type: "line",
                data: {
                  labels: labels,
                  datasets: [{
                    label: titles[i],
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: dataAry[i],
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
                        stepSize: stepSize,
                        min: 0,
                        max: max,
                        beginAtZero: true,
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
              }
            )
          );
        }


        
        
        
      }


      

      document.addEventListener('DOMContentLoaded', async () => {
        renderCharts();
        setInterval(async() => {

          try {
            let response = await fetch('{{ route('get_today') }}', {
              method: 'GET',
                headers: { 'Content-Type': 'application/json' },
              });
            // Parse the response as JSON
            let data = await response.json();

      
              if(data.id > maxID) {
                maxID = data.id;

                if(data.energy > maxEnergy) {
                  maxEnergy = data.energy;
                  document.getElementById('max_energy').innerText = maxEnergy;
                }

                labels.push(formatTimestamp(data.date));
                v.push(data.voltage);
                current.push(data.current);
                energy.push(data.energy);
                power.push(data.power);

                for(let i = 0; i < canvasArry.length; i++) {
                  canvasArry[i].destroy();
                }

                canvasArry = [];
                renderCharts();

                console.log('Need update');

              }
               

              } catch (error) {
            console.error('Error fetching data:', error);
          }

        }, 5000);
        
      });

        

        
        
        
        

        
      
    </script>
</x-basedashboard>