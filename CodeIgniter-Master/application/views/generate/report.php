<script>
	function view_pdf(){
		// window.location = "generated/pdf";
		<?php		echo 'var url="'.site_url().'/generated/pdf/".concat("'.$output['output_id'].'");'	?>
		window.open(url, 'PDF preview', 'window settings');
	};
	function view_excel(){
		<?php		echo 'var url="'.site_url().'/generated/excel/".concat("'.$output['output_id'].'");'	?>
		window.location = url;
	};
	function view_txt(){
		// window.location = "generated/txt";
		<?php		echo 'var url="'.site_url().'/generated/txt/".concat("'.$output['output_id'].'");'	?>
		window.open(url, 'TXT preview', 'window settings');
	};
	function view_printable_page(){
		<?php		echo 'var url="'.site_url().'/generated/printablepage/".concat("'.$output['output_id'].'");'	?>
		window.open(url, 'Printable Preview', 'window settings');
	}
</script>
<script type="text/javascript">
	$(document).ready(function(){
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
		$(".visibleto-list input").change(function(){
			$("#savev-button").fadeIn();
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
		$(".visibleto-list").hide();
		$("#savev-button").hide();
	});
</script>
<script>
	function nextchart(){
		<?php
			reset($subkpis); 
			$currsub = current($subkpis);
			$end = end($subkpis);
			reset($subkpis); 
			while($currsub['kpi_id']!=$end['kpi_id']){
				$nextsub = next($subkpis);
				if($currsub==$subkpis[0]){
					echo 'if(!$("#container'.$currsub['kpi_id'].'").is(":hidden")){
								$("#container'.$currsub['kpi_id'].'").toggle();
								$("#container'.$nextsub['kpi_id'].'").toggle();
							}';
				}
				else{
					echo 'else if(!$("#container'.$currsub['kpi_id'].'").is(":hidden")){
								$("#container'.$currsub['kpi_id'].'").toggle();
								$("#container'.$nextsub['kpi_id'].'").toggle();
							}';
				}
				$currsub = current($subkpis);
			}
			if (count($subkpis)==1){
				echo 'if(!$("#container'.$currsub['kpi_id'].'").is(":hidden")){
								$("#container'.$currsub['kpi_id'].'").toggle();
								$("#container'.$subkpis[0]['kpi_id'].'").toggle();
							}';
			}
			else{
				echo 'else if(!$("#container'.$currsub['kpi_id'].'").is(":hidden")){
								$("#container'.$currsub['kpi_id'].'").toggle();
								$("#container'.$subkpis[0]['kpi_id'].'").toggle();
							}';
			}
		?>
	};
	function prevchart(){
		<?php
			reset($subkpis); 
			$currsub = current($subkpis);
			$end = end($subkpis);
			echo 'if(!$("#container'.$currsub['kpi_id'].'").is(":hidden")){
								$("#container'.$currsub['kpi_id'].'").toggle();
								$("#container'.$end['kpi_id'].'").toggle();
							}';
			reset($subkpis); 
			
			if(count($subkpis)>1){
				while(true){
					$currsub = next($subkpis);
					$prevsub = prev($subkpis);
					echo 'else if(!$("#container'.$currsub['kpi_id'].'").is(":hidden")){
								$("#container'.$currsub['kpi_id'].'").toggle();
								$("#container'.$prevsub['kpi_id'].'").toggle();
							}';
					next($subkpis);
					if($currsub['kpi_id']==$end['kpi_id']){
						break;
					}
				}
			}
		?>
	};
	function togglevisible(){
		$(".visibleto-list").slideToggle();
	}
	function savevisible(){
		var r = confirm("Save?");
		if(r==true){
			$("input").attr('disabled', false);
			$("#theform").submit();
		}
	}
	</script>
<div id="user-contents" class="contents">
	<?php echo $highchart; ?>
	<?php
		echo '<h3>'.$output['output_name'].'</h3>';
		$timestamp = strtotime($output['timestamp']);
		echo '<p>Published: '.date("F j, Y, g:i a", $timestamp).' by '.$user['fname'].' '.$user['lname'].'</p>';
		echo '<p>';
		echo '<button id="editv-button" onclick="togglevisible()">Edit</button>';
		echo '<button id="savev-button" onclick="savevisible()">Save</button>';
		echo 'Visible to: ';
		if($output['is_public'])
			echo 'Public';
		else{
			foreach($output_accounts as $account){
				echo $account['account_name'];
				if($account == end($output_accounts) && count($output_iscus)==0)
					echo "";
				else
					echo ", ";
			}
			foreach($output_iscus as $iscu){
				echo $iscu['iscu'];
				if($iscu != end($output_iscus))
					echo ", ";
			}
		}
		echo '</p>';
		echo '<ul class="visibleto-list"><form id="theform" action="'.site_url().'/report/'.$output['output_id'].'/changevisibleto" method="post">';
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
		echo '</ul></li><br>';
		echo '<ul class="iscu-list">';
		foreach($iscus as $iscu){
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
		echo '</ul>';
		echo '</form></ul>';
		echo '<p>'.$output['output_description'].'</p>';
	?>
	
	<div id="container" class="slideshow">
		<?php
			foreach($subkpis as $subkpi){
				if($subkpi==$subkpis[0]){
					echo '<div id="container'.$subkpi['kpi_id'].'" class="" style="height:500px"></div>';
				}
				else
					echo '<div id="container'.$subkpi['kpi_id'].'" class="" style="display:none;height:500px"></div>';
			}
		?>
		<div>
			<div class="lefted" onclick="prevchart()"><button class="slideshow-left">left</button></div>
			<div class="righted" onclick="nextchart()"><button class="slideshow-right">right</button></div>
		</div>
	</div>
	<div>
		<button onclick="view_txt()">Download TXT</button>
		<button onclick="view_excel()">Download Excel</button>
		<button onclick="view_pdf()">Download PDF</button>
		<button onclick="view_printable_page()">View Printable Page</button><br>
	</div>
</div>