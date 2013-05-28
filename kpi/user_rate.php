<?php
	echo "<script type='text/javascript'>";
	$many = (count($metric) > 1 ? true : false);
	foreach ($metric as $metric_item):
		echo "$(document).ready(function()
			{";
		echo ($many ? "$('#metric".$metric_item['field_id']."-viewprev-button')" : "$(#metric".$metric_item['field_id']."-viewprev-button)");
		echo ".click(function()
				{";
		echo ($many ? "$('.metric".$metric_item['field_id']."-prev').toggle()" : "$(.metric".$metric_item['field_id']."-prev).toggle()");
		echo "});
			});";
	endforeach;
	echo "</script>";
?>

<script type='text/javascript'>
	$(function() {
		$(document).tooltip();
	});
</script>

<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion menu lefted">
		<?php foreach ($kpi as $kpi_item): 
			echo "<div><h3>".$kpi_item['kpi_name']."</h3><ul class='accordion-list'>";
				foreach ($subkpi as $subkpi_item): 
					if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
					{
						$url1 = str_replace(" ", "_", $kpi_item['kpi_name']);
						$url2 = str_replace(" ", "_", $subkpi_item['kpi_name']);
						echo "<div".((!empty($current_subkpi) && $current_subkpi==$subkpi_item['kpi_name']) ? ' class="active"' : '')."><a href='rate?q=".$url1."/".$url2."'><li>".$subkpi_item['kpi_name']."</li></a></div>"; 
					}
				endforeach; 
			echo "</ul></div>";
		    endforeach; 
		?>
	</div>	
	
	
	<div id="user-inside" class="inside">
		<table>
		<?php
			echo $this->session->flashdata('errors');
			//place user-id session here
			$user_id = 3;
			
			if($checker!='empty' && !empty($active)):
				echo "<h2>".$current_kpi." > ".$current_subkpi."</h2>";
				$count = 0;
				if (isset($next)) echo form_open('rate?q='.$next);
				else echo form_open('user_rated');
				
				foreach ($metric as $metric_item):
					echo "<tr><td>".$metric_item['field_name']."</td><td><input type='number' name='answer".$metric_item['field_id']."' id='answer".$metric_item['field_id']."' value='".$metric_value[$count]."' min=0></input></td><td><button type='button' id='metric".$metric_item['field_id']."-viewprev-button'>View Previous Ratings</button></td></tr>";
					$count++;
					foreach ($period as $period_item):
						foreach ($metric_values as $metric_values_item):
							if (($metric_item['field_id']==$metric_values_item['field_id']) && ($user_id==$metric_values_item['user_id']) && $metric_values_item['results_id']==$period_item['results_id'])
								echo "<tr class='hidden metric".$metric_item['field_id']."-prev'><td>".$period_item['results_name']."</td><td>".$metric_values_item['value']."</td></tr>";
						endforeach;
					endforeach;
			    endforeach;
				//if (isset($next)): echo form_close(); endif;
			else:
				if (!empty($active))
					echo "<h2>eUP KPI: ".$active[0]['results_name']."</h2><div class='alert alert-red'>You have not yet started rating. Choose a KPI on the left to start.</div>";
				else echo "<h2>No currently active result</h2><p>Rating KPIs is not allowed.</p>";
		    endif;
		?>
		</table>
		<?php
			if($checker!='empty' && !empty($active)):
				if (isset($next)) echo "<a href='rate?q=".$next."'>";
				else echo "<a href='user_rated'>";
				echo "<button type='submit' class='righted'>Next</button></a>";
				if (isset($next)): echo form_close(); endif;
		 endif; ?>
		
	</div>
</div>