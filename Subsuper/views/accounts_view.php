<div id="user-contents" class="contents">
	<div class="accountlist"><h2>List of Accounts:</h2>
		<div>
		<table>	
			<tr>
			<th>User ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Position</th>
			<th>Status</th>
			<th> </th>
			<th> </th>
			</tr>


			<?php

				foreach($query as $row) {


					$position = $row->account_id;

					if($position == 3) {
						$position = "Auditor";
					}
					elseif ($position == 5) {
						$position = "User";
					}

					$status = $row->status_id;

					if($status == 1) {
						$status = "Active";
					}
					elseif ($status == 2) {
						$status = "Inactive";
					}
					elseif ($status == 3) {
						$status = "To confirm";
					}

					print '<tr>';	
					print '<td>'.$row->user_id.'</td>';
					print '<td>'.$row->fname.'</td>';
					print '<td>'.$row->lname.'</td>';
					print '<td>'.$row->email.'</td>';
					print '<td>'.$position.'</td>';
					print '<td>'.$status.'</td>';

					echo '<td><a href = "'.base_url().'index.php/subsuperuser/editaccount/'.$row->user_id.'"><button>Edit</button></a></td>';
					echo '<td><a href = "'.base_url().'index.php/subsuperuser/accounts_/'.$row->user_id.'"><button>Delete</button></a></td>';
					echo '<td><a href = "'.base_url().'index.php/subsuperuser/accounts2/'.$row->user_id.'"><button>Deactivate</button></a></td>';
					print '</tr>';
				}
			?>
		</table>
		<a href=<?php print site_url('subsuperuser/addaccount');?>><button class = "righted">Add a user account</button></a>
		</div>
	</div>
</div>