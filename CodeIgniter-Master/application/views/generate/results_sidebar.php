<div id="user-contents" class="contents">
	<div id="user-kpimenu" class="accordion menu lefted">
	<?php
		foreach($reports as $report){
			echo "<a href='report/".$report['output_id']."'><div><h3>".$report['output_name']."</h3></div></a>";
		}
	?>
	</div>