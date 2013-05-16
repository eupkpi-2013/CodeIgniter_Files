<div id="user-contents" class="contents">
	<h1>Welcome, Auditor</h1>
	<div>
		<ul>Unverified KPI submissions:
		<?php foreach ($update as $update_item):				
					if($update_item['account_id']==3)
					{
						echo "<li><a href='verify?q=auditor_verify_".$update_item['update_value']."'>".$update_item['update_value']."</a></li>";
					}
		      endforeach;
		?>
		</ul>
	</div>
	<div>
		<ul>Recent reports:
		<li><a href="auditor_results.html">Report1</a></li>
		<li><a href="auditor_results.html">Report2</a></li>
		<li><a href="auditor_results.html">Report3</a></li>
		</ul>
	</div>
</div>