<div id="user-contents" class="contents">
  <div id="user-kpimenu" class="accordion menu lefted">
		<?php foreach ($iscu as $iscu_item): 
			$url = $iscu_item['iscu'];
			echo "<a href='superuser_assign?iscu=".$url."'><div><h3>".$iscu_item['iscu']."</h3>";
			echo "</div></a>";
		endforeach; 
		?>
	</div>	
	<div id="user-inside" class="inside">
		<?php 
		if (!isset($_GET['iscu'])){
			echo "<h3>Choose from the left</h3>";
		} else {
			echo "<h3>".$_GET['iscu']."</h3>";

		echo form_open('assignISCU');

		foreach ($kpi as $kpi_item): 
			 echo "<ul class='indented-list'><input class='checklist' type='checkbox' name='kpi[]' value=\"".$kpi_item['kpi_id']."\">KPI: &nbsp".$kpi_item['kpi_name']."</input>";
				 foreach ($subkpi as $subkpi_item): 
						if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
						{
							echo "<ul class='indented-list' class='checklist'><li><input type='checkbox' name='subkpi[]' value=\"".$subkpi_item['kpi_id']."\">Sub-KPI: &nbsp".$subkpi_item['kpi_name']."</input></li></ul>"; 						
							    foreach ($metric as $metric_item): 	
									if($metric_item['kpi_id']==$subkpi_item['kpi_id'])
									{
										echo "<ul class='indented-list' class='checklist'><li><input type='checkbox' name='metric[]' value=\"".$metric_item['field_id']."\">Metric: &nbsp".$metric_item['field_name']."</input></li></ul>"; 						
									}
								endforeach;
						}
				 endforeach; 
			 echo "</ul>";
		endforeach;

		echo "<input type='hidden' name='iscu' value='".$_GET['iscu']."'/>";
		echo "<button class='righted' onclick='submit()'>Save</button>";
		echo "</form>";
		}
		?>
	</div>
</div>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="../kpi_sources/jquery-1.9.1.js"></script>
<script src="../kpi_sources/Highcharts-3.0.1/js/highcharts.js"></script>
<script src="../kpi_sources/js.js"></script>
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
<script>
	function submit(){
		var r = confirm("Save?");
		if(r==true){
			window.location = "superuser_assign.html";
		}
	}
</script>
