<div id="user-contents" class="contents">	
	
	<div id="user-kpimenu" class="accordion menu lefted">
	<?php foreach ($userid as $userid_item): 
		 echo "<div><a href='verify?q=auditor_verify_".$userid_item['user_id']."'><h3>".$userid_item['user_id']."</h3></a></div>"; 
	      endforeach; ?>
	</div>
	
	<div id="user-inside" class="inside">
		<?php 
			if($checker!='empty'): 
				foreach ($verifyvalue as $verifyvalue_item):
				
					echo "blahblah";
	
			 endforeach;
		
			else:
				echo "<h2>eUP KPI: After 2 months</h2><p>Choose a User on the left.</p><br>";
		
		    endif;
		?>
	</div>
</div>