<! DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="../kpi_sources/style.css">
<link href='http://fonts.googleapis.com/css?family=Merriweather+Sans' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
<script src="../kpi_sources/js/jquery-1.9.1.js"></script>
<script src="../kpi_sources/Highcharts-3.0.1/js/highcharts.js"></script>
<script src="../kpi_sources/js/js.js"></script>

<?php header('refresh:5; url=index'); ?>



<title>eUP KPI</title>
</head>

<body>
	<div class="login login-banner">
		<img src="../kpi_sources/img/up_small.png"/>
		<h1>eUP KPI</h1>
	</div>

	<div id="login-buttons" class="login content">
		<?php echo "Sorry, the email account you used has no registered account! Please sign up first. <br /><br /> You will be automatically redirected to the homepage. Click "."<a href='user' style='color: blue'>here</a>"." if you are not redirected in 5 seconds."?>
	</div>
	<div class="login splash"></div>	

</body>
</html>