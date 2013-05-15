<div id="user-contents" class="contents">
		<div>
			<h3>Add New Account</h3>
			<?php echo validation_errors(); ?>
			<?php echo form_open('add_account'); ?>
				<label>First Name</label>
				<input type="text" id="fname" name="fname"></input>
				<label>Last Name</label>
				<input type="text" id="lname" name="lname"></input>
				<label>Gmail</label>			
				<input type="text" id="gmail" name="gmail"></input>
				<label>Confirm Gmail</label>			
				<input type="text" id="con_gmail" name="con_gmail"></input>
				<label>Unit</label>			
				<select name="iscu">
					<option>Please select</option>
					<?php
					foreach ($iscu->result() as $iscu_item):
						echo "<option>".$iscu_item->iscu."</option>";
					endforeach;
					?>
				</select>
				<label>Position</label>			
				<select name="account_name">
					<option>Please select</option>
					<?php
					foreach ($account_name->result() as $account_name_item):
						echo "<option>".$account_name_item->account_name."</option>";
					endforeach;
					?>
				</select>
				<button class="righted" type="submit">Add</button>
			<?php echo form_close(); ?>
		</div>
	<div></div>
</div>