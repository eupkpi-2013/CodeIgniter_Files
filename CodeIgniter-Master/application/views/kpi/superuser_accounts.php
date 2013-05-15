<div id="user-contents" class="contents">
	<div class="accountlist"><h2>List of Accounts:</h2>
		<div>
		<table>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Gmail</th>
			<th>Unit</th>
			<th>Position</th>
			<th>Status</th>
			<th></th>
		</tr>
		<?php
		foreach ($accounts->result() as $account_item):
			echo "<tr>";
			foreach ($account_item as $field):
				echo "<td>".$field."</td>";
			endforeach;
			echo '<td><a href=""><button>Edit</button></a><a href=""><button>Delete</button></a></td></tr>';
		endforeach;
		?>
		</table>
		<a href="superuser_addaccount"><button class="righted">Add an account</button></a>
		</div>
	</div>
	<div></div>
</div>