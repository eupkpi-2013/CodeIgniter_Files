<div id="user-contents" class="contents">
		<div>
			<h3>Add New Account</h3>
			<?php $edit = (isset($_GET['q']) ? true : false); ?>
			<?php echo validation_errors(); ?>
			<?php echo form_open(($edit ? 'add_account?q='.$_GET['q'] : 'add_account')); ?>
			<?php 
			if ($edit):
				$name = $this->user_db->get_accounts($_GET['q'])->result()[0];
				echo '<label>First Name</label>
				<input type="text" id="fname" name="fname" value="'.$name->fname.'"></input>
				<label>Last Name</label>
				<input type="text" id="lname" name="lname" value="'.$name->lname.'"></input>
				<label>Gmail</label>			
				<input type="text" id="gmail" name="gmail" value="'.$name->email.'"></input>
				<label>Confirm Gmail</label>			
				<input type="text" id="con_gmail" name="con_gmail" value="'.$name->email.'"></input>
				<label>Unit</label>
				<select id="iscu" name="iscu">
					<option>Please select</option>';
					foreach ($iscu->result() as $iscu_item):
						echo "<option ";
						if ($iscu_item->iscu==$name->iscu_id): echo 'selected="selected"';
						endif;
						echo ">".$iscu_item->iscu."</option>";
					endforeach;
				echo '</select>
				<label>Position</label>			
				<select id="account_name" name="account_name">
					<option>Please select</option>';
					foreach ($account_name->result() as $account_name_item):
						echo "<option ";
						if ($account_name_item->account_name==$name->account_id): echo 'selected="selected"';
						endif;
						echo ">".$account_name_item->account_name."</option>";
					endforeach;
					echo '</select>';
			else:
				echo '<label>First Name</label>
				<input type="text" id="fname" name="fname" value="'.set_value('fname').
				'"></input>
				<label>Last Name</label>
				<input type="text" id="lname" name="lname" value="'.set_value('lname').
				'"></input>
				<label>Gmail</label>			
				<input type="text" id="gmail" name="gmail" value="'.set_value('gmail').
				'"></input>
				<label>Confirm Gmail</label>			
				<input type="text" id="con_gmail" name="con_gmail" value="'.set_value('con_gmail').
				'"></input>
				<label>Unit</label>
				<select id="iscu" name="iscu">
					<option>Please select</option>';
					foreach ($iscu->result() as $iscu_item):
						echo "<option value='".$iscu_item->iscu."' ".set_select('iscu', $iscu_item->iscu, ($iscu_item->iscu==$name->account_id ? true : false)).">".$iscu_item->iscu."</option>";
					endforeach;
				echo '</select>
				<label>Position</label>			
				<select id="account_name" name="account_name">
					<option>Please select</option>';
					foreach ($account_name->result() as $account_name_item):
						echo "<option value='".$account_name_item->account_name."' ".set_select('account_name', $account_name_item->account_name, ($account_name_item->account_name==$name->account_id ? true : false)).">".$account_name_item->account_name."</option>";
					endforeach;
				echo '</select>';
			endif;
			?>
				<button class="righted" type="submit"><?php echo ($edit ? 'Confirm' : 'Add') ?></button>
			<?php echo form_close(); ?>
		</div>
	<div></div>
</div>

<script>
	$('#iscu').change(function() {
		var val = $("#iscu option:selected").text();
		if (val=='Admin') {
			$('#account_name').val('Superuser');
			$('#account_name').attr('disabled', 'disabled');
		}
		else {
			$('#account_name').prop('disabled', false);
			$('#account_name').val('Please Select');
		}
	});
	$('#account_name').change(function() {
		var val = $("#account_name option:selected").text();
		if (val=='Superuser') {
			$('#iscu').val('Admin');
			$('#iscu').attr('disabled', 'disabled');
		}
		else {
			$('#iscu').prop('disabled', false);
			$('#iscu').val('Please Select');
		}
	});
</script>