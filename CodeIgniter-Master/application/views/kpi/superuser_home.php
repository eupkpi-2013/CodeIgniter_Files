<div id="user-contents" class="contents">
	<h1>Welcome, Superuser</h1>
	<h2>eUP KPI: After 2 months</h2>
	<div>
		<ul>Updates:
		<?php
			foreach($updates as $update){
				echo "<li>".$update['update_value']." / ".$update['timestamp']."</li>";
			}
		?>
		</ul>
		<a href="">Previous Updates</a>
	</div><br>	
	<button>Generate new report</button>
	<a href="superuser_addaccount"><button>Add a user account</button></a>
</div>