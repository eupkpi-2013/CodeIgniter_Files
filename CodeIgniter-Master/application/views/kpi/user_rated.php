<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion menu lefted">
		<?php foreach ($kpi as $kpi_item): 
			 echo "<div><h3>".$kpi_item['kpi_name']."</h3><ul class='accordion-list'>";
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
	<div id="user-inside" class="inside">
		<h2>eUP KPI: After 2 months</h2>
			<?php
			foreach ($kpi as $kpi_item):
				echo '<div class="ratingsdiv"> <h3>'.$kpi_item['kpi_name'].'</h3>';
				foreach ($subkpi as $subkpi_item):
					if ($subkpi_item['parent_kpi']==$kpi_item['kpi_id']):
						echo "<div>".$subkpi_item['kpi_name'];
						echo "<table class='table-lined'>";
						foreach($fieldvalues as $fv){
							if($fv['kpi_id'] == $subkpi_item['kpi_id']){
								echo "<tr><td>".$fv['field_name']."</td><td>".$fv['value']."</td></tr>";
							}
						}
						echo "</table></div><br>";
					endif;
				endforeach;
			endforeach;
			?>
		</div>
	</div>
	<form action="submit">
	<button id="submitKPI-button" class="righted button-green submitKPI">Submit for Verification</button>
	</form>
</div>