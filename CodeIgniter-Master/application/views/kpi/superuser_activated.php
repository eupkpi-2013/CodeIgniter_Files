<! DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="style.css">
<link href='http://fonts.googleapis.com/css?family=Merriweather+Sans' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
<script src="../js/jquery-1.9.1.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="../Highcharts-3.0.1/js/highcharts.js"></script>
<script src="js.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".checklist").change(function(){
			if ($(this).is(':checked')){
				$(this).parent().find($("input")).attr('checked', true);
			}
			else{
				$(this).parent().find($("input")).attr('checked', false);
			}
		});
	});
</script>

<title>eUP KPI</title>
</head>

<body>
<div id="user-header" class="header">
	<header>
		<a href="">
		<div id="user-banner" class="banner">
			<img src="img/up_small.png" class="lefted"/>
			<h1 class="lefted">eUP KPI</h1>
		</div>
		</a>
		<div id="user-logout" class="logout righted">
			<a herf="">Logged in as User, </a>
			<a href="index.html">Logout</a>
		</div>
		<div id="user-nav" class="nav">
			<ul>
			<li id="user-home"><a href="superuser_home.html">Home</a></li>
			<li id="user-rate"><a href="superuser_kpis.html">KPIs</a></li>
			<li id="user-rate"><a href="superuser_accounts.html">Accounts</a></li>
			<li id="user-rate"><a href="superuser_activate.html">Activate</a></li>
			<li id="user-rate"><a href="superuser_targets.html">Targets</a></li>
			<li id="user-results"><a href="superuser_results.html">Results</a></li>
			</ul>
		</div>
	</header>
</div>
<div id="user-contents" class="contents">
	<div class="alert">KPIs Activated</div>
</div>

</body>
</html>