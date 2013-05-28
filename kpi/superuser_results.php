<script>
function confirmDelete(id) {
	if (confirm("Do you really want to delete this account?\n(Take note that deleting an account is permanent)")) window.location="delete_account?q="+id;
}
</script>

<div id="user-contents" class="contents">
	<div class="accountlist">
		<?php
			if ($active) {
				echo "<h2>Currently active result: ".$active[0]['results_name']."</h2>";
			}
			else {
				echo "<h2>No active result</h2>";
				echo $this->session->flashdata('errors');
				echo form_open('activate_results');
				echo "<label>Result name<label>";
				echo "<input type='text' name='results_name'></input>";
				echo "<button>Activate Result</button>";
				echo form_close();
			}
		?>
	</div>
</div>



<!--<a href="delete_account?q='.$account_item->user_id.'">-->