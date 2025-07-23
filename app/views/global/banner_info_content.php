<div class="col-lg-6 col-md-6 col-xs-12">
  <table class="table" style="margin-top:5px;">
    <tr>
      <td>Total Penerimaan Bulan <?= date('F') ?> <?= date('Y') ?></td>
      <td>: Rp. <?= number_format($curr_month_revenue); ?></td>
    </tr>
    <tr>
      <td>Total Penerimaan Sampai Bulan <?= date('F') ?> <?= date('Y') ?></td>
      <td>: Rp. <?= number_format($tot_revenue); ?></td>
    </tr>
    <tr>
      <td>Total Piutang </td>
      <td>: Rp. <?= number_format($tot_receivables); ?></td>
    </tr>

  </table>
</div>
<div class="col-lg-5 col-md-5 col-xs-12">
  <canvas id="barChart" height="100"></canvas>
</div>
<script src="<?= $this->config->item("js_path"); ?>plugins/chartjs/chart.min.js"></script>
<script type="text/javascript">
  // BAR CHART
  var barOptions = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - If there is a stroke on each bar
    barShowStroke: true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth: 1,
    //Number - Spacing between each of the X value sets
    barValueSpacing: 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing: 1,
    //Boolean - Re-draw chart on page resize
    responsive: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
  }
  var barData = {
    labels: <?= $label_chart; ?>,
    datasets: [{
      label: "Grafik PPDB Online",
      fillColor: "rgba(20, 255, 0,0.5)",
      strokeColor: "rgba(16, 191, 1,0.8)",
      highlightFill: "rgba(23, 224, 6,0.75)",
      highlightStroke: "rgba(19, 198, 3,1)",
      data: <?= $data_chart; ?>
    }]
  };

  // render chart
  var ctx = document.getElementById("barChart").getContext("2d");
  var myNewChart = new Chart(ctx).Bar(barData, barOptions);
  // END BAR CHART
</script>