<script type="text/javascript">
	function view_pdf(){
		// window.location = "generated/pdf";
		<?php		echo 'var url="generated/pdf/".concat("'.$output['output_id'].'");'	?>
		window.open(url, 'PDF preview', 'window settings');
	};
	function view_excel(){
		<?php		echo 'var url="generated/excel/".concat("'.$output['output_id'].'");'	?>
		window.location = url;
	};
	function view_txt(){
		// window.location = "generated/txt";
		<?php		echo 'var url="generated/txt/".concat("'.$output['output_id'].'");'	?>
		window.open(url, 'TXT preview', 'window settings');
	};
	function view_printable_page(){
		<?php		echo 'var url="generated/printablepage/".concat("'.$output['output_id'].'");'	?>
		window.open(url, 'Printable Preview', 'window settings');
	}
	
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
	
	function back(){
		<?php		echo 'var url="'.site_url().'/generate/".concat("'.$output['output_id'].'");'	?>
		window.location = url;
	}
	
	function publish(){
		var r = confirm("Publish?");
		<?php		echo 'var url="publish/".concat("'.$output['output_id'].'");'	?>
		if(r==true){
			window.location = url;
		}
	}
</script>

<div id="user-contents" class="contents">
	<h2>New Report Preview</h2>
	<?php
		echo "<h3>".$output['output_name']."</h3>";
		echo "<p>".$output['output_description']."</p>";
	?>
	<?php if(isset($highchart)): ?>
	<?php echo $highchart; echo ""; ?>
	<div id="container" class="slideshow" style="height:600px">
		<?php
			foreach($subkpis as $subkpi){
				if($subkpi==$subkpis[0]){
					echo '<div id="container'.$subkpi['kpi_id'].'" class="" ></div>';
				}
				else
					echo '<div id="container'.$subkpi['kpi_id'].'" class="" style="display:none"></div>';
			}
		?>
		<div class="lefted" onclick="prevchart()"><button class="slideshow-left">left</button></div>
		<div class="righted" onclick="nextchart()"><button class="slideshow-right">right</button></div>
	</div>
	<?php endif;?>
	<button onclick="view_txt()" class="lefted">View TXT</button>
	<button onclick="view_excel()" class="lefted">View Excel</button>
	<button onclick="view_pdf()" class="lefted">View PDF</button>
	<button onclick="view_printable_page()" class="lefted">View Printable Page</button>
	<button onclick="publish()" class="righted button-green">Publish</button>
	<button onclick="back()" class="righted">Edit</button>
	
	
</div>