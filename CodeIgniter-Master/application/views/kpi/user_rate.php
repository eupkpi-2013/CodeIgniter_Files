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
		<table>
		<?php		
			if($checker!='empty'):
				echo "<h2>".$current_kpi." > ".$current_subkpi."</h2>";
				
				foreach ($metric as $metric_item): 
				
					echo "<tr><td>".$metric_item['field_name']."<td><td><input type='text'></input></td></tr>";
				
			     endforeach;		
		
			else:
				echo "<h2>eUP KPI: After 2 months</h2><p>Choose a KPI on the left.</p><br><button>View your previous ratings</button>";
		
		
		    endif; ?>
		</table>
		<?php
			if($checker!='empty'):
				if (isset($next)) echo "<a href='rate?q=".$next."'><button class='righted'>Next</button>";
				else echo "<a href='user_rated'><button class='righted'>Next</button>";
		
		 endif; ?>
		
	</div>
</div>

<!--javascripts-->
<script>


</script>

