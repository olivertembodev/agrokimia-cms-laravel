$.ajax({
  url: "/dashboardG",
  dataType: 'json',
  type: 'GET',  
  success: function(result){
      var jumlahprofit = [];
      var namaKios = [];
      $.each(result, function(i, val){
        jumlahprofit.push(val.jumlahprofit);
        namaKios.push(val.namaKios);
      })
        grafikkios(namaKios, jumlahprofit);

    }
});

function grafikkios(date, total){
  var ctx = document.getElementById("kios_profit").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: date,
      datasets: [{
        label: 'Jumlah Profit',
        data: total,
        responsive: true,
        borderWidth: 4,
        backgroundColor:[  
          "rgba(0, 0, 255, 0.2)",
          "#01c0c88a",
          "rgba(255, 205, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(201, 203, 207, 0.2)",
          "rgba(100, 100, 100, 0.2)",
          "rgba(22, 25, 86, 0.2)",
          "rgba(75, 12, 192, 0.2)",
          "rgba(54, 262, 235, 0.2)",
          "rgba(77, 12, 155, 0.2)",
          "rgba(201, 23, 107, 0.2)",
          "rgba(100, 200, 200, 0.2)",
          "rgba(255, 205, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(201, 203, 207, 0.2)",
          "rgba(100, 100, 100, 0.2)",
      ],
          borderColor:[  
              "rgb(0, 0, 225)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
              "rgb(0, 0, 225)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
          ],
        borderWidth: 1,
        pointBorderWidth: 0,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        fill: false,
        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            // display: false,
            drawBorder: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: true,
            callback: function(value, index, values) {
              return value;
            }
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
            tickMarkLength: 15,
          }
        }]
      },
    }
  });
}

$.ajax({
  url: "/dashboardG2",
  dataType: 'json',
  type: 'GET',  
  success: function(result){
      var jumlahpembelian = [];
      var kios_name = [];
      $.each(result, function(i, val){
        jumlahpembelian.push(val.jumlahpembelian);
        kios_name.push(val.kios_name);
      })
        grafikkios2(kios_name, jumlahpembelian);

    }
});

function grafikkios2(date, total){
  var ctx = document.getElementById("pembelian_kios").getContext('2d');
  var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
  gradientFill.addColorStop(0, "rgba(108, 182, 244, 0.6)");
  gradientFill.addColorStop(1, "rgba(244, 144, 128, 0.6)");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: date,
      datasets: [{
        label: 'Jumlah Profit',
        data: total,
        responsive: true,
        borderWidth: 4,
        backgroundColor:[  
          gradientFill,
          "rgba(0, 0, 255, 0.2)",
          "#01c0c88a",
          "rgba(255, 205, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(201, 203, 207, 0.2)",
          "rgba(100, 100, 100, 0.2)",
          "rgba(22, 25, 86, 0.2)",
          "rgba(75, 12, 192, 0.2)",
          "rgba(54, 262, 235, 0.2)",
          "rgba(77, 12, 155, 0.2)",
          "rgba(201, 23, 107, 0.2)",
          "rgba(100, 200, 200, 0.2)",
          "rgba(255, 205, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(201, 203, 207, 0.2)",
          "rgba(100, 100, 100, 0.2)",
      ],
          borderColor:[  
              "rgb(0, 0, 225)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
              "rgb(0, 0, 225)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
          ],
        borderWidth: 1,
        pointBorderWidth: 0,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        fill: false,
        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            // display: false,
            drawBorder: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: true,
            callback: function(value, index, values) {
              return value;
            }
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
            tickMarkLength: 15,
          }
        }]
      },
    }
  });
}