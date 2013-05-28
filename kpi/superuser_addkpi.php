<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion menu lefted">
		<?php foreach ($kpi as $kpi_item): 
			 echo "<div><h3>".$kpi_item['kpi_name']."</h3><ul class='accordion-list'>";
				 foreach ($subkpi as $subkpi_item): 

						if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
						{
							$url1 = str_replace(" ", "_", $kpi_item['kpi_name']);
							$url2 = str_replace(" ", "_", $subkpi_item['kpi_name']);
							echo "<div><a href='edit?q=".$url1."/".$url2."'><li>".$subkpi_item['kpi_name']."</li></a></div>"; 
						}

				 endforeach; 
			 echo "<div><li><a href='superuser_addsubkpi?id=".$kpi_item['kpi_id']."'><button>Add SubKPI</button></a></li></div>";
			 echo "</ul></div>";
		endforeach; 
		?>
	</div>	
	<div id="user-inside" class="inside">
		<?php if (empty($active)): ?>
		<?php echo "<h3>Add KPI</h3>"; ?>
		<?php echo $this->session->flashdata('errors'); ?>
		<?php echo validation_errors('<div class="alert alert-red">', '</div>'); ?>
		<?php echo form_open('addKPI'); ?>
		<label>KPI Name</label>
		<input type="text" name="kpi_name" /><br><br>
		<input name="radio" type="radio" value="subkpi_radio" checked>Add Sub KPI</input>
		<input name="radio" type="radio" value="metric_radio">Add Metric</input>
		<button class="left" name="save" type="submit" value="Save">Next</button>
		</form>
		<?php else: echo '<h2>Currently active result: '.$active[0]['results_name'].'</h2><p>Adding of KPI is not allowed.</p>';?>
		<?php endif; ?>
	</div>
</div>