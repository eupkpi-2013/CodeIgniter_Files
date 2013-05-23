<script>
function confirmDelete(id) {
	if (confirm("Do you really want to delete this account?\n(Take note that deleting an account is permanent)")) window.location="delete_account?q="+id;
}
</script>

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
		echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		foreach ($accounts->result() as $account_item):
			echo "<tr>";
			$skip = $account_item->user_id;
			foreach ($account_item as $field):
				if ($field === $skip) continue;
				else echo "<td class='accountentry'>".$field."</td>";
			endforeach;
			echo '<td class="accountentry"><a href="add_account?q='.$account_item->user_id.'"><button>'.($account_item->status_id == 'To confirm' ? 'Confirm' : 'Edit').'</button></a><button onclick="confirmDelete('.$account_item->user_id.')">Delete</button></td></tr>';
		endforeach;
		?>
		</table>
		<a href="superuser_addaccount"><button class="lefted button-green">Add an account</button></a>
		</div>
	</div>
	<div></div>
</div>



<!--<a href="delete_account?q='.$account_item->user_id.'">-->