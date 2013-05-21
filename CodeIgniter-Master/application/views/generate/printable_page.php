<div id="user-header" class="header">
	<header>
		<a href="">
		<div id="user-banner" class="banner">
			<img src="img/up_small.png" class="lefted"/>
			<h1 class="lefted">eUP KPI</h1>
		</div>
		</a>
	</header>
</div>
<?php echo $highchart; ?>
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
</script>
<div class="contents">
<div id="container" class="slideshow" style="height:600px">
		<?php
			foreach($subkpis as $subkpi){
				echo "<br>";
				if($subkpi==$subkpis[0]){
					echo '<div id="container'.$subkpi[0]['kpi_id'].'" class="" ></div>';
				}
				else
					echo '<div id="container'.$subkpi[0]['kpi_id'].'" class="" ></div>';
			}
		?>
</div>