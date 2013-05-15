<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion lefted">
		<?php foreach ($kpi as $kpi_item): 
			 echo "<div><h3>".$kpi_item['kpi_name']."</h3><ul>";
				 foreach ($subkpi as $subkpi_item): 
					
						if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
						{
							$url1 = str_replace(" ", "_", $kpi_item['kpi_name']);
							$url2 = str_replace(" ", "_", $subkpi_item['kpi_name']);
							echo "<div><a href='rate?q=".$url1."/".$url2."'><li>".$subkpi_item['kpi_name']."</li></a></div>"; 
						}
					
				 endforeach; 
			 echo "</ul></div>";
		      endforeach; 
		?>
	</div>
	<div id="user-inside" class="lefted">
		<h2>eUP KPI: After 2 months</h2>
			<?php
			foreach ($kpi as $kpi_item):
				echo '<div class="ratingsdiv"> <h3>'.$kpi_item['kpi_name'].'</h3>';
				foreach ($subkpi as $subkpi_item):
					if ($subkpi_item['parent_kpi']==$kpi_item['kpi_id']):
						echo "<div>".$subkpi_item['kpi_name'];
						echo "<table><tr><td>";
					endif;
				endforeach;
			endforeach;
			?>
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
			<div>
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
		</div>
	</div>
	<button class="righted submitKPI">Submit for Verification</button>
</div>