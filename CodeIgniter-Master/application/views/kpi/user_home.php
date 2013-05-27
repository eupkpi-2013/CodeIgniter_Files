<div id="user-contents" class="contents">
	<h1>Welcome, User</h1>
	<div>
		<ul>Updates:
		<?php
			foreach($updates as $update){
				echo "<li>".$update['update_value']." / by ".$update['user_id']." / ".$update['timestamp']."</li>";
			}
		?>
		</ul>
	</div>
</div>