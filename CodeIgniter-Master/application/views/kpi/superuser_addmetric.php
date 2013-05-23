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
			$data = $this->session->flashdata('errors');
			if ($data['errors']) {
				echo $data['errors'];
			}
		?>
		<button class="left" value="Add New Row" class="tablebuttons" onclick="addRow('metric')">Add Row</button>	
		<?php echo form_open('addMetric'); ?>
		<input type="hidden" name="id" value="<?php echo (empty($data['id']) ? $_GET['id'] : $data['id']);?>"/>
		
		<table class="kpitable" id="metric">
			<tr>
			<td>Metric Name</td>
			</tr>
			<tr>
				<td><input name="metric_name0"></input></td>
			</tr>
		</table>
		<button class="left">Save</button>
		</form>
	</div>
</div>

<script>


// Add Table Row
var currentRowCount=1;
function addRow(tableID) {
 
    var table = document.getElementById(tableID);
 
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
 
    var cell1 = row.insertCell(0);
    var element1 = document.createElement("input");
    element1.type = "text";
	element1.setAttribute("class", "ui-state-default");
	element1.setAttribute("name", "metric_name"+currentRowCount);
	cell1.appendChild(element1);
			
	table.rows[0].cells[0].childNodes[0].checked = false;
	currentRowCount++;
}
</script>