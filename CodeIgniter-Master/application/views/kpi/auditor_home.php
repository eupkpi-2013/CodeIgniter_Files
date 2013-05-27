<div id="user-contents" class="contents">
	<h1>Welcome, Auditor</h1>
	<div>
		<ul>Updates:
		<?php
			foreach($updates as $update){
				echo "<li>".$update['update_value']." / ".$update['timestamp']."</li>";
			}
		?>
		</ul>
	</div>
</div>