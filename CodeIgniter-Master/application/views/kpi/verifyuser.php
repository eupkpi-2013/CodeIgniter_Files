<div id="user-inside" class="lefted">
	<?php
	$con = mysql_connect("localhost","root","lrmds");
			if (!$con) 
			{
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db("testkpi", $con);
		
			$q = $_GET['q'];
			$trash = strtok($q, "_");
			$trash = strtok("_");
			$id = strtok("_");
		
			$result = mysql_query("SELECT * FROM updates where account_id=$id");
			$info = "<h2>eUP KPI:</h2><h2>User001</h2><div class='ratingsdiv'> <h3>KPI1</h3><a href='auditor_verify_user002.html'><button class='righted'>Verify</button></div>";
				
	?>
</div>

<div id="user-inside" class="lefted">
		<h2>eUP KPI: After 2 months</h2>
		<h2>User001</h2>
		<div class="ratingsdiv"> <h3>KPI1</h3>
				<div>Sub KPI1
					<table>
						<tr>
							<td>Metric 1</td>
							<td>Value 1</td>
						<tr>
						<tr>
							<td>Metric 2</td>
							<td>Value 2</td>
						<tr>
						<tr>
							<td>Metric 3</td>
							<td>Value 3</td>
						<tr>
					</table>
				</div>
				<div>Sub KPI2
					<table>
						<tr>
							<td>Metric 1</td>
							<td>Value 1</td>
						<tr>
						<tr>
							<td>Metric 2</td>
							<td>Value 2</td>
						<tr>
						<tr>
							<td>Metric 3</td>
							<td>Value 3</td>
						<tr>
						<tr>
							<td>Metric 4</td>
							<td>Value 4</td>
						<tr>
					</table>
				</div>
				<div>Sub KPI3
					<table>
						<tr>
							<td>Metric 1</td>
							<td>Value 1</td>
						<tr>
						<tr>
							<td>Metric 2</td>
							<td>Value 2</td>
						<tr>
						<tr>
							<td>Metric 3</td>
							<td>Value 3</td>
						<tr>
						<tr>
							<td>Metric 4</td>
							<td>Value 4</td>
						<tr>
					</table>
				</div>
			</div>
			<div class="ratingsdiv"> <h3>KPI2</h3>
				<div>Sub KPI1
					<table>
						<tr>
							<td>Metric 1</td>
							<td>Value 1</td>
						<tr>
						<tr>
							<td>Metric 2</td>
							<td>Value 2</td>
						<tr>
						<tr>
							<td>Metric 3</td>
							<td>Value 3</td>
						<tr>
					</table>
				</div>
				<div>Sub KPI2
					<table>
						<tr>
							<td>Metric 1</td>
							<td>Value 1</td>
						<tr>
						<tr>
							<td>Metric 2</td>
							<td>Value 2</td>
						<tr>
						<tr>
							<td>Metric 3</td>
							<td>Value 3</td>
						<tr>
						<tr>
							<td>Metric 4</td>
							<td>Value 4</td>
						<tr>
					</table>
				</div>
				<div>Sub KPI3
					<table>
						<tr>
							<td>Metric 1</td>
							<td>Value 1</td>
						<tr>
						<tr>
							<td>Metric 2</td>
							<td>Value 2</td>
						<tr>
						<tr>
							<td>Metric 3</td>
							<td>Value 3</td>
						<tr>
						<tr>
							<td>Metric 4</td>
							<td>Value 4</td>
						<tr>
					</table>
				</div>
			</div>
		<a href="auditor_verify_user002.html"><button class="righted">Verify</button>	
	</div>