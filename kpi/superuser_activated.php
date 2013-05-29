<div id="user-contents" class="contents">
	<?php
		$data = $this->session->flashdata('errors');
		if (!empty($data)):
			echo $data['msg'];
			for ($i = 0; $i < count($data['active']); $i++) {
				if ($i==0) echo "<h3>Activated KPIs:</h3>";
				else if ($i==1) echo "<h3>Activated SubKPIs:</h3>";
				else echo "<h3>Activated Metrics:</h3>";
				echo "<ul class='indented-list'>";
				foreach ($data['active'][$i] as $name) echo "<li>".$name."</li>";
				echo "</ul>";
			}
		else: 
			$this->session->set_flashdata('errors', '<div class="alert alert-red">Activate KPI failed: No selected fields to activate</div>');
			header('location: superuser_activate');
		endif;
	?>
</div>
