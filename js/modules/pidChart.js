import $ from "jquery";
import Chart from "chart.js";

class pidChart {
  constructor() {
    let ctx = $("#lineChart");
    this.chartDataSets = [];
    // this.chartData2 = [];
    // this.chartData3 = [];
    this.getChartData();
  }

  getChartData() {
    var nbhSection = $("#marketSection");
    var nbhCode = nbhSection.attr("nbhCode");
    console.log(nbhCode);
    var self = this;

    $.ajax({
      url:
        "http://pidrealty.local/wp-content/themes/realhomes-child/db/chartData.php",
      method: "get",
      data: { Neighborhood_ID: "F20,F23" },
      dataType: "JSON",
      success: function(res) {
        res.forEach(dataSet => {
          console.log(dataSet);
          var xData = {
            label: dataSet["nbr_ID"],
            data: dataSet["nbr_Data"]
          };
          self.chartDataSets.push(xData);
        });
        // self.chartDataSets = res;
        // console.log("ajax");
        console.log(self.chartDataSets);
        self.drawChart(self.chartDataSets);
        // $.ajax({
        //   url:
        //     "http://pidrealty.local/wp-content/themes/realhomes-child/db/chartData.php",
        //   method: "get",
        //   data: { Neighborhood_ID: "F20" },
        //   dataType: "JSON",
        //   success: function(res) {
        //     self.chartData2 = res;
        //     console.log(self.chartData2);
        //     $.ajax({
        //       url:
        //         "http://pidrealty.local/wp-content/themes/realhomes-child/db/chartData.php",
        //       method: "get",
        //       data: { Neighborhood_ID: "F30A" },
        //       dataType: "JSON",
        //       success: function(res) {
        //         self.chartData3 = res;
        //         console.log(self.chartData3);
        //         self.drawChart();
        //       }
        //     });
        //   }
        // });
      }
    });
  }

  drawChart(dataSets) {
    var nbhSection = $("#marketSection");
    var nbhCode = nbhSection.attr("nbhCode");
    console.log(nbhCode);

    console.log(this.chartData1);
    let ctx = $("#lineChart");
    let myChart = new Chart(ctx, {
      type: "line",
      data: {
        //labels: data[0],
        datasets: dataSets
        // datasets: [
        //   {
        //     label: nbhCode + " Market Chart",
        //     fill: false,
        //     backgroundColor: "rgba(75, 192, 192, 0.4)",
        //     borderColor: "rgba(75, 192, 192, 1)",
        //     data: this.chartData1 //data[1]
        //   },
        //   {
        //     label: "F20" + " Market Chart",
        //     fill: false,
        //     backgroundColor: "rgba(75, 75, 192, 0.4)",
        //     borderColor: "rgba(75, 75, 192, 1)",
        //     data: this.chartData2 //data[1]
        //   },
        //   {
        //     label: "F30A" + " Market Chart",
        //     fill: false,
        //     backgroundColor: "rgba(75, 125, 192, 0.4)",
        //     borderColor: "rgba(75, 125, 192, 1)",
        //     data: this.chartData3 //data[1]
        //   }
        // ]
      },
      options: {
        title: {
          display: false,
          text: nbhCode
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          xAxes: [
            {
              type: "time",
              time: {
                unit: "quarter"
              }
            }
          ]
        }
      }
    });
  }

  test() {
    alert("hi chart");
  }
}

export default pidChart;
