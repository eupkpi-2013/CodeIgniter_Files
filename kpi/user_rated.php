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
		<?php
		echo $this->session->flashdata('errors');
		$no_submit=false;
		if (!empty($active)) {
			echo "<h2>eUP KPI: ".$active[0]['results_name']."</h2>";
			if ( count($fieldvalues)!= count($metric) ) $no_submit=true;
			foreach ($kpi as $kpi_item):
				echo '<div class="ratingsdiv"> <h3>'.$kpi_item['kpi_name'].'</h3>';
				foreach ($subkpi as $subkpi_item):
					if ($subkpi_item['parent_kpi']==$kpi_item['kpi_id']):
						echo "<div>".$subkpi_item['kpi_name'];
						echo "<table class='table-lined'>";
						foreach($metric as $metric_item){
							if ($metric_item['kpi_id'] == $subkpi_item['kpi_id']){
								echo "<tr><td>".$metric_item['field_name']."</td>";
								foreach ($fieldvalues as $fieldvalue_item):
									if ($fieldvalue_item['field_id']==$metric_item['field_id']):
										echo "<td>".$fieldvalue_item['value']."</td>";
										break;
									endif;
								endforeach;
								echo "</tr>";
							}
						}
						echo "</table></div><br>";
					endif;
				endforeach;
			endforeach;
		}
		else echo "<h2>No currently active result</h2><p>Rating KPIs is not allowed.</p>";
		?>
		</div>
	</div>
	<?php
		if(!empty($active)) {
			echo '<form action="submit">';
			echo '<button id="submitKPI-button" class="righted button-green submitKPI" '.($no_submit ? 'disabled' : '').'>Submit for Verification</button>';
			echo '</form>';
		}
	?>
</div>