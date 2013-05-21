<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion menu lefted">
		<?php foreach ($kpi as $kpi_item): 
			 echo "<div><h3>".$kpi_item['kpi_name']."</h3>";?>
				<ul class="accordion-list">
				<?php foreach ($subkpi as $subkpi_item): 
					
						if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
						{
							$url1 = str_replace(" ", "_", $kpi_item['kpi_name']);
							$url2 = str_replace(" ", "_", $subkpi_item['kpi_name']);
							echo "<div><a href='rate?q=".$url1."/".$url2."'><li>".$subkpi_item['kpi_name']."</li></a></div>"; 
						}
					
				endforeach; ?>
			 </ul></div>
		      <?php endforeach; ?>
	</div>	
	
	
	<div id="user-inside" class="inside">
		<table>
		<?php		
			if($checker!='empty'):
				foreach ($metric as $metric_item): 		
				
				 foreach ($subkpi as $subkpi_item): 
						 
							if($subkpi_item['kpi_id']==$metric_item['kpi_id'])
							 {
								foreach ($kpi as $kpi_item):
									if($kpi_item['kpi_id']==$subkpi_item['parent_kpi'])
									{
										$parent = $kpi_item['kpi_name'];
									}
								endforeach;
								
								echo "<h2>".$parent." > ".$subkpi_item['kpi_name']."</h2>";
					         }
						
				 endforeach; 
				
				
					echo "<tr><td>".$metric_item['field_name']."<td><td><input type='number' class='number-input' min='0' role='spinbutton'></input></td></tr>";
				
			     endforeach;		
		
			else:
				echo "<h2>eUP KPI: After 2 months</h2><p>Choose a KPI on the left.</p><br><button>View your previous ratings</button>";
		
		
		    endif; ?>
		</table>
		<?php
			if($checker!='empty'): 
				echo "<a href='user_rate_kpi1-3.html'><button class='righted'>Next</button>";
		
		 endif; ?>
		
	</div>
</div>

<!--javascripts-->
<script>


</script>

