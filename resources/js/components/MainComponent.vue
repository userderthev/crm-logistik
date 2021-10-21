<template class="rounded">
  <div class="container bg-white rounded">

    <h3 class="text-center">Dashboard - ScordCard - Indicador KPI's</h3><br/>

    <div class="row">
      <div class="col-md-3">
        <div class="card-counter primary">
          <i class="fa fa-code-fork"></i>
          <span class="count-numbers">12</span>
          <span class="count-name">Flowz</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter danger">
          <i class="fa fa-ticket"></i>
          <span class="count-numbers">599</span>
          <span class="count-name">Instances</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter success">
          <i class="fa fa-database"></i>
          <span class="count-numbers">6875</span>
          <span class="count-name">Data</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter info">
          <i class="fa fa-users"></i>
          <span class="count-numbers">35</span>
          <span class="count-name">Users</span>
        </div>
      </div>
    </div>

    <div class="row my-2">
      <div class="card col-6 my-3">
          <div class="card-body">
            <canvas id="my-chart-"></canvas>
          </div>
      </div>
      <div class="card col-6 my-3">
          <div class="card-body">
            <canvas id="my-chart--"></canvas>
          </div>
      </div>
      <div class="card col my-3">
          <div class="card-body">
            <canvas id="my-chart" height="100"></canvas>
          </div>
      </div>
    </div>

  </div>
</template>

<script>
  import Chart from 'chart.js';

  export default {
    name: 'MainComponent',
    data() {
      return {
        charts: [],
      }
    },
    mounted() {
      console.log(this.$options.name)
      new Chart(document.getElementById('my-chart'), {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
          datasets: [
            {
              label: 'Ventas 2018',
              borderColor: 'rgba(50, 115, 220, 0.5)',
              backgroundColor: 'rgba(50, 115, 220, 0.1)',
              data: [300, 700, 450, 750, 450]
            },
            {
              label: 'Ventas 2019',
              borderColor: 'rgba(255, 56, 96, 0.5)',
              backgroundColor: 'rgba(255, 56, 96, 0.1)',
              data: [600, 550, 750, 250, 700]
            },
            {
              label: 'Ventas 2020',
              borderColor: 'rgba(82, 199, 80, 0.5)',
              backgroundColor: 'rgba(82, 199, 80, 0.1)',
              data: [100, 430, 550, 450, 800]
            }
          ]
        }
      });
      new Chart(document.getElementById('my-chart-'), {
      type: 'bar',
      data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
              label: 'Trafico',
              data: [12, 19, 3, 5, 8, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
        }
      });
      new Chart(document.getElementById('my-chart--'), {
        type: 'doughnut',
        data: {
            labels: [
                'Red',
                'Yellow',
                'Blue'
            ],
            datasets: [{
                data: [10, 20, 30],
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
            }],
        },
      });
    },
    methods: {
    },
    watch: {
    },
  }
</script>

<style scoped>
  .card-counter{
      box-shadow: 2px 2px 10px #DADADA;
      margin: 5px;
      padding: 20px 10px;
      background-color: #fff;
      height: 100px;
      border-radius: 5px;
      transition: .3s linear all;
  }
  .card-counter:hover{
    box-shadow: 4px 4px 20px #DADADA;
    transition: .3s linear all;
  }
  .card-counter.primary{
    background-color: #007bff;
    color: #FFF;
  }
  .card-counter.danger{
    background-color: #ef5350;
    color: #FFF;
  }
  .card-counter.success{
    background-color: #66bb6a;
    color: #FFF;
  }
  .card-counter.info{
    background-color: #26c6da;
    color: #FFF;
  }
  .card-counter i{
    font-size: 5em;
    opacity: 0.2;
  }
  .card-counter .count-numbers{
    position: absolute;
    right: 35px;
    top: 20px;
    font-size: 32px;
    display: block;
  }
  .card-counter .count-name{
    position: absolute;
    right: 35px;
    top: 65px;
    font-style: italic;
    text-transform: capitalize;
    opacity: 0.5;
    display: block;
    font-size: 18px;
  }
</style>
