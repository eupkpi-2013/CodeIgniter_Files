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

<?php
	echo '<script>
		$(document).ready( function() {
			$(\'.alert\').delay(10000).fadeOut();
		})
		</script>';
?>

<script language="javascript" type="text/javascript">
	$(document).ready(function(){
        $('.splash').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Stacked column chart'
            },
            xAxis: {
                categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total fruit consumption'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -100,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'John',
                data: [5, 3, 4, 7, 2]
            }, {
                name: 'Jane',
                data: [2, 2, 3, 2, 1]
            }, {
                name: 'Joe',
                data: [3, 4, 4, 2, 5]
            }]
        });
    });
</script>

<title>eUP KPI</title>
</head>

<body>
	<div class="login login-banner">
		<a href = '<?php echo site_url(); ?>/index'>
		<img src="../kpi_sources/img/up_small.png"/>
		<h1>eUP KPI</h1>
		</a>
	</div>

	<div id="login-buttons" class="login content">
		<button><a href="auth">Log-in with Google</a></button>
		<button id="signup-button">Sign up</button>
		<?php if (validation_errors() == "") echo "<div id='signup' class='hidden'>";
			else echo "<div id='signup'>";?>
		<?php echo validation_errors(); ?>
		<?php echo form_open('signup'); ?>
			<label>First Name</label>
			<input id="fname" name="fname"></input>
			<label>Last Name</label>
			<input id="lname" name="lname"></input>
			<label>Gmail</label>
			<input id="gmail" name="gmail"></input>
			<label>Confirm Gmail</label>
			<input id="con_gmail" name="con_gmail"></input>
			<button class="righted" type="submit">Submit</button>
		<?php echo form_close(); ?>
		</div>
	</div>
	<div class="login splash"></div>	
	<div class="login">
		<button><a href="publicreports">See Public Reports</a></button>
	</div>


<footer>
	<div>
		<a href="about.html">About</a>
	</div>
</footer>

</body>
</html>