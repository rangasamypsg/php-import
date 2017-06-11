<html>
  <head>
    <!--Load the AJAX API-->
    <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->

	<script type="text/javascript" src="js/jquery.min-1.10.2.js"></script>
	<script type="text/javascript" src="js/loader.js"></script>
	<link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(pie_chart);
    function pie_chart() {
      var jsonData = $.ajax({
          url: "pie_chart.php",
		  dataType: "json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
	 // alert(jsonData);return false;
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
      chart.draw(data, {width: 1200, height: 600});
    }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
	<p><a class="btn btn-success" href="index.php">Back</a></p>
	<div style="font: 21px arial; padding: 10px 0 0 100px;">Pie Chart</div>
    <div id="piechart_div"></div>   
  </body>
</html>