<script language="javascript" type="text/javascript">
	function submitted(){
		var username = document.getElementById("uname").value;
		var redirectto = "";
		if(username=="user"){
			redirectto = "user_home.html";
		}
		else if(username=="auditor"){
			redirectto = "auditor_home.html";
		}
		else if(username=="superuser"){
			redirectto = "superuser_home.html";
		}
		else if(username=="boss"){
			redirectto = "boss_home.html";
		}
		window.location = redirectto;
	}
</script>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
        $('#login-splash').highcharts({
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

<div class="login login-banner">
	<img src="../kpi_sources/img/up_small.png"/>
	<h1>eUP KPI</h1>
</div>

<div id="login-buttons" class="login content">
	<div id="login-form">
		<button>Log-in with Google</button>
		<button id="signup-button">Sign up</button>
		<div id="signup" class="hidden">
			<label>Name</label>
			<input></input>
			<label>Gmail</label>
			<input></input>
			<button class="righted">Submit</button>
		</div>
	</div>
	<div class="login splash"></div>	
	<div class="login"><a href="public_results.html"><button>See Public Reports</button><a></div>
</div>