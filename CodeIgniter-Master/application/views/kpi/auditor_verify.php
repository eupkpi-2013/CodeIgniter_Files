<script>
	function buttoncheck(button_id)
	{
		$("#buttoncheck_id").val(button_id);
		$("#verifyform").attr('action', 'select');
		$("#verifyform").submit();
	}
</script>

<div id="user-contents" class="contents">	
	<?php if($active_result){?>
	<div id="user-inside" class="inside">
		<form method="post" id="verifyform" action="">
		<?php 
			if($checker=='notempty'){
				echo "<form method='post' id='verifyform' action=''>";
				foreach ($kpi as $kpi_item):
					echo "<div class='ratingsdiv'><h3>".$kpi_item['kpi_name']."</h3>";
						foreach ($subkpi as $subkpi_item):
							if($subkpi_item['parent_kpi']==$kpi_item['kpi_id'])
							{
								echo "<div>".$subkpi_item['kpi_name']."<table>";
									//$ctr = 0;
									foreach ($metric as $metric_item):
										if($metric_item['kpi_id']==$subkpi_item['kpi_id'])
										{
											
											echo "<tr>";
											echo "<td>".$metric_item['field_name']."</td>";
													
												if($subchecker=='uneditable')	
												{
													echo "<td>".$metric_item['value']."</td>";
												    echo "<td><input type='checkbox' value='".$metric_item['field_id']."/".$metric_item['value']."' name='valueselected[]'></td>";	
												} else if($subchecker=='approved')
												{
													echo "<td>".$metric_item['value']."</td>";
												} else
												{
													$exist = 0;
													foreach($editvalues as $editvalues_item):
														if($editvalues_item['field_id']==$metric_item['field_id'])
														{
															echo "<td><input type='text' name='edited[]' value='".$metric_item['value']."'><input type='hidden' name='edited_id[]' value='".$metric_item['field_id']."'></td>";
															echo "<td><input type='checkbox' checked></td>";
															$exist = 1;
														}
													endforeach;
													
													if($exist==0)
													{
														echo "<td>".$metric_item['value']."</td>";
												        echo "<td><input type='checkbox' value='".$metric_item['field_id']."/".$metric_item['value']."' name='valueselected[]'></td>";

													}
												}
												
											
											echo "<tr>";
										}
									//$ctr++;
									endforeach;
								echo "</table></div>";
							}
						endforeach;
					echo "</div>";
				endforeach;
				
					if($subchecker=='uneditable'):
			?>
					<input type="hidden" id="buttoncheck_id" name="buttoncheck_name" value="">
					<button class="righted" type="button" onclick="buttoncheck(1)">Edit Selected</button>
					<button class="righted" type="button" onclick="buttoncheck(2)">Reject Selected</button>
					<button class="righted" type="button" onclick="buttoncheck(3)">Approve All</button>
			
			<?php
					elseif($subchecker=='editable'):
			?>
					<input type="hidden" id="buttoncheck_id" name="buttoncheck_name" value="">
					<button class="righted" type="button" onclick="buttoncheck(4)">OK</button>
			<?php
					endif;
			?>
			</form>
			<?php
		    }
			else if($checker=="empty"){
				echo "<div class='alert alert-red'>Ratings not yet submitted</div>";
			}
			else if($checker=="verified"){
				echo "<div class='alert alert-red'>Ratings verified.</div>";
			}
		    ?>
	</div>
	<?php }
	else{
		echo '<div class="alert">Verify Module is closed.</div>';
	}	
	?>
</div>