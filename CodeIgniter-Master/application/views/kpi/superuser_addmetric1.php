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
			 echo "<div><li><a href='#'><button>Add SubKPI</button></a></li></div>";
			 echo "</ul></div>";
		endforeach; 
		?>
	</div>	
	<div id="user-inside" class="inside">
		<?php
			foreach ($kpi as $kpi_item):
				if ($kpi_item['kpi_id'] == (empty($data['id']) ? $_GET['id'] : $data['id'])) echo "<h3>Add Metric under <em>".$kpi_item['kpi_name']."</em> KPI</h3>";
			endforeach;
		?>
		<?php
			$data = $this->session->flashdata('errors');
			if ($data['errors']) {
				echo $data['errors'];
			}
		?>
		<?php echo form_open('addMetric1'); ?>
		<input type="hidden" name="id" value="<?php echo (empty($data['id']) ? $_GET['id'] : $data['id']);?>"/>
		
		<table class="kpitable" id="metric">
			<tr>
			<td>Metric Name</td>
			</tr>
			<tr>
				<td><input name="metric_name"></input></td>
			</tr>
		</table>
		<button name="button" value="superuser_addbreakdown">Add Breakdown</button>
		<button name="button" value="superuser_edit">Done</button>
		</form>
	</div>
</div>