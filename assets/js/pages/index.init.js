
var options = {
    series: [
      { name: "Income", data: [100,40,30,30,10,10,10] },
      { name: "Expenses", data: [20,20,10,10,40,40,60] }
    ],
    chart: {
      height: 275,
      type: "area",
      toolbar: { show: false },
      dropShadow: {
        enabled: true,
        top: 12,
        left: 0,
        blur: 2,
        color: "rgba(132, 145, 183, 0.3)",
        opacity: 0.35
      }
    },
    annotations: {
      xaxis: [{
        x: 270,
        strokeDashArray: 4,
        borderWidth: 1,
        borderColor: "var(--bs-secondary)"
      }],
      points: [{
        x: 270,
        y: 40,
        marker: {
          size: 6,
          fillColor: "var(--bs-primary)",
          strokeColor: "var(--bs-card-bg)",
          strokeWidth: 4,
          radius: 5
        },
        label: {
          borderWidth: 1,
          offsetY: -55,
          text: "50k",
          style: {
            background: "var(--bs-primary)",
            fontSize: "14px",
            fontWeight: "600"
          }
        }
      }]
    },
    colors: ["#06afdd","#f4a14d"],
    dataLabels: { enabled: false },
    stroke: {
      show: true,
      curve: "straight",
      width: [2,2],
      lineCap: "round"
    },
    labels: ["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ Nhật"],
    yaxis: {
      labels: {
        offsetX: -12,
        formatter: function (val) { return val + " VNĐ"; }
      }
    },
    grid: {
      strokeDashArray: 3,
      xaxis: { lines: { show: true } },
      yaxis: { lines: { show: false } }
    },
    legend: { show: false },
    fill: {
      type: "gradient",
      gradient: {
        type: "vertical",
        opacityFrom: 0.05,
        opacityTo: 0.05,
        stops: [45,100]
      }
    }
  };
  var chart = new ApexCharts(document.querySelector("#ana_dash_1"), options);
  chart.render();
  
  // Chart 2: Donut
  options = {
    chart: { height: 250, type: "donut" },
    plotOptions: {
      pie: {
        donut: { size: "80%" }
      }
    },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ["transparent"] },
    series: [50, 25, 25],
    legend: {
      show: true,
      position: "bottom",
      fontSize: "13px",
      fontFamily: "Be Vietnam Pro, sans-serif"
    },
    labels: ["Current","New","Retargeted"],
    colors: ["#6f6af8","#08b0e7","#f4a14d"],
    responsive: [{
      breakpoint: 600,
      options: {
        plotOptions: { pie: { donut: { customScale: 0.2 } } },
        chart: { height: 240 },
        legend: { show: false }
      }
    }],
    tooltip: {
      y: { formatter: val => val + " %" }
    }
  };
  chart = new ApexCharts(document.querySelector("#sessions_device"), options);
  chart.render();
  
  // Chart 3: Visits
  options = {
    chart: {
      height: 315,
      type: "area",
      stacked: true,
      toolbar: { show: false }
    },
    colors: ["#2a77f4","rgba(42, 118, 244, .4)"],
    dataLabels: { enabled: false },
    stroke: { curve: "straight", width: [0,0] },
    grid: { strokeDashArray: 3 },
    markers: { size: 0 },
    series: [
      { name: "New Visits", data: [0,40,90,40,50,30,35,20,10,0,0,0] },
      { name: "Unique Visits", data: [20,80,120,60,70,50,55,40,50,30,35,0] }
    ],
    xaxis: {
      categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
    },
    fill: { type: "gradient", gradient: { opacityFrom: 1, opacityTo: 1 } },
    tooltip: { x: { format: "dd/MM/yy HH:mm" } },
    legend: { position: "top", horizontalAlign: "right" }
  };
  chart = new ApexCharts(document.querySelector("#monthly_income"), options);
  chart.render();