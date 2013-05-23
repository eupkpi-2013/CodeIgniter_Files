<div id="user-contents" class="contents">
	<div id="user-kpimenu" class="accordion menu lefted">
		<?php foreach ($kpi as $kpi_item): 
			 echo "<div><h3>".$kpi_item['kpi_name']."</h3><ul class='accordion-list'>";
				 foreach ($subkpi as $subkpi_item): 

						if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
						{
							$url1 = str_replace(" ", "_", $kpi_item['kpi_name']);
							$url2 = str_replace(" ", "_", $subkpi_item['kpi_name']);
                            echo "<div><li><a href='edit?q=".$url1."/".$url2."'>".$subkpi_item['kpi_name']."</a></div></li>";  
 						}
						
				 endforeach; 
			 echo "</ul></div>";
		endforeach; 
		?>
	</div>	
	<div id="user-inside" class="inside">
		<a href="superuser_addkpi"><button>Add KPI</button></a>
	</div>
</div>
