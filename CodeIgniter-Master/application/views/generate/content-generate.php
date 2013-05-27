<script>
// $(document).ready(function(){
	// // window.location.replace("http://jquery4u.com");
	// $("#redirect").click(function(){
		// window.location = "http://jquery4u.com";
	// });
	
// });
function redirectme(){
	window.location = "http://jquery4u.com";
}
function generate(){
	if($("#name").val()==""){
		alert("Report Name!");
	}
	<?php
		echo "else if(";
		foreach($metrics as $metric){
			if($metric['field_id']!=$metrics[0]['field_id'])
				echo " && ";
			echo '!$("#checkfield'.$metric['field_id'].'").is(":checked")';
		}
		echo "){alert('Select at least 1 metric')}";
	?>
	<?php
		echo "else if(";
		foreach($results as $result){
			if($result['results_id']!=$results[0]['results_id'])
				echo " && ";
			echo '!$("#checkresult'.$result['results_id'].'").is(":checked")';
		}
		echo "){alert('Select at least 1 result')}";
	?>
	else if(!$("#charttype:checked").val()){
		alert('Select Chart Type!');
	}
	else{
		$("input").attr('disabled', false);
		$("#theform").submit();
	}
}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".checklist").change(function(){
			if ($(this).is(':checked')){
				$(this).parent().find($("input")).prop('checked', true);
			}
			else{
				$(this).parent().find($("input")).prop('checked', false);
			}
		});
		$("#checkpublic").change(function(){
			if ($(this).is(':checked')){
				$(".account-list").find($("input")).attr('checked', true);
				$(".account-list").find($("input")).attr('disabled', true);
				$(".iscu-list").find($("input")).attr('checked', true);
				$(".iscu-list").find($("input")).attr('disabled', true);
				$(this).attr('disabled', false);
			}
			else{
				$(".account-list").find($("input")).attr('checked', false);
				$(".account-list").find($("input")).attr('disabled', false);
				$(".iscu-list").find($("input")).attr('checked', false);
				$(".iscu-list").find($("input")).attr('disabled', false);
			}
		});
		<?php 
			if(isset($output) && $output['is_public']==1){
				echo '$("#checkpublic").attr("checked", true);
					$(".account-list").find($("input")).attr("checked", true);
					$(".account-list").find($("input")).attr("disabled", true);
					$(".iscu-list").find($("input")).attr("checked", true);
					$(".iscu-list").find($("input")).attr("disabled", true);'; 
			}
		?>
	});
</script>
<div id="user-contents" class="contents">
	<h2>Create a New Report</h2>
	<form id="theform" action="<?php echo site_url(); ?>/generated" method="post">
	 <?php 
		if(isset($message))
			echo "<div class='alert alert-red'>".$message."</div>";
	?>
	<label>Report Name</label> 
	<input id="name" name="name" class="input-medium" value="<?php if(isset($output)) echo $output['output_name']; ?>"></input>
	<label>Description</label>
	<textarea id="description" name="description"><?php if(isset($output)) echo $output['output_description']; ?></textarea>
	<br><br><label>Select values to be included:</label>
	<ul><li><input type="checkbox"  class="checklist">Select All</input><br>
	<?php
	foreach($kpis as $kpi){
		echo '<ul class="indented-list"><li><input type="checkbox"  class="checklist">'.$kpi['kpi_name'].'</input><br>';
		foreach($subkpis as $subkpi){
			if($subkpi['parent_kpi']==$kpi['kpi_id']){
				echo '<ul class="indented-list"><li><input type="checkbox"  class="checklist">'.$subkpi['kpi_name'].'</input><br>';
				foreach($metrics as $metric){
					if($metric['kpi_id']==$subkpi['kpi_id']){
						echo '<ul class="indented-list"><li><input id=checkfield'.$metric['field_id'].' name="checkfield'.$metric['field_id'].'" type="checkbox"  class="checklist" ';
						if(isset($output)){
							foreach($output_fields as $field){
								if($field['field_id'] == $metric['field_id'])
									echo 'checked';
							}
						}
						echo ' >'.$metric['field_name'].'</input><br>';
						echo'</li></ul>';
					}
				}
				echo'</li></ul>';
			}
		}
		echo'</li></ul>';
	}
	?>
	</ul>
	<label>Select Results:</label>
	<?php
		echo '<ul>';
		foreach($results as $result){
			echo '<li><input id="checkresult'.$result['results_id'].'" name="checkresult'.$result['results_id'].'"type="checkbox"  class="" ';
			if(isset($output)){
				foreach($output_results as $output_result){
					if($result['results_id'] == $output_result['results_id'])
						echo 'checked';
				}
			}
			echo ' >'.$result['results_name'].'</input><br>';
			echo'</li>';
		}
		echo '</ul>';
	?>
		
	<label>Type:</label>
		<?php
			echo '<ul>';
			foreach($output_types as $type){
				echo '<li><input type="radio" id="charttype" name="charttype" class="" value="'.$type['type_id'].'"';
				if(isset($output) && $output['output_type']==$type['type_id']){
					echo 'checked';
				}
				echo ' >'.$type['type_name'].'</input><br>';
				echo'</li>';
			}
			echo '</ul>';
		?>
		
	<label>Visible to:</label>
	<?php
		echo '<ul class=visibleto-list>';
		echo '<li><input id="checkpublic" name="checkpublic" type="checkbox" class="checklist">Public</input>';
		echo '<ul class="account-list">';
		foreach($accounts as $account){
			if($account['account_name']!="Boss" && $account['account_name']!="Superuser"){
				echo '<li><input id="checkaccount'.$account['account_id'].'" name="checkaccount'.$account['account_id'].'"type="checkbox"  class="" ';
				if(isset($output)){
					foreach($output_accounts as $output_account){
						if($account['account_id']==$output_account['accounts_id']){
							echo 'checked';
						}
					}
				}
				echo ' >'.$account['account_name'].'</input><br>';
				echo '</li>';
			}
		}
		echo '</ul></li>';
		echo '</ul>';
		echo '<ul class="iscu-list">';
		foreach($iscus as $iscu){
			if($iscu['iscu']!="Admin"){
				echo '<li><input class="checklist" id="checkiscu'.$iscu['iscu_id'].'" name="checkiscu'.$iscu['iscu_id'].'"type="checkbox"  class="" ';
				if(isset($output)){
					foreach($output_iscus as $output_iscu){
						if($iscu['iscu_id'] == $output_iscu['iscu_id'])
							echo 'checked';
					}
				}
				echo ' >'.$iscu['iscu'].'</input><br>';
				echo'</li>';
			}
		}
		echo '</ul>';
	?>
	<?php
		if(isset($output)){
			echo '<input name="outputid" type="hidden" value='.$output['output_id'].'></input>';
		}
	?>
	<!-- <label>Views:</label>
		<input type="checkbox">Account1</input><br>
		<input type="checkbox">Account2</input><br>
		<input type="checkbox">Account3</input><br> -->
	</form>
	<button onclick="generate()">Generate</button>	
</div>