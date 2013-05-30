<script>
	function generate(){
		<?php		echo 'var url="'.site_url().'/generate";';	?>
		window.location = url;
	}
	function viewreport(id){
		<?php		echo 'var url="'.site_url().'/report/" + id;';	?>
		window.location = url;
	}
</script>
<div id="user-contents" class="contents">
	<?php
		if(count($reports)==0){
			echo '<div class="alert">There are no reports available for viewing.</div>';
		}
		else{
	?>
	<h2>Reports</h2>
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
			echo "<tr onclick='viewreport(".$report['output_id'].")'>
					<td>".$report['output_name']."</td>
					<td>".$report['output_description']."</td>
					<td>".date('d-M-Y', $timestamp)."</td>
				 </tr>";
		}
	?>
	</table>
	<?php } ?>
	</div>
	
	<?php if(isset($account) && ($account==1 || $account==2)) echo '<button onclick="generate()" class="righted">Generate New Report</button>'; ?>
</div>