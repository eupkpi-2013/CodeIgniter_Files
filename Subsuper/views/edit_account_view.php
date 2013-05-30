<div id="user-contents" class="contents">
	<form method="post" action="<?php echo base_url();?>index.php/subsuperuser/updateaccount<?php echo $query[0]->author_id; ?>" enctype="multipart/form-data">
		<div>
			<h3>Add New Account</h3>
			<label for = "afname">First Name</label>
			<input type = "text" name = "afname"></input>
			<label for = "alname">Last Name</label>
			<input type = "text" name = "alname"></input>
			<label fpr = "aemail">Email</label>			
			<input type = "text" name = "aemail"></input>
			<label>Position</label>			
			<select name = "position">
				<option value = "3" >Auditor</option>
				<option value = "5">User</option>
			</select>
		<button class = "righted">Add</button>
	</div>
</div>