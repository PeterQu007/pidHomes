import $ from "jquery";
import Chart from "chart.js";

class pidChart {
  constructor() {
    this.ctx = $("#lineChart");
    this.neighborhoodCodes = $("#marketSection").attr("nbhCodes");
    //console.log($("#marketSection").attr("nbhNames"));
    this.neighborhoodNames = JSON.parse($("#marketSection").attr("nbhNames"));
    console.log(this.neighborhoodNames);
    this.chartColors = {
      red: "rgb(255, 99, 132)",
      orange: "rgb(255, 159, 64)",
      yellow: "rgb(255, 205, 86)",
      green: "rgb(75, 192, 192)",
      blue: "rgb(54, 162, 235)",
      purple: "rgb(153, 102, 255)",
      grey: "rgb(231,233,237)"
    };
    this.PropertyTypeSelect = $("#Property_Type");
    this.chartDataSets_All = [];
    this.chartDataSets_Detached = [];
    this.chartDataSets_Townhouse = [];
    this.chartDataSets_Apartment = [];
    this.pidChart = {};
    this.chartConfig = {};
    this.configChart([
      { label: "", data: {} },
      { label: "", data: {} },
      { label: "", data: {} }
    ]);
    this.getChartData();
    // this.init(this.chartDataSets_All);
    this.events();
  }

  // init(dataSets) {
  //   // var nbhSection = $("#marketSection");
  //   // var nbhCode = nbhSection.attr("nbhCode");

  //   console.log(nbhCode);
  //   this.drawChart(this.chartConfig);
  // }

  events() {
    this.PropertyTypeSelect.on("change", this.updateChart.bind(this));
  }

  configChart(dataSets) {
    let config = {
      type: "line",
      data: {
        //labels: data[0],
        // datasets: dataSets
        datasets: [
          {
            label: dataSets[0].label,
            fill: false,
            backgroundColor: this.chartColors.red, //"rgba(75, 192, 192, 0.4)",
            borderColor: this.chartColors.red, //"rgba(75, 192, 192, 1)",
            data: dataSets[0].data
          },
          {
            label: dataSets[1].label,
            fill: false,
            backgroundColor: this.chartColors.blue, //"rgba(75, 75, 192, 0.4)",
            borderColor: this.chartColors.blue, //"rgba(75, 75, 192, 1)",
            data: dataSets[1].data
          },
          {
            label: dataSets[2].label,
            fill: false,
            backgroundColor: this.chartColors.orange, //"rgba(75, 125, 192, 0.4)",
            borderColor: this.chartColors.orange, //"rgba(75, 125, 192, 1)",
            data: dataSets[2].data
          }
        ]
      },
      options: {
        title: {
          display: false,
          text: ""
        },
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
          mode: "index",
          intersect: false
        },
        plugins: {
          crosshair: {
            sync: {
              enabled: false
            },
            pan: {
              incrementer: 3 // Defaults to 5 if not included.
            },
            callbacks: {
              afterZoom: function(start, end) {
                setTimeout(function() {
                  chart6.data.datasets[0].data = generate(start, end);
                  chart6.update();
                }, 1000);
              }
            }
          }
        },
        hover: {
          mode: "nearest",
          intersect: true
        },
        scales: {
          xAxes: [
            {
              type: "time",
              time: {
                unit: "quarter"
              }
            }
          ],
          yAxes: [
            {
              display: true,
              scaleLabel: {
                display: true,
                labelString: "house value"
              }
            }
          ]
        }
      }
    };
    this.chartConfig = {};
    this.chartConfig = config;
  }

  updateChart(e) {
    console.log(e.target.value); //property type value
    console.log(this.pidChart);

    switch (e.target.value.trim()) {
      case "All":
        console.log("All");
        this.configChart(this.chartDataSets_All);
        break;
      case "Detached":
        console.log("Detached");
        this.configChart(this.chartDataSets_Detached);
        break;
      case "Townhouse":
        console.log("Townhouse");
        // this.chartConfig.data.datasets = this.chartDataSets_Townhouse;
        this.configChart(this.chartDataSets_Townhouse);
        break;
      case "Apartment":
        console.log("Apartment");
        // this.chartConfig.data.datasets = this.chartDataSets_Apartment;
        this.configChart(this.chartDataSets_Apartment);
        break;
    }
    this.pidChart.config = this.chartConfig;
    this.pidChart.update();
  }

  removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach(dataset => {
      dataset.data.pop();
    });
    chart.update();
  }

  addData(chart, label, data) {
    chart.data.labels.push(label);
    // chart.data.datasets.forEach(dataset => {
    //   dataset.data.push(data);
    // });
    data.forEach(dataSet => chart.data.datasets.push(dataSet));
    chart.update();
    console.log(chart.data.datasets);
  }

  getChartData() {
    var nbhSection = $("#marketSection");
    var nbhCodes = nbhSection.attr("nbhCodes");
    console.log(nbhCodes);
    var self = this;

    $.ajax({
      url:
        "http://pidrealty.local/wp-content/themes/realhomes-child/db/chartData.php",
      method: "get",
      data: { Neighborhood_IDs: nbhCodes },
      dataType: "JSON",
      success: function(res) {
        res.forEach(dataSet => {
          let xPropertyType = dataSet["property_Type"].trim();
          let xData = {
            label: self.neighborhoodNames[dataSet["nbr_ID"].trim()],
            data: dataSet["nbr_Data"]
          };
          switch (xPropertyType) {
            case "All":
              self.chartDataSets_All.push(xData);
              break;
            case "Detached":
              self.chartDataSets_Detached.push(xData);
              break;
            case "Townhouse":
              self.chartDataSets_Townhouse.push(xData);
              break;
            case "Apartment":
              self.chartDataSets_Apartment.push(xData);
              break;
          }
        });
        // self.chartDataSets = res;
        // console.log("ajax");
        console.log(self.chartDataSets_All);
        //self.init(self.chartDataSets_All);
        self.configChart(self.chartDataSets_All);
        self.drawChart(self.chartConfig);
      }
    });
  }

  drawChart(config) {
    // console.log(ctx);
    console.log(config);
    //var ctx = $("#lineChart");
    this.pidChart = new Chart(this.ctx, config);
  }
}

export default pidChart;
