<?php
	echo "<script type='text/javascript'>";
	foreach ($metric as $metric_item): 
		echo "$(document).ready(function()
			{
			$('#metric".$metric_item['field_id']."-viewprev-button').click(function()
				{
				$('.metric".$metric_item['field_id']."-prev').toggle();
				});
			});";
	endforeach; 
	echo "</script>";
?>

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
		<table>
		<?php
			//place user-id session here
			$user_id = 4;
			
			if($checker!='empty'):
				echo "<h2>".$current_kpi." > ".$current_subkpi."</h2>";
				$count = 0;
				if (isset($next)): echo form_open('rate?q='.$next); endif;
				foreach ($metric as $metric_item): 
					
					echo "<tr><td>".$metric_item['field_name']."<td><td><input type='text' name='answer".++$count."' id='answer".++$count."'></input></td><td><button id='metric".$metric_item['field_id']."-viewprev-button'>View Previous Ratings</button></td></tr>";
				
			    endforeach;
				if (isset($next)): echo form_close(); endif;
			else:
				echo "<h2>eUP KPI: After 2 months</h2><div class='alert alert-red'>You have not yet started rating. Choose a KPI on the left to start.</div><p>Choose a KPI on the left.</p><br><button>View your previous ratings</button>";
				
		
		
		    endif;
		?>
		</table>
		<?php
			if($checker!='empty'):
				if (isset($next)) echo "<a href='rate?q=".$next."'><button class='righted'>Next</button>";
				else echo "<a href='user_rated'><button class='righted'>Next</button>";
		
		 endif; ?>
		
	</div>
</div>
