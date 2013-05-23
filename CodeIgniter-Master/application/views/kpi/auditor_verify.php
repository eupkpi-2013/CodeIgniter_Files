<div id="user-contents" class="contents">	
	
	<div id="user-kpimenu" class="accordion menu lefted">
	<?php foreach ($userid as $userid_item): 
				echo "<div><a href='verify?q=auditor_verify_".$userid_item['user_id']."'><h3>".$userid_item['user_id']."</h3></a></div>";  
		  endforeach; ?>
	</div>
	
	<div id="user-inside" class="inside">
		<?php 
			if($checker!='empty'):
				
				foreach ($kpi as $kpi_item):
					echo "<div class='ratingsdiv'> <h3>".$kpi_item['kpi_name']."</h3>";
						foreach ($subkpi as $subkpi_item):
							if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
							{
								echo "<div>".$subkpi_item['kpi_name']."<table>";
									foreach ($metric as $metric_item):
										if($metric_item['kpi_id']==$subkpi_item['kpi_id'])
										{
											echo "<tr>";
											echo "<td>".$metric_item['field_name']."</td>";
											
											if($user_id==$metric_item['user_id'])
											{
												echo "<td>".$metric_item['value']."</td>";
											}
											echo "<tr>";
										}
									endforeach;
								echo "</table></div>";
							}
						endforeach;
					echo "</div>";
				endforeach;
		
			else:
				echo "<h2>eUP KPI: After 2 months</h2><p>Choose a User on the left.</p><br>";
		
		    endif;
		?>
	</div>
</div>