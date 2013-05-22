<?php
		if(count($reports)==0){
			echo '<div class="alert">There are no reports available for viewing.</div>';
		}
		else{
	?>
	<div class="accountlist">
	<table class="wide-table">
	<tr class="table-lined">
	<th>Report Name</th>
	<th>Description</th>
	<th>Date Published</th>
	</tr>
	<?php
		foreach($reports as $report){
			$timestamp = strtotime($report['timestamp']);
			echo "<tr>
					<td><a href='report/".$report['output_id']."'>".$report['output_name']."</a></td>
					<td>".$report['output_description']."</td>
					<td>".date('d-M-Y', $timestamp)."</td>
				 </tr>";
		}
	?>
	</table>
	<?php } ?>
	</div>