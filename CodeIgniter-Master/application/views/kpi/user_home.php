<script>
	function toggleupdates(){
		<?php
			if(count($updates)>5){
				for($counter = 6; $counter<=count($updates); $counter++){
					echo '$("#listitem'.$counter.'").toggle();';
				}
			}
		?>
		if($("#updates-button").text()=='All Updates'){
			$("#updates-button").text('Less');
		}
		else{
			$("#updates-button").text('All Updates');
		}
		
	}
</script>
<div id="user-contents" class="contents">
	<h1>Welcome, User</h1>
	<div>
		<label>Updates</label>
		<table class="table-lined">
		<?php
			$counter = 1;
			foreach($updates as $update){
				if($counter>5)
					echo "<tr id='listitem".$counter."' hidden>";
				else	
					echo "<tr id='listitem".$counter."'>";
				echo "<td>".$update['update_value']."</td><td>by ".$update['fname']." ".$update['lname']."</td><td>".date('d M Y H:i',strtotime($update['timestamp']))."</td>";
				$counter++;
				echo '</tr>';
			}
		?>
		</table>
		<?php 
			if(count($updates)>5)
				echo "<button id='updates-button' class='button-blue button-small' onclick='toggleupdates()'>All Updates</button>";
		?>
	</div>
</div>