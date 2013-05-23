<script type="text/javascript">
	$(document).ready(function() {
	  $("input[type='checkbox']").change(function () {
		$(this).siblings('ul')
			   .find("input[type='checkbox']")
			   .prop('checked', this.checked);
	  });
	});
</script>

<div id="user-contents" class="contents">
	<h3>Inactive KPIs:</h3>
	<?php echo form_open('shit'); ?>
	<input type="checkbox"  class="checklist">Select All</input>
	<ul class="indented-list">
		<?php
		foreach ($kpi->result() as $kpi_item):
			echo '<li><input type="checkbox" class="checklist">'.$kpi_item->kpi_name.'</input><br />';
			echo '<ul class="indented-list">';
			foreach ($subkpi->result() as $subkpi_item):
				if ($subkpi_item->parent_kpi == $kpi_item->kpi_id):
					echo '<li><input type="checkbox" class="checklist" name="subkpi[]" value="'.$subkpi_item->kpi_id.'">'.$subkpi_item->kpi_name.'</input><br />';
					echo '<ul class="indented-list">';
					foreach ($inactive->result() as $inactive_item):
						if ( $inactive_item->kpi_id == $subkpi_item->kpi_id ):
							echo '<li><input class="checklist" type="checkbox" name="metric['.$subkpi_item->kpi_id.'][]" value="'.$inactive_item->field_id.'">'.$inactive_item->field_name.'</input></li>';
						endif;
					endforeach;
					echo '</ul></li>';
				endif;
			endforeach;
			echo '</ul></li>';
		endforeach;
		?>
	</ul>
	<a href="superuser_activated"><button>Activate</button></a>
	<?php echo form_close(); ?>
</div>

</body>
</html>