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
		<?php
			$data = $this->session->flashdata('errors');
			if (empty($active)) {
				if (empty($data['id']) && empty($_GET['id'])) redirect('superuser_edit');
				$found = false;
				foreach ($kpi as $kpi_item):
					if ($kpi_item['kpi_id'] == (empty($data['id']) ? $_GET['id'] : $data['id'])):
						echo "<h3>Add SubKPI to ".$kpi_item['kpi_name']." KPI</h3>";
						$found=true;
					endif;
				endforeach;
				if (!$found) redirect('superuser_edit');
			
				if ($data['errors']) {
					echo $data['errors'];
				}
				echo form_open('addSubKPI');
				echo "<label>SubKPI Name</label>";
				echo '<input type="text" name="subkpi_name" /><br><br>';
				echo "<input type='hidden' name='id' value='".(empty($data['id']) ? $_GET['id'] : $data['id'])."/>";
				echo '<button class="left">Next</button>';
				echo '</form>';
			}
			else 
				echo '<h2>Currently active result: '.$active[0]['results_name'].'</h2><p>Adding of SubKPI is not allowed.</p>';
		?>
	</div>
</div>