<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion lefted">
		<?php
			$con = mysql_connect("localhost","root","lrmds");
				if (!$con) 
				{
					die('Could not connect: ' . mysql_error());
				}
				mysql_select_db("testkpi", $con);
				
			//query for kpi
			$result = mysql_query("SELECT * FROM kpi WHERE leaf_node=0");
			
				$sidebar = "";
				while($row = mysql_fetch_array($result)) {
					$sidebar .= "<div><h3>".$row['kpi_name']."</h3>";
					
					//query for sub kpi
					$ctr = 1;
					$parent = $row['kpi_id'];
					$result2 = mysql_query("SELECT * FROM kpi WHERE leaf_node=1 AND parent_kpi=$parent");
					$sidebar .= "<ul>";
					while($row2 = mysql_fetch_array($result2)) {
						$url_name1 = str_replace(" ","_", $row['kpi_name']);
						$url_name2 = str_replace(" ","_", $row2['kpi_name']);
						$sidebar .= "<div><li><a href='rate?q=".$url_name1."/".$url_name2."'>".$row2['kpi_name']."</a></li></div>";
					$ctr++;
					}
					$sidebar .= "</ul></div>";
					
				}
				
				echo $sidebar;
			
		?>
	</div>	
	<div id="user-inside" class="lefted">
		<?php
		$con = mysql_connect("localhost","root","lrmds");
				if (!$con) 
				{
					die('Could not connect: ' . mysql_error());
				}
				mysql_select_db("testkpi", $con);
				
			$q = $_GET['q'];
			$kpi = strtok($q,"/");
			$kpi = str_replace("_"," ", $kpi);
			$subkpi = strtok("/");
			$subkpi = str_replace("_"," ", $subkpi);
			
			$result = mysql_query("SELECT * FROM kpi WHERE kpi_name='$subkpi'");
			$row = mysql_fetch_array($result);
			$kpi_id = $row['kpi_id'];
			
			
			$result = mysql_query("SELECT * FROM fields WHERE kpi_id=$kpi_id");
			$metric = "<div id='user-inside' class='lefted'> <h2>".$kpi." > ".$subkpi."</h2> <table>";
			while($row = mysql_fetch_array($result)) {
				$metric .= "<tr><td>".$row['field_name']."</td><td><input type='text'></input></td></tr>";
			}
			$metric .= "</table><a href='user_rate_kpi1-2.html'><button class='righted'>Next</button></div>";
			
			echo $metric;
		?>
	</div>
	

</div>

<!--javascript-->
	<script>
		
	</script>
